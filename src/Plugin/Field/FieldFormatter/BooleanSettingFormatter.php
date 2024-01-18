<?php

namespace Drupal\radicati_base\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;


/**
 * Adds a display formatter that lets you add classes to an entity based on whether
 * a checkbox is checked.
 *
 * The heavy lifting is done in the .module file!
 *
 * @FieldFormatter(
 *   id = "rad_boolean_setting",
 *   label = @Translation("Component Setting"),
 *   field_types = {
 *     "boolean"
 *   }
 * )
 */
class BooleanSettingFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];
    $summary[] = $this->t('Outputs a boolean field as a component setting.');

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
