<?php


namespace Drupal\cehd_components\Form;


use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class ConfigForm
 * This class provides the form for the Config page.
 *
 * @package Drupal\cehd_components\Form
 */
class ConfigForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'cehd_components_config';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'cehd_components.config',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('cehd_components.config');

    $form['node_access'] = array(
      '#type' => 'radios',
      '#title' => $this->t('Node Access'),
      '#description' => $this->t('Enable or disable node access functionality.'),
      '#default_value' => $config->get('node_access'),
      '#options' => ['enabled' => 'enabled', 'disabled' => 'disabled'],
    );

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Retrieve the configuration
    $editable_config = $this->configFactory->getEditable('cehd_components.config');
    // Set the submitted configuration setting
    $editable_config->set('node_access', $form_state->getValue('node_access'));
    // Save the configuration
    $editable_config->save();

    parent::submitForm($form, $form_state);
  }
}
