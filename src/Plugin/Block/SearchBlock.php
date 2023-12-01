<?php

namespace Drupal\radicati_base\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a search form block.
 *
 * @Block(
 *   id = "rad_search_block",
 *   admin_label = @Translation("Search Form"),
 *   category = @Translation("radicati"),
 * )
 *
 */
class SearchBlock extends BlockBase {

  public function defaultConfiguration()
  {
    return [
      'action_route' => '/search',
    ];
  }

  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);

    $form['action_route'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Action Route'),
      '#description' => $this->t('The route to use for the search form action.'),
      '#default_value' => $this->configuration['action_route'],
    ];

    return $form;
  }

  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['action_route'] = $form_state->getValue('action_route');
  }

  public function build() {
    $build = [
      '#theme' => 'radicati_search_form',
      '#action_route' => $this->configuration['action_route'],
    ];
    return $build;
  }



  public function getCacheContexts() {
    return ['url.path'];
  }



}