<?php

namespace Drupal\system_config_update\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Controller for export json.
 */
class SystemConfigUpdate extends ControllerBase {

  /**
   * {@inheritdoc}
   */
  public function page_json($site_api_key, $nid) {
    // response initialization
    $response = array();

    // node object load
    $node =  Node::load($nid);
    if(\Drupal::config('system.site')->get('site_api_key') === $site_api_key && !empty($node) && $node->get('type')->target_id == 'page') {
      $response = array(
        'id' => $nid,
        'type' => $node->get('type')->target_id,
        'title' =>  $node->get('title')->value,
        'body' => $node->get('body')->value,
      );
      return new JsonResponse($response);
    } else {
      /**
       * return access_denied if site_api_key doesn't match and node doesn't exist or node type is page.
       */
      throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException(); 
    }
    
  }
}