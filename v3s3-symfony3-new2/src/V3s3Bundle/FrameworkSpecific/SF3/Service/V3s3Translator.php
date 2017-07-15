<?php

namespace V3s3Bundle\FrameworkSpecific\SF3\Service;

use V3s3Bundle\FrameworkSpecific\FrameworkSpecificInterface;
use V3s3Bundle\FrameworkSpecific\FrameworkSpecificTaskDispatcherTrait;

use V3s3Bundle\Controller\DefaultController as FrameworkIndependentV3s3Controller;

class V3s3Translator extends FrameworkIndependentV3s3Controller implements FrameworkSpecificInterface {
	use FrameworkSpecificTaskDispatcherTrait;

	const TRANSLATION_DOMAIN = 'V3s3';

	private static $taskNameToFunctionMapping = [
		'Translate the given string using current locale language and the provided translator mechanism and translation files.'=>'translateTheGivenStringUsingCurrentLocaleSettingsAndTheProvidedTranslatorMechanismAndTranslationFiles',
	];

	static function translate($message, $currentInstance) {
		return self::task(
			'Translate the given string using current locale language and the provided translator mechanism and translation files.',
			[
				self::TASK_ARGUMENTS_KEY=>[$message],
				self::TASK_MVC_COMPONENT_TYPE_KEY=>null,
				self::TASK_MVC_COMPONENT_CURRENT_INSTANCE_KEY=>$currentInstance,
				self::TASK_MVC_COMPONENT_CLASS_METHOD_KEY=>null,
				self::TASK_MVC_COMPONENT_CLASS_METHOD_ARGUMENTS_KEY=>null
			]
		);
	}

	static function translateTheGivenStringUsingCurrentLocaleSettingsAndTheProvidedTranslatorMechanismAndTranslationFiles($args) {
		return $args[self::TASK_MVC_COMPONENT_CURRENT_INSTANCE_KEY]->get('translator')->trans(reset($args[self::TASK_ARGUMENTS_KEY]), [], self::TRANSLATION_DOMAIN);
	}
}