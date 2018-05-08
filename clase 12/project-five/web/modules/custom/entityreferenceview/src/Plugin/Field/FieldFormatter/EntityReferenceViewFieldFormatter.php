<?php

namespace Drupal\entityreferenceview\Plugin\Field\FieldFormatter;

use Drupal\Component\Utility\Html;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Field\FieldItemInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\Plugin\Field\FieldFormatter\EntityReferenceFormatterBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Link;
use Drupal\Core\Url;
use Drupal\migrate\Plugin\migrate\destination\Entity;

/**
 * Plugin implementation of the 'entity_reference_view_field_formatter' formatter.
 *
 * @FieldFormatter(
 *   id = "entity_reference_view_field_formatter",
 *   label = @Translation("Entity reference view field formatter"),
 *   field_types = {
 *     "entity_reference"
 *   }
 * )
 */
//cambiamos el extend
class EntityReferenceViewFieldFormatter extends EntityReferenceFormatterBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'path_view' => ''
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    //agregamos un campo de tipo texfield

    $formulario = parent::settingsForm($form, $form_state);
    $formulario['path_view'] = [
      '#type' => 'textfield',
      '#title' => $this -> t('Link a la vista'),
      '#defaullt_value' => $this -> getSetting('path_view'),
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
    // le avisa al usuario lo que agreg[o
    $summary = [];
    if(!empty($this->getSetting('path_view'))){
      $summary[] =
        $this -> t('El enlace a la vista es @path',
        ['@path' => $this -> getSetting('path_view')]);
    }
    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    //estamos conviritiendo el arreglo en un entity
    foreach ($this -> getEntitiesToView($items, $langcode) as $delta => $item){
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
  protected function viewValue(EntityInterface $entity) {
    //convertimos item en un entidad de referencia

    global $base_url;
    $label = $entity -> label();
    $id = $entity -> id();

    //una vez que tenemos esto lo que hacemos es crear la url a la que va a apuntar la vista
    $urlView = $base_url . '/' .$this->getSetting('path_view') . '/' . $id;
    $url = Url::fromUri($urlView);
    $link = Link::fromTextAndUrl($this->t('@NombreActor',
      ['@NombreActor' => $label]), $url);

    //Me devuele el enlace pero en un String
    return $link->toString();
  }

}
