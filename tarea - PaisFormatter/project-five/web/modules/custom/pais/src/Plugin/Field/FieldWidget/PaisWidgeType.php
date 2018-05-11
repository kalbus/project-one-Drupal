<?php

namespace Drupal\pais\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'pais_widge_type' widget.
 *
 * @FieldWidget(
 *   id = "pais_widge_type",
 *   label = @Translation("Pais widge type"),
 *   field_types = {
 *     "pais_field_type"
 *   }
 * )
 */
class PaisWidgeType extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element['value'] = $element + [
      '#type' => 'select',
      '#default_value' => isset($items[$delta]->value) ? $items[$delta]->value : NULL, //verifia que haya info dentro de los itam
      '#title' => $this -> t('Selectione el país'),
      '#options' => \Drupal::service('country_manager')-> getList()
        //vamos a usar un servicio de drupal llmada country manager y el m[etodo getList(), es un m[etodo est[atico de ella
    ];

    return $element;
  }

}
