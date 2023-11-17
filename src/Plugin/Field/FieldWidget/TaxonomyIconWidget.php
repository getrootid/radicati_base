<?php

namespace Drupal\radicati_base\Plugin\Field\FieldWidget;

use Drupal\Core\Field\Plugin\Field\FieldWidget\OptionsWidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;

/**
 * Plugin implementation of the 'taxonomy_icon_widget' widget.
 *
 * @FieldWidget(
 *   id = "taxonomy_icon_widget",
 *   label = @Translation("Taxonomy Icon Widget"),
 *   field_types = {
 *     "entity_reference"
 *   },
 *   multiple_values = TRUE
 * )
 */
class TaxonomyIconWidget extends OptionsWidgetBase
{
  /**
   * Displays a form element for a taxonomy field. Uses radio buttons
   * and replaces the title of the taxonomy term with an icon if the
   * field_setting_icon field is set.
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element = parent::formElement($items, $delta, $element, $form, $form_state);

    // This returns one of the most unhelpful lists  I've ever seen. The person
    // who made this is probably mean. They give out apples on Halloween.
    $options = $this->getOptions( $items->getEntity() );
    $selected = $this->getSelectedOptions($items);
    $newOptions = [];
    $allHaveIcons = true;

    foreach($options as $key => $val) {
      // The key is the taxonomy term id. Load that term and check the field_setting_icon	field for a value.
      // If there is one, generate a new option using the same term id, but with the font awesome icon
      // instead of the default one. If any field doesn't have a value set for field_setting_icon, flag it
      // and just output the normal list instead.

      if($key == '_none') {
        $markup = '<div class="taxonomy-icon-widget__icon-wrapper"><i class="fa fa-times"></i>';
        $markup .= '<div class="taxonomy-icon-widget__label">' . $this->getEmptyLabel() . '</div></div>';
        $newOptions[$key] = new TranslatableMarkup($markup);

      } else {
        $term = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->load($key);
        $icon = $term->get('field_setting_icon')->value;
        if($icon) {
          $markup = '<div class="taxonomy-icon-widget__icon-wrapper"><i class="' .
            $icon . '"></i><div class="taxonomy-icon-widget__label">' .
            $term->label() . '</div></div>';

          $newOptions[$key] = new TranslatableMarkup($markup);
        } else {
          $allHaveIcons = false;
          break;
        }
      }
    }

    if(!$allHaveIcons)
      $newOptions = $options;

    // Build the form element. And load the font awesome library from the theme: radicati_drupal/font-awesome
    // Add a class to show if there are icons or not.
    $element += [
      '#type' => 'radios',
      '#options' => $newOptions,
      '#default_value' => $selected ? reset($selected) : NULL,
      '#attributes' => [
        'class' => [
          'taxonomy-icon-widget',
          $allHaveIcons ? 'taxonomy-icon-widget--has-icons' : 'taxonomy-icon-widget--no-icons',
        ],
      ],
      '#attached' => [
        'library' => [
          'radicati_base/taxonomy-icon-widget',
        ],
      ],
    ];

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  protected function getEmptyLabel() {
    if (!$this->required && !$this->multiple) {
      return $this->t('Not Set');
    }
  }
}