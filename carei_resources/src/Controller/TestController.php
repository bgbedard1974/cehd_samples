<?php

namespace Drupal\carei_resources\Controller;


//use Drupal\carei_resources\Entity\ResourceCategoryGroup;
//use Drupal\carei_resources\Utility\Configuration;
use Drupal\Core\Controller\ControllerBase;

/**
 * Class TestController
 *
 * @package Drupal\carei_resources\Controller
 *
 * Controller to used to test code.
 */
class TestController extends ControllerBase {

  /**
   * Controller method to create content for the page.
   *
   * @return array Drupal render array for the templating system
   */
  public function view(): array {
    $html = "";
    $rss_feed = 'https://research.cehd.umn.edu/carei/content-area-feed/';

    $xml_service = \Drupal::service('carei_resources.xml_service');
    $xml_data = $xml_service->parse($rss_feed);

    $html .= sprintf("XMLService: Found (%d) items.<br/>", count($xml_data));

    $rss_service = \Drupal::service('cehd_components.rss_feed_service');
    $rss_data = $rss_service->fetchMultiple($rss_feed, '\Drupal\carei_resources\Model\RssFeedModel');

    $html .= sprintf("RssFeedService: Found (%d) items.<br/>", count($rss_data));

    return [
      '#markup' => $html
    ];
  }

}
