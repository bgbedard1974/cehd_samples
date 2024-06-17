<?php


namespace Drupal\carei_resources\Model;


/**
 * Class CategoryModel
 *
 * This class represents one Category
 *
 * @package Drupal\carei_resources\Model
 */
class CategoryModel {

  /* @var string The name of the Category */
  private $name;

  /* @var array The list of all Resources in this Category */
  private $resources;

  /**
   * Creates a Category.
   *
   * @param string $name The name of the Category
   * @param array $items The raw data of all Resources in the Group that contains the Category
   */
  public function __construct(string $name, array $items) {
    $this->name = $name;
    $this->resources = [];
    foreach ($items as $item) {
      if (in_array($name, $item['categories'])) {
        $this->resources[] = new ResourceModel($item);
      }
    }
  }

  /**
   * This function prepares the data in this class to be displayed.
   * @return array
   */
  public function getViewData(): array {
    $data = [];
    $data['name'] = $this->name;
    $data['items'] = [];
    foreach ($this->resources as $resource) {
      $data['items'][] = $resource->getViewData();
    }
    return $data;
  }

}
