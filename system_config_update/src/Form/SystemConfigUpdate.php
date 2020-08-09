<?php
namespace Drupal\system_config_update\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\system\Form\SiteInformationForm;

/**
 * site_api_key configuration
 */
class SystemConfigUpdate extends SiteInformationForm {
  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // retrieve the system.site configuration
    $site_config = $this->config('system.site');
    // get the parent SiteInformation form
    $form = parent::buildForm($form, $form_state);

    $form['site_information']['site_api_key'] = [
      '#type' => 'textfield',
      '#title' => t('Site API Key'),
      '#default_value' => empty($site_config->get('site_api_key')) ? 'No API Key' : $site_config->get('site_api_key'),
    ];

    // update button text if site_api_key exists
    if(\Drupal::config('system.site')->get('site_api_key')) {
      $form['actions']['submit']['#value'] = 'Update Configuration';
    }
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('system.site')->set('site_api_key', $form_state->getValue('site_api_key'))->save();
    parent::submitForm($form, $form_state);
  }
}