<?php

namespace Drupal\radicati_base\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a UI element that allows the user to scroll back to the top of the page.
 *
 * @Block(
 *   id = "rad_back_to_top_block",
 *   admin_label = @Translation("Back to Top Block"),
 *   category = @Translation("radicati"),
 * )
 *
 */
class BackToTopBlock extends BlockBase {

  public function defaultConfiguration() {
    return [];
  }

  public function build() {
    $build = [
      '#theme'  => 'radicati_back_to_top',
    ];

    return $build;
  }
}