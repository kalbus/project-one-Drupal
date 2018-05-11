<?php

namespace Drupal\pais\Plugin\Field\FieldFormatter;

use Drupal\Component\Utility\Html;
use Drupal\Core\Field\FieldItemInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'pais_formatter_type' formatter.
 *
 * @FieldFormatter(
 *   id = "pais_formatter_type",
 *   label = @Translation("Pais formatter type"),
 *   field_types = {
 *     "pais_field_type"
 *   }
 * )
 */
class PaisFormatterType extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'nombre_pais'=> ''
      // Implement default settings.
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $formulario = parent::settingsForm($form, $form_state);
    $formulario['path_view'] = [
      '#type' => 'textfield',
      '#title' => $this -> t('Nombre del país'),
      '#defaullt_value' => $this -> getSetting('nombre_pais'),
      '#maxlength' => 128,
      '#required' => TRUE
    ];
    return $formulario;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];
    // Implement settings summary.
    if(!empty($this->getSetting('nombre_pais'))){
      $summary[] =
        $this -> t('El nombre del pais es @path',
          ['@path' => $this -> getSetting('nombre_pais')]);
    }
    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    /*$elements = [];

    foreach ($this -> getEntitiesToView($items, $langcode) as $delta => $item){
      $elements[$delta] = ['#markup' => $this->viewValue($item)];
    }
    return $elements;*/
    $elements = [];

    foreach ($items as $delta => $item) {
      $elements[$delta] = ['#markup' => $this->viewValue($item)];
    }

    return $elements;
  }

  /**
   * Generate the output appropriate for one field item.
   *
   * @param \Drupal\Core\Field\FieldItemInterface $item
   *   One field item.
   *
   * @return string
   *   The textual output generated.
   */
  protected function viewValue(FieldItemInterface $item) {
    // The text value has no text format assigned to it, so the user input
    // should equal the output, including newlines.
    $lista = \Drupal::service('country_manager')-> getList();
    $nombre_pais = $lista[$item->value];
    return $nombre_pais;
    //return nl2br(Html::escape($item->value));
  }

}
