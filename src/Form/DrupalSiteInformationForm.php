<?php

namespace Drupal\drupal_site_api_key\Form;

// Classes referenced in this class:
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\ConfigFormBase;
// This is the form being extended:
use Drupal\system\Form\SiteInformationForm;

/**
 * Configure site information settings for this site.
 */
class DrupalSiteInformationForm extends SiteInformationForm {

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state) {
        // Retrieve the system.site configuration
        $site_config = $this->config('system.site');
        // Add Site API Key field to 'Site Information' section
        $site_api_key = \Drupal::config('drupal_site_api_key.configuration')->get('siteapikey');
        // Get the original form from the class we are extending
        $form = parent::buildForm($form, $form_state);
        // Add a textfield to the site information section of the form
        $form['site_information']['siteapikey'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Site api key'),
            '#default_value' => $site_config->get('siteapikey') ? $site_config->get('siteapikey') : $site_api_key,
            '#description' => $this->t('The api key of the site'),
        ];
        if ($site_config->get('siteapikey')) {
            $form['actions']['#type'] = 'actions';
            $form['actions']['submit'] = [
                '#type' => 'submit',
                '#value' => $this->t('Update configuration'),
                '#button_type' => 'primary',
            ];
        }

        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {
        $config = $this->config('system.site');
        // The site apikey is retrieved from the submitted form values
        // and saved to the 'siteapikey' element of the system.site configuration.
        $site_api_key = $form_state->getValue('siteapikey');
        $config->set('siteapikey', $site_api_key);
        // Save the configuration
        $config->save();
        if ($site_api_key) {
            $this->messenger()->addStatus($this->t('Site API Key has been saved with that value: ' . "$site_api_key"));
        }
        // Pass the remaining values off to the parent form that is being extended,
        // so that that the parent form can process the values.
        parent::submitForm($form, $form_state);
    }

}
