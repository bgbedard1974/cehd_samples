<?php


namespace Drupal\cehd_components\Service;


use Drupal\taxonomy\Entity\Term;
use Drupal\Core\Entity\EntityInterface;
use Drupal\taxonomy\Entity\Vocabulary;

/**
 * Class TaxonomyService
 *
 * @package Drupal\cehd_components\Service
 * This class is used to access Taxonomy entities.
 */
class TaxonomyService {

  /**
   * Return a list of Taxonomy Terms in the given Vocabulary.
   *
   * @param string $vid Vocabulary ID
   *
   * @return \Drupal\taxonomy\Entity\Term[]
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  public function getTermsByVocabulary(string $vid): array {
    $handler = \Drupal::entityTypeManager()->getStorage('taxonomy_term');
    return $handler->loadTree($vid, 0, 1, false);
  }

  /**
   * Retrieves a Term by its name and given Vocabulary
   * @param string $name
   * @param string $vid
   *
   * @return \Drupal\Core\Entity\EntityInterface
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  public function getTermByName(string $name, string $vid): EntityInterface {
    $terms = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadByProperties(['name' => $name, 'vid' => $vid]);
    $key = array_key_first($terms);
    $term = $terms[$key];
    return $term;
  }


  /**
   * Create a new Taxonomy Term
   * @param $name
   * @param $vid
   *
   * @return Term
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  public function createTerm($name, $vid): EntityInterface {
    // Check if term already exists
    $term_check = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadByProperties(['name' => $name, 'vid' => $vid]);
    $term_check = reset($term_check);

    $term = null;

    if (!$term_check) {
      // Create term.
      $term = Term::create([
        'name' => $name,
        'vid' => $vid,
      ]);

      // Save term.
      $term->save();
    }

    // Return term.
    return $term;
  }

  /**
   * This method deletes all Taxonomy Terms in the given Vocabulary
   * @param $vid
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  public function deleteTermsByVocabulary($vid) {
    $handler = \Drupal::entityTypeManager()->getStorage('taxonomy_term');

    $query = \Drupal::entityQuery('taxonomy_term');
    $tids = $query->accessCheck(true)
      ->condition('vid', $vid)
      ->execute();

    if ($tids) {
      $terms = $handler->loadMultiple($tids);
      $handler->delete($terms);
    }

  }

  /**
   * This method deletes the given Vocabulary
   * @param $vid
   *
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  public function deleteVocabulary($vid) {
    $vocabulary = Vocabulary::load($vid);
    if ($vocabulary) {
      $vocabulary->delete();
    }
  }

}
