<?php

namespace Drupal\radicati_base\Plugin\Field\FieldWidget;


use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\link\Plugin\Field\FieldWidget\LinkWidget;

/**
 * Formats a link field as a button. Uses the settings taxonomy to
 * fill in the button options.
 *
 * @FieldWidget(
 *   id = "radicati_link_button_widget",
 *   label = @Translation("Radicati: Link Button"),
 *   field_types = {
 *     "link"
 *   }
 * )
 */
class RadicatiLinkButtonWidget extends LinkWidget {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element = parent::formElement($items, $delta, $element, $form, $form_state);
    $vid = 'settings';

    // Check if the settings taxonomy exists and has a Button Types top level term.
    // If it does, use that to populate the button type options.
    $buttonTypesParent = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadByProperties([
      'vid' => $vid,
      'name' => 'Button Types',
    ]);

    if(empty($buttonTypesParent)) {
      return $element;
    }
    $buttonTypesParent = array_shift($buttonTypesParent);

    // Buttons types do exist, get all the children of the Button Types term.
    $terms = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadTree($vid, $buttonTypesParent->id());

    if(empty($terms)) {
      return $element;
    }

    $element['options'] = [
      '#type' => 'details',
      '#title' => $this->t('Button Link Options'),
      '#open' => TRUE,
    ];

    $options = [];
    foreach($terms as $term) {
      $options[$term->tid] = $term->name;
    }

    $element['options']['button_type'] = [
      '#type' => 'select',
      '#title' => $this->t('Button Type'),
      '#default_value' => $items[$delta]->options['button_type'] ?? 'default',
      '#description' => $this->t('Select the type of the button.'),
      '#options' => $options,
    ];

    $element['options']['new_tab'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Open in new tab'),
      '#default_value' => $items[$delta]->options['new_tab'] ?? false,
      '#description' => $this->t('Causes this button to open in a new tab. This should rarely be used as the user expects links to open in the current tab.'),
    ];

    return $element;
  }

}
