<?php

namespace Drupal\radicati_base\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a toggle button block that can be used to do things like open
 * off-canvas menu or display a modal or search form.
 *
 * @Block(
 *   id = "rad_button_block",
 *   admin_label = @Translation("Toggle Button"),
 *   category = @Translation("radicati"),
 * )
 *
 */
class ButtonBlock extends BlockBase {

  public function defaultConfiguration() {
    return [
      'icon_classes' => '',
      'icon_classes_active' => '',
      'button_id' => '',
      'button_label' => '',
      'button_label_display' => 'none',
      'aria_controls' => '',
      'handle_click' => TRUE,
    ];
  }
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildConfigurationForm($form, $form_state);

    $form['button_label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#required' => TRUE,
      '#description' => $this->t('The text that describes the action of the button. Something like "show menu" or "search"'),
      '#default_value' => $this->configuration['button_label'],
    ];

    $form['button_label_display'] = [
      '#type' => 'select',
      '#title' => $this->t('Label Display'),
      '#required' => TRUE,
      '#description' => $this->t('Where to display the label in relation to the icon. If display is set to none it will only be visually hidden and will still be used for screen readers.'),
      '#options' => [
        'label-visually-hidden' => $this->t('None'),
        'label-left' => $this->t('Left'),
        'label-right' => $this->t('Right'),
        'label-top' => $this->t('Top'),
        'label-bottom' => $this->t('Bottom'),
      ],
      '#default_value' => $this->configuration['button_label_display'],
    ];

    $form['button_id'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Button ID'),
      '#required' => TRUE,
      '#description' => $this->t('The id of the button. Needed for triggering actions in javascript when this button is pressed.'),
      '#default_value' => $this->configuration['button_id'],
    ];

    $form['icon_classes'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Icon Classes'),
      '#description' => $this->t('If set a i tag will be added to the button with this value, useful for having Font Awesome icons.'),
      '#default_value' => $this->configuration['icon_classes'],
    ];

    $form['icon_classes_active'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Icon Classes Active'),
      '#description' => $this->t('If set the button icon will be replaced with this when it has been clicked.'),
      '#default_value' => $this->configuration['icon_classes_active'],
    ];

    $form['aria_controls'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Aria Controls'),
      '#description' => $this->t('The id of the element that this button controls. Useful for things like off-canvas menus.'),
      '#default_value' => $this->configuration['aria_controls'],
    ];

    $form['handle_click'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Handle Click'),
      '#description' => $this->t('If unchecked the default click handler wont be used. Useful for cases where the theme has to do extra things when a button is clicked.'),
      '#default_value' => $this->configuration['handle_click'],
    ];

    return $form;
  }

  public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
    $this->configuration['icon_classes'] = $form_state->getValue('icon_classes');
    $this->configuration['icon_classes_active'] = $form_state->getValue('icon_classes_active');
    $this->configuration['button_id'] = $form_state->getValue('button_id');
    $this->configuration['button_label'] = $form_state->getValue('button_label');
    $this->configuration['button_label_display'] = $form_state->getValue('button_label_display');
    $this->configuration['aria_controls'] = $form_state->getValue('aria_controls');
    $this->configuration['handle_click'] = $form_state->getValue('handle_click');
  }



  public function build() {
    $build = [
      '#theme'  => 'radicati_button',
      '#icon_classes' => $this->configuration['icon_classes'],
      '#icon_classes_active' => $this->configuration['icon_classes_active'],
      '#button_label' => $this->configuration['button_label'],
      '#button_id' => $this->configuration['button_id'],
      '#label_display' => $this->configuration['button_label_display'],
      '#aria_controls' => $this->configuration['aria_controls'],
      '#handle_click' => $this->configuration['handle_click'],
    ];

    if($this->configuration['handle_click']) {
      $build['#attached']['library'][] = 'radicati_base/radicati-button-block';
    }

    return $build;
  }
}