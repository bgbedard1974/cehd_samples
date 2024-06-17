<?php

namespace Drupal\cehd_components\Model;


/**
 * Interface RssFeedModelInterface
 * This interface is for Model Classes that want to process data from an RSS Feed.
 * These classes should exist in the module that uses them.
 *
 * @package Drupal\cehd_components\Model
 */
interface RssFeedModelInterface {

  public function getData();

}
