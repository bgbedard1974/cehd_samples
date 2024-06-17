<?php


namespace Drupal\cehd_components\Service;


use Drupal\cehd_components\Model\RssFeedModelInterface;


/**
 * Class RssFeedService
 * This class is a Service class for accessing RSS Feeds from other sites.
 *
 * @package Drupal\cehd_components\Service
 */
class RssFeedService {

  /**
   *  The content namespace in the RSS Feed
   */
  const CONTENT_NS = 'http://purl.org/rss/1.0/modules/content/';

  /**
   * This method fetches one item from the given RSS Feed.  It creates
   * an instance of the given Model Class to process the data and then it
   * retrieves that data from the class and returns it.
   *
   * @param string $rss_feed The RSS Feed to parse
   * @param string $model_class The Model class to create
   *
   * @return array|null
   */
  public function fetchSingle(string $rss_feed, string $model_class): ?array {
    $xml = simplexml_load_file($rss_feed, 'SimpleXMLElement', LIBXML_NOCDATA);
    $item = $xml->channel->item;
    $data = null;

    $model = new $model_class($item, self::CONTENT_NS);
    if ($model instanceof RssFeedModelInterface) {
      $data = $model->getData();
    }

    return $data;

  }


  /**
   * This method fetches multiple items from the given RSS Feed.  It creates
   * an instance of the given Model Class to process the data and then it
   * retrieves that data from the class and constructs an array of processed data.
   *
   * @param string $rss_feed The RSS Feed to parse
   * @param string $model_class The Model class to create
   *
   * @return array
   */
  public function fetchMultiple(string $rss_feed, string $model_class): array {
    $xml = simplexml_load_file($rss_feed, 'SimpleXMLElement', LIBXML_NOCDATA);
    $items = $xml->channel->item;
    $data = [];

    foreach ($items as $item) {
      $model = new $model_class($item, self::CONTENT_NS);
      if ($model instanceof RssFeedModelInterface) {
        $data[] = $model->getData();
      }
    }

    return $data;

  }

}
