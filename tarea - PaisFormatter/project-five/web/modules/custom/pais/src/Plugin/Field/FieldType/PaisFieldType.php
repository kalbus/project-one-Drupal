<?php

namespace Drupal\pais\Plugin\Field\FieldType;

use Drupal\Component\Utility\Random;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Plugin implementation of the 'pais_field_type' field type.
 *
 * @FieldType(
 *   id = "pais_field_type",
 *   label = @Translation("Pais field type"),
 *   description = @Translation("Un campo para el pais"),
 *   default_widget = "pais_widge_type",
 *   default_formatter = "pais_formatter_type"
 * )
 */
class PaisFieldType extends FieldItemBase {


  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    // Prevent early t() calls by using the TranslatableMarkup.
    $properties['value'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Pais'));

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    $schema = [
      'columns' => [
        'value' => [
          'type' => 'varchar',
          'length' => 2, //es de dos porque la idea es que guarde las iniciales: CR, US, UK, etc
          'description' => t('El nombre del pais'),
          'not null' => False
        ],
      ],
    ];

    return $schema;
  }

  //borramos getcontraits
  //borramos m[etdo
  //borramos m[etodo

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    //lo que hace es obtener el campo, pregunta si esta null o vac[io
    $value = $this->get('value')->getValue();
    return $value === NULL || $value === '';
  }

}
