<?php

namespace V3s3Bundle\FrameworkSpecific\SF3\Repository;

use V3s3Bundle\FrameworkSpecific\FrameworkSpecificInterface;
use V3s3Bundle\FrameworkSpecific\FrameworkSpecificTaskDispatcherTrait;

use V3s3Bundle\FrameworkSpecific\SF3\Entity;

use V3s3Bundle\Entity\V3s3 as FrameworkIndependentV3s3Entity;

use V3s3Bundle\Repository\V3s3Repository as FrameworkIndependentV3s3Repository;

class V3s3Repository extends FrameworkIndependentV3s3Repository implements FrameworkSpecificInterface {
	use FrameworkSpecificTaskDispatcherTrait;

	private static $taskNameToFunctionMapping = [
		'Get all or fillable entity properties or table columns as array.'=>'getAllOrFillableEntityPropertiesOrTableColumnsAsArray',
		'Insert entity into storage and return the entity object.'=>'insertEntityIntoStorageAndReturnTheEntityObject',
		'Fetch one single entity result set.'=>'fetchOneSingleEntityResultSet',
		'Get fetch result row count.'=>'getFetchResultRowCount',
		'Update entity in storage and return the entity as array.'=>'updateEntityInStorageAndReturnTheEntityAsArray',
		'Get one single first or current entity object from result set.'=>'getOneSingleFirstOrCurrentEntityObjectFromResultSet',
		'Fetch multiple entities result set.'=>'fetchMultipleEntitiesResultSet',
	];

	static function getAllOrFillableEntityPropertiesOrTableColumnsAsArray($args) {
		$columns = $args[self::TASK_MVC_COMPONENT_CURRENT_INSTANCE_KEY]->getClassMetadata()->getFieldNames();
		return array_combine($columns, $columns);
	}

	static function insertEntityIntoStorageAndReturnTheEntityObject($args) {
		$entity = new FrameworkIndependentV3s3Entity(reset($args[self::TASK_ARGUMENTS_KEY]));

		$em = $args[self::TASK_MVC_COMPONENT_CURRENT_INSTANCE_KEY]->getEntityManager();
		$em->persist($entity);
		$em->flush();

		return $entity;
	}

	static function fetchOneSingleEntityResultSet($args) {
		return $args[self::TASK_MVC_COMPONENT_CURRENT_INSTANCE_KEY]->findBy($args[self::TASK_ARGUMENTS_KEY]['where']??null, $args[self::TASK_ARGUMENTS_KEY]['orderBy']??null, $args[self::TASK_ARGUMENTS_KEY]['limit']??null, $args[self::TASK_ARGUMENTS_KEY]['offset']??null); // PHP 7
	}

	static function getFetchResultRowCount($args) {
		if(($entityResultSet = reset($args[self::TASK_ARGUMENTS_KEY])) !== false) {
			return count($entityResultSet);
		} else {
			return false;
		}
	}

	static function getOneSingleFirstOrCurrentEntityObjectFromResultSet($args) {
		return self::_fetchFirstEntityObjectFromResultSet(reset($args[self::TASK_ARGUMENTS_KEY]));
	}

	static function updateEntityInStorageAndReturnTheEntityAsArray($args) {
		$entity = reset($args[self::TASK_ARGUMENTS_KEY]);
		if(empty($entity) || !is_object($entity) || !is_a($entity, FrameworkIndependentV3s3Entity::class)) {
			return false;
		}

		$entity->fromArray(end($args[self::TASK_ARGUMENTS_KEY]));

		$em = $args[self::TASK_MVC_COMPONENT_CURRENT_INSTANCE_KEY]->getEntityManager();
		$em->flush();

		return $entity;
	}

	static function fetchMultipleEntitiesResultSet($args) {
		return $args[self::TASK_MVC_COMPONENT_CURRENT_INSTANCE_KEY]->findBy($args[self::TASK_ARGUMENTS_KEY]['where']??null, $args[self::TASK_ARGUMENTS_KEY]['orderBy']??null, $args[self::TASK_ARGUMENTS_KEY]['limit']??null, $args[self::TASK_ARGUMENTS_KEY]['offset']??null); // PHP 7
	}

	static function _fetchFirstEntityObjectFromResultSet($resultSet) {
		if(empty($resultSet)) {
			return false;
		}

		return reset($resultSet);
	}
}