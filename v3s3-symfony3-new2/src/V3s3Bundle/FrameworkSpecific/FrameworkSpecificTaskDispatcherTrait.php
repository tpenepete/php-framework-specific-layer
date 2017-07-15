<?php

namespace V3s3Bundle\FrameworkSpecific;

use ReflectionClass;

trait FrameworkSpecificTaskDispatcherTrait {
	static function task($task, $args) {
		if(!empty(static::$taskNameToFunctionMapping[$task])) {
			if(!empty($args[static::TASK_MVC_COMPONENT_CLASS_METHOD_ARGUMENTS_KEY])) {
				$args[static::TASK_MVC_COMPONENT_CLASS_METHOD_ARGUMENTS_KEY] = self::method_get_args_assoc(reset($args[static::TASK_MVC_COMPONENT_CLASS_METHOD_ARGUMENTS_KEY]), end($args[self::TASK_MVC_COMPONENT_CLASS_METHOD_ARGUMENTS_KEY]));
			}
			return call_user_func_array('self::'.static::$taskNameToFunctionMapping[$task], [$args]);
		} else {
			return false;
		}
	}

	static function method_get_args_assoc($class_method_reference, $values) {
		$rc = new ReflectionClass(reset($class_method_reference));
		$method = end($class_method_reference);
		$method = $rc->getMethod($method);
		$keys = [];
		foreach ($method->getParameters() as $parameter) {
			$keys[] = $parameter->name;
		}

		return array_combine($keys, $values);
	}
}