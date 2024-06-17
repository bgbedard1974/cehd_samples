<?php


namespace Drupal\carei_resources\Model;


use Drupal\Core\Url;


/**
 * Class GroupMenuModel
 * This class represents the Menu of all Groups for the Resources Page.
 *
 * @package Drupal\carei_resources\Model
 */
class GroupMenuModel {

  /* @var array The groups configuration data */
  public $groups;

  /**
   * GroupMenuModel constructor.
   *
   * @param array $groups Groups data
   */
  public function __construct(array $groups) {
    $this->groups = $groups;
  }

  /**
   * This function creates URLs and prepares the data to be displayed
   * @return array
   */
  public function getViewData():array {
    $data = [];

    foreach ($this->groups as $id => $group) {
      $data[] = [
        'url' => URL::fromRoute('carei_resources.page', ['group_id' => $id]),
        'text' => $group['name']
      ];
    }

    return $data;
  }
}
