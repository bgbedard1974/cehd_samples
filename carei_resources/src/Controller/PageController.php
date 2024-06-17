<?php

namespace Drupal\carei_resources\Controller;


use Drupal\carei_resources\Model\GroupMenuModel;
use Drupal\carei_resources\Model\GroupModel;
use Drupal\Core\Controller\ControllerBase;


/**
 * Class PageController
 *
 * @package Drupal\carei_resources\Controller
 *
 * Controller for the Resources Page.
 */
class PageController extends ControllerBase {

  /**
   * Generate the content for the Resources Page for the given Resource Group ID.
   *
   * @param string $group_id The ID representing which Group to render content for
   *
   * @return array Drupal render array to pass to the templating system.
   */
   public function view(string $group_id): array {
     // Get group information
     $config = \Drupal::config('carei_resources.groups');
     $groups = $config->get('groups');

     // Create Group
     $group = new GroupModel($group_id, $groups);

     // Create Menu
     $group_menu = new GroupMenuModel($groups);

     // Prepare data for output
     $data = [];
     $data['#theme'] = 'group_accordion_view';
     $data['#menu'] = $group_menu->getViewData();
     if ($group->isValid()) {
       $data['#group'] = $group->getViewData();
     } else {
       $data['#group'] = null;
       $data['#before'] = '<p><strong>Error</strong><br />No Resources Found.</p>';
     }

    return $data;
  }

}
