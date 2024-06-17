<?php


namespace Drupal\carei_resources\Model;


/**
 * Class GroupModel
 * This class represents one Group
 *
 * @package Drupal\carei_resources\Model
 */
class GroupModel {

  /* @var string The name of the Group */
  private $name;
  /* @var array The list of Categories in the Group */
  private $categories;
  /* @var string The URL of the RSS feed for the Group */
  private $xml_file;
  /* @var array The raw data for all Resources in the Group */
  private $data;
  /* @var bool Indicates if the Group exists or not */
  private $is_valid;

  /**
   * GroupModel constructor.
   *
   * @param string $id The Group ID
   * @param array $groups Groups data
   */
  public function __construct(string $id, array $groups) {

    if (array_key_exists($id, $groups)) {
      $this->is_valid = true;
      $group = $groups[$id];
      $this->name = $group['name'];

      $this->xml_file = $group['xml'];

      //$xml_service = \Drupal::service('carei_resources.xml_service');
      //$this->data = $xml_service->parse($this->xml_file);

      $rss_service = \Drupal::service('cehd_components.rss_feed_service');
      $this->data = $rss_service->fetchMultiple($this->xml_file, '\Drupal\carei_resources\Model\RssFeedModel');

      $this->categories = [];

      foreach ($group['categories'] as $category) {
        $this->categories[] = new CategoryModel($category, $this->data);
      }
    } else {
      $this->is_valid = false;
    }

  }

  /**
   * This function prepares the data to be displayed
   * @return array
   */
  public function getViewData(): array {
    $data = [];
    $data['name'] = $this->name;
    $data['items'] = [];
    foreach ($this->categories as $category) {
      $data['items'][] = $category->getViewData();
    }
    return $data;
  }

  /**
   * This function indicates if the Group exists or not
   * @return bool
   */
  public function isValid(): bool {
    return $this->is_valid;
  }

}
