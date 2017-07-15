<?php

namespace V3s3Bundle\FrameworkSpecific\SF3\Entity;

use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;

use V3s3Bundle\FrameworkSpecific\FrameworkSpecificInterface;
use V3s3Bundle\FrameworkSpecific\FrameworkSpecificTaskDispatcherTrait;

use V3s3Bundle\Entity\V3s3 as FrameworkIndependentV3s3Entity;

class V3s3 extends FrameworkIndependentV3s3Entity implements FrameworkSpecificInterface {
	use FrameworkSpecificTaskDispatcherTrait;

	private static $taskNameToFunctionMapping = [
		'Cast entity object to array.'=>'castEntityObjectToArray',
	];

	static function castEntityObjectToArray($args) {
		$entity = reset($args[self::TASK_ARGUMENTS_KEY]);

		if(empty($entity)) {
			return false;
		}

		$propertyNormalizer = new PropertyNormalizer();
		$propertyNormalizer->setCallbacks(
			[
				'name'=>'stream_get_contents',
				'data'=>'stream_get_contents',
			]
		);
		return $propertyNormalizer->normalize($entity);
	}
}