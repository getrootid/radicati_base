<?php

namespace Drupal\radicati_base\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\link\Plugin\Field\FieldFormatter\LinkFormatter;

/**
 * Plugin implementation of the 'radicati_link_button_formatter' formatter.
 *
 * @FieldFormatter(
 *   id = "radicati_link_button_formatter",
 *   label = @Translation("Radicati: Link Button"),
 *   field_types = {
 *     "link"
 *   }
 * )
 */
class RadicatiLinkButtonFormatter extends LinkFormatter {
  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];


    foreach ($items as $delta => $item) {
      $url = $this->buildUrl($item);

      // Create a wrapper that can be templated in the theme layer.
      $elements[$delta] = [
        '#theme' => 'radicati_link_button',
        '#title' => $item->title,
        '#url' => $url
      ];


      // Prepare default link:
      $link = [
        '#type' => 'link',
        '#title' => $item->title,
        '#url' => $url
      ];

      $values = $item->getValue();

      if(!empty($values['options'])) {
        $attributes = [];
        $buttonTerm = $values['options']['button_type'];
        $buttonTerm = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->load($buttonTerm);
        $buttonClass = $buttonTerm->get('field_setting_class')->value;

        $attributes['class'] = $buttonClass;
        $elements[$delta]['#button_class'] = $buttonClass;

        if($values['options']['new_tab']) {
          $attributes['new_tab'] = true;
          $elements[$delta]['#target'] = '_blank';
        }

        $link['#options']['attributes'] = $attributes;
        $elements[$delta]['#link'] = $link;
      }
    }
    return $elements;
  }
}