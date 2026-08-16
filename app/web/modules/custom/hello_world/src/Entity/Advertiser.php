<?php

namespace Drupal\hello_world\Entity;

use Drupal\Core\Entity\Attribute\ContentEntityType;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\StringTranslation\TranslatableMarkup;
//
///**
// * Defines the Advertiser entity.
// *
// * @ingroup hello_world
// *
// * @ContentEntityType(
// *   id = "advertiser",
// *   label = @Translation("Advertiser"),
// *   base_table = "advertiser",
// *   entity_keys = {
// *     "id" = "id",
// *     "uuid" = "uuid",
// *   },
// * )
// */

#[ContentEntityType(
  id: 'advertiser',
  label: new TranslatableMarkup('Advertiser'),
  entity_keys: [
    'id' => 'id',
    'uuid' => 'uuid',
  ],
  handlers: [
    'storage' => SqlContentEntityStorage::class,
  ],
  base_table: 'advertiser',
)]
class Advertiser extends ContentEntityBase implements ContentEntityInterface {


  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {

    // Standard field, used as unique if primary index.
    $fields['id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('ID'))
      ->setDescription(t('The ID of the Advertiser entity.'))
      ->setReadOnly(TRUE);

    // Standard field, unique outside of the scope of the current project.
    $fields['uuid'] = BaseFieldDefinition::create('uuid')
      ->setLabel(t('UUID'))
      ->setDescription(t('The UUID of the Advertiser entity.'))
      ->setReadOnly(TRUE);

    $fields['grybas'] = BaseFieldDefinition::create('string')
      ->setLabel(t('grybas'))
      ->setDescription(t('Grybų karas.'))
      ->setReadOnly(FALSE)
      ->setRequired(TRUE)
      ->setSetting('max_length', 64)
    ;
    return $fields;
  }
}

