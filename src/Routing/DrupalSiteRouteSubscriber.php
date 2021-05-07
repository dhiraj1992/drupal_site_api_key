<?php

namespace Drupal\drupal_site_api_key\Routing;

// Classes referenced in this class
use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

/**
 * Listens to the dynamic route events.
 */
class DrupalSiteRouteSubscriber extends RouteSubscriberBase {

    /**
     * {@inheritdoc}
     */
    protected function alterRoutes(RouteCollection $collection) {
        // Change form for the system.site_information_settings route
        // call only on the system.site_information_settings route.
        if ($route = $collection->get('system.site_information_settings')) {
            //override form.
            $route->setDefault('_form', 'Drupal\drupal_site_api_key\Form\DrupalSiteInformationForm');
        }
    }

}
