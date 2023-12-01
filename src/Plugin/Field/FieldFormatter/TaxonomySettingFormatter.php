<?php

namespace Drupal\radicati_base\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;


/**
 * Adds a display formatter that lets you add classes to an entity based on taxonomy field names.
 * The class will omit the field_ from the start of the field machine name. So, a field that is named
 * field_background_color, and has a value of red will output as background-color--red.
 *
 * @FieldFormatter(
 *   id = "rad_tax_setting",
 *   label = @Translation("Component Setting"),
 *   field_types = {
 *     "entity_reference"
 *   }
 * )
 */
class TaxonomySettingFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];
    $summary[] = $this->t('Outputs a taxonomy term as a component setting.');

    return $summary;
  }

  public static function defaultSettings()   {
    return parent::defaultSettings();
  }

  public function settingsForm(array $form, FormStateInterface $form_state) {
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    return [];
  }

}
