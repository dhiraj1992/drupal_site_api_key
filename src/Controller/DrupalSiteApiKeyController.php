<?php

/**
 * @file
 * Contains \Drupal\drupal_site_api_key\Controller\SiteApiKeyController.
 */

namespace Drupal\drupal_site_api_key\Controller;

use Drupal\node\NodeInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class DrupalSiteApiKeyController {

    /**
     * @param $site_api_key - the API key parameter
     * @param NodeInterface $node - the node built from the node id parameter
     * @return JsonResponse
     */
    public function content($site_api_key, NodeInterface $node) {
        // Site API Key configuration value
        $site_api_key_config = \Drupal::config('system.site')->get('siteapikey');
        // Make sure the supplied node is a page, the configuration key is set and matches the supplied key
        if ($node->getType() == 'page' && $site_api_key_config != 'No API Key yet' && $site_api_key_config == $site_api_key) {
            // return json response
            return new JsonResponse($node->toArray(), 200, ['Content-Type' => 'application/json']);
        }
        // return access denied
        return new JsonResponse(array("error" => "access denied"), 401, ['Content-Type' => 'application/json']);
    }

}
