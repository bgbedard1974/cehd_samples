<?php


namespace Drupal\cehd_components\Service;


use Drupal\node\Entity\Node;

/**
 * Class NodeService
 *
 * @package Drupal\cehd_components\Service
 *
 * Used to access Drupal Node Entities
 */
class NodeService {

  /**
   * Returns a list of Nodes that match a given Node Type
   *
   * @param string $node_type The node type to search for
   *
   * @return \Drupal\node\Entity\Node[]
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  public function getNodesByType(string $node_type): array {
    $handler = \Drupal::entityTypeManager()->getStorage('node');
    $query = $handler->getQuery();
    $nids = $query->accessCheck(true)
      ->condition('type', $node_type)
      ->execute();
    return $handler->loadMultiple($nids);
  }

  /**
   * This method creates a node using the given Node data.
   * @param $node_data
   *
   * @return \Drupal\Core\Entity\EntityBase|\Drupal\Core\Entity\EntityInterface|null
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  public function createNode($node_data) {

    $handler = \Drupal::entityTypeManager()->getStorage('node');
    $query = $handler->getQuery();
    $nids = $query->accessCheck(true)
      ->condition('type', $node_data['type'] )
      ->condition('title', $node_data['title'])
      ->execute();

    $node = null;

    if (!empty($nids)) {
      // Load existing node
      $nid = $nids[array_key_first($nids)];
      $node = $handler->load($nid);
    } else {
      // Create node
      $node = Node::create($node_data);
      // Save node
      $node->save();
    }

    // Return node
    return $node;
  }

  /**
   * This method deletes all nodes of the given Content Type
   * @param $type
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  public function deleteNodesByType($type) {
    $handler = \Drupal::entityTypeManager()->getStorage('node');

    $query = \Drupal::entityQuery('node');
    $nids = $query->accessCheck(true)
      ->condition('type', $type)
      ->execute();

    if ($nids) {
      $nodes = $handler->loadMultiple($nids);
      $handler->delete($nodes);
    }
  }

  /**
   * This method deletes the given Content Type
   * @param $type
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  public function deleteContentType($type) {
    $content_type = \Drupal::entityTypeManager()->getStorage('node_type')->load($type);
    if ($content_type) {
      $content_type->delete();
    }
  }

}
