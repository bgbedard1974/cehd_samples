<?php


namespace Drupal\carei_resources\Model;


use Drupal\cehd_components\Model\RssFeedModelInterface;


/**
 * Class RssFeedModel
 * This class is used to process an item from an RSS Feed.
 *
 * @package Drupal\carei_resources\Model
 */
class RssFeedModel implements RssFeedModelInterface {

  /** @var string The title of the Resource */
  private $title;
  /** @var string The url of the Resource */
  private $url;
  /** @var string The body of the Resource */
  private $description;
  /** @var array  The categories the Resource is in */
  private $categories;

  /**
   * RssFeedModel constructor.
   * This method processed the given XML Data.
   *
   * @param $xml_data
   * @param $content_ns
   */
  public function __construct($xml_data, $content_ns) {
    $this->title = $xml_data->title;
    $content = $xml_data->children($content_ns);
    $this->url = $content->conservancyLink;
    $this->description = $content->encoded;
    $this->categories = (array) $xml_data->category;
  }

  /**
   * This method returns the processed data.
   * @return array
   */
  public function getData() {
    return [
      'title' => $this->title,
      'url' => $this->url,
      'description' => $this->description,
      'categories' => $this->categories,
    ];
  }

}
