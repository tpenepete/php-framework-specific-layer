<?php

namespace V3s3Bundle\FrameworkSpecific;

interface FrameworkSpecificInterface {
	const TASK_ARGUMENTS_KEY = 'arguments'; // actual task arguments
	const TASK_MVC_COMPONENT_TYPE_KEY = 'component'; // caller component type (Model, View or Controller)
	const TASK_MVC_COMPONENT_CURRENT_INSTANCE_KEY = 'this'; // caller object
	const TASK_MVC_COMPONENT_CLASS_METHOD_KEY = 'method'; // caller method
	const TASK_MVC_COMPONENT_CLASS_METHOD_ARGUMENTS_KEY = 'component_arguments'; // caller method arguments

	const TASK_MVC_COMPONENT_TYPE_CONTROLLER = 'controller';
	const TASK_MVC_COMPONENT_TYPE_REPOSITORY = 'repository';
	const TASK_MVC_COMPONENT_TYPE_ENTITY = 'entity';
}