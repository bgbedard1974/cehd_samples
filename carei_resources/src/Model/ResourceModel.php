<?php


namespace Drupal\carei_resources\Model;


/**
 * Class ResourceModel
 * This class represents a Resource
 *
 * @package Drupal\carei_resources\Model
 */
class ResourceModel {

  /* @var string The title of the Resource */
  public $title;
  /* @var string The description of the Resource */
  public $description;
  /* @var string The URL of the Resource */
  public $url;
  /* @var array The Categories the Resource is a part of */
  public $categories;


  /**
   * ResourceModel constructor.
   *
   * @param array $data The raw data of the Resource
   */
  public function __construct(array $data) {
    $this->title = $data['title'];
    $this->description = $data['description'];
    // Trim excess whitespace from the end of the URL
    $this->url = rtrim($data['url']);
    $this->categories = $data['categories'];
  }

  /**
   * This function prepares the data to be displayed
   * @return array
   */
  public function getViewData(): array {
    return [
      'title' => $this->title,
      'description' => $this->description,
      'url' => $this->url
    ];
  }
}
