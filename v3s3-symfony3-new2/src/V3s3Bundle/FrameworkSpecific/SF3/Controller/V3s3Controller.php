<?php

namespace V3s3Bundle\FrameworkSpecific\SF3\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

use V3s3Bundle\FrameworkSpecific\FrameworkSpecificInterface;
use V3s3Bundle\FrameworkSpecific\FrameworkSpecificTaskDispatcherTrait;

use V3s3Bundle\FrameworkSpecific\SF3\Entity\V3s3 as FrameworkSpecificV3s3Entity;

use V3s3Bundle\Controller\DefaultController as FrameworkIndependentV3s3Controller;

use V3s3Bundle\Entity\V3s3 as FrameworkIndependentV3s3Entity;

use V3s3Bundle\Helper\V3s3Html;
use V3s3Bundle\Helper\V3s3Xml;

use V3s3Bundle\Exception\V3s3InputValidationException;

class V3s3Controller extends FrameworkIndependentV3s3Controller implements FrameworkSpecificInterface {
	use FrameworkSpecificTaskDispatcherTrait;

	private static $taskNameToFunctionMapping = array(
		'Validate PUT input. Return true if successful or JSON response on error.'=>'validatePutInputReturnTrueIfSuccessfulOrJsonResponseOnError',
		'Get route parameter or request URL path.'=>'getRouteParameterOrRequestUrlPath',
		'Get raw request input body content.'=>'getRawRequestInputBodyContent',
		'Get single request header.'=>'getSingleRequestHeader',
		'Insert entity from PUT request and return the entity as array.'=>'insertEntityFromPutRequestAndReturnTheEntityAsArray',
		'Get request client ip address.'=>'getRequestClientIpAddress',
		'Set single response header. Return JSON response.'=>'setSingleResponseHeaderReturnJsonResponse',
		'Validate GET input. Return true if successful or JSON response on error.'=>'validateGetInputReturnTrueIfSuccessfulOrJsonResponseOnError',
		'Get all request URL query parameters as array.'=>'getAllRequestUrlQueryParametersAsArray',
		'Select one single entity result from permitted GET request URL parameters and return the entity as array or false if not found.'=>'selectOneSingleEntityResultFromPermittedGetRequestUrlParametersAndReturnTheEntityAsArrayOrFalseIfNotFound',
		'Assign string value as the response output body content.'=>'assignStringValueAsTheResponseOutputBodyContent',
		'Get response object.'=>'getResponseObject',
		'Send multiple response headers from array. Overwrite existing keys.'=>'sendMultipleResponseHeadersFromArrayOverwriteExistingKeys',
		'Get single request URL query parameter.'=>'getSingleRequestUrlQueryParameter',
		'Set response attachment download header.'=>'setResponseAttachmentDownloadHeader',
		'Set response status. Return JSON response.'=>'setResponseStatusReturnJsonResponse',
		'Validate DELETE input. Return true if successful or JSON response on error.'=>'validateDeleteInputReturnTrueIfSuccessfulOrJsonResponseOnError',
		'Select entity from permitted DELETE request URL parameters, update the status field to deleted and return the updated entity as array or false if not found.'=>'selectEntityFromPermittedDeleteRequestUrlParametersUpdateTheStatusFieldToDeletedAndReturnTheUpdatedEntityAsArrayOrFalseIfNotFound',
		'Get raw request body content as string.'=>'getRawRequestBodyContentAsString',
		'Validate raw POST request body content input and parse it as JSON. Return JSON response on error.'=>'validateRawPostRequestBodyContentInputAndParseItAsJsonReturnJsonResponseOnError',
		'Select multiple entities result set from permitted parameters from the POST JSON filter key and return the result set as array or false if not found.'=>'selectMultipleEntitiesResultSetFromPermittedParametersFromThePostJsonFilterKeyAndReturnTheResultSetAsArrayOrFalseIfNotFound',
		'Create XML from array using helper.'=>'createXmlFromArrayUsingHelper',
		'Create XML response.'=>'createXmlResponse',
		'Create HTML from array using helper.'=>'createHtmlFromArrayUsingHelper',
		'Create HTML response.'=>'createHtmlResponse',
		'Create JSON response with pretty print.'=>'createJsonResponseWithPrettyPrint',
	);

	private static $response;

	static function validatePutInputReturnTrueIfSuccessfulOrJsonResponseOnError($args) {
		$name = $args[self::TASK_MVC_COMPONENT_CLASS_METHOD_ARGUMENTS_KEY]['name'];

		try {
			if (empty($name) || ($name == '/')) {
				throw new V3s3InputValidationException(
					self::translate('V3S3_EXCEPTION_PUT_EMPTY_OBJECT_NAME', $args[self::TASK_MVC_COMPONENT_CURRENT_INSTANCE_KEY]), // TASK: TRANSLATE THE GIVEN STRING USING CURRENT LOCALE LANGUAGE AND THE PROVIDED TRANSLATOR MECHANISM AND TRANSLATION FILES.
					V3s3InputValidationException::PUT_EMPTY_OBJECT_NAME
				);
			} else if (strlen($name) > 1024) {
				throw new V3s3InputValidationException(
					self::translate('V3S3_EXCEPTION_OBJECT_NAME_TOO_LONG', $args[self::TASK_MVC_COMPONENT_CURRENT_INSTANCE_KEY]), // TASK: TRANSLATE THE GIVEN STRING USING CURRENT LOCALE LANGUAGE AND THE PROVIDED TRANSLATOR MECHANISM AND TRANSLATION FILES.
					V3s3InputValidationException::OBJECT_NAME_TOO_LONG
				);
			}
		} catch(V3s3InputValidationException $e) {
			return self::task(
				'Create JSON response.',
				array_replace(
					$args,
					[
						self::TASK_ARGUMENTS_KEY=>[
							[
								'status'=>0,
								'code'=>$e->getCode(),
								'message'=>$e->getMessage()
							]
						]
					]
				)
			);
		}

		return true;
	}

	static function createJsonResponse($args) {
		return new JsonResponse(reset($args[self::TASK_ARGUMENTS_KEY]));
	}

	static function getRouteParameterOrRequestUrlPath($args) {
		return $args[self::TASK_MVC_COMPONENT_CLASS_METHOD_ARGUMENTS_KEY]['name'];
	}

	static function getRawRequestInputBodyContent($args) {
		return $args[self::TASK_MVC_COMPONENT_CLASS_METHOD_ARGUMENTS_KEY]['request']->getContent(reset($args[self::TASK_ARGUMENTS_KEY]));
	}

	static function getSingleRequestHeader($args) {
		return $args[self::TASK_MVC_COMPONENT_CLASS_METHOD_ARGUMENTS_KEY]['request']->headers->get(reset($args[self::TASK_ARGUMENTS_KEY]));
	}

	static function setSingleResponseHeaderReturnJsonResponse($args) {
		$response = new JsonResponse(end($args[self::TASK_ARGUMENTS_KEY]));
		$header = reset($args[self::TASK_ARGUMENTS_KEY]);
		$response->headers->set(reset($header), end($header));
		return $response;
	}

	static function getRequestClientIpAddress($args) {
		return $args[self::TASK_MVC_COMPONENT_CLASS_METHOD_ARGUMENTS_KEY]['request']->getClientIp();
	}

	static function insertEntityFromPutRequestAndReturnTheEntityAsArray($args) {
		$em = $args[self::TASK_MVC_COMPONENT_CURRENT_INSTANCE_KEY]->getDoctrine()->getManager();
		$tableGateway = $em->getRepository(FrameworkIndependentV3s3Entity::class);

		$entity = $tableGateway->put(reset($args[self::TASK_ARGUMENTS_KEY]));

		$entity =
			/* TASK: CAST ENTITY OBJECT TO ARRAY. */
			FrameworkSpecificV3s3Entity::task(
				'Cast entity object to array.',
				[
					FrameworkSpecificV3s3Entity::TASK_ARGUMENTS_KEY=>[$entity],
					FrameworkSpecificV3s3Entity::TASK_MVC_COMPONENT_TYPE_KEY=>FrameworkSpecificV3s3Entity::TASK_MVC_COMPONENT_TYPE_ENTITY,
					FrameworkSpecificV3s3Entity::TASK_MVC_COMPONENT_CURRENT_INSTANCE_KEY=>null,
					FrameworkSpecificV3s3Entity::TASK_MVC_COMPONENT_CLASS_METHOD_KEY=>null,
					FrameworkSpecificV3s3Entity::TASK_MVC_COMPONENT_CLASS_METHOD_ARGUMENTS_KEY=>null
				]
			);
			/* END: CAST ENTITY OBJECT TO ARRAY. */

		return $entity;
	}

	static function validateGetInputReturnTrueIfSuccessfulOrJsonResponseOnError($args) {
		$name = $args[self::TASK_MVC_COMPONENT_CLASS_METHOD_ARGUMENTS_KEY]['name'];

		try {
			if (strlen($name) > 1024) {
				throw new V3s3InputValidationException(
					self::translate('V3S3_EXCEPTION_OBJECT_NAME_TOO_LONG', $args[self::TASK_MVC_COMPONENT_CURRENT_INSTANCE_KEY]), // TASK: TRANSLATE THE GIVEN STRING USING CURRENT LOCALE LANGUAGE AND THE PROVIDED TRANSLATOR MECHANISM AND TRANSLATION FILES.
					V3s3InputValidationException::OBJECT_NAME_TOO_LONG
				);
			}
		} catch(V3s3InputValidationException $e) {
			return self::task(
				'Create JSON response.',
				array_replace(
					$args,
					[
						self::TASK_ARGUMENTS_KEY=>[
							[
								'status'=>0,
								'code'=>$e->getCode(),
								'message'=>$e->getMessage()
							]
						]
					]
				)
			);
		}

		return true;
	}

	static function getAllRequestUrlQueryParametersAsArray($args) {
		return $args[self::TASK_MVC_COMPONENT_CLASS_METHOD_ARGUMENTS_KEY]['request']->query->all();
	}

	static function selectOneSingleEntityResultFromPermittedGetRequestUrlParametersAndReturnTheEntityAsArrayOrFalseIfNotFound($args) {
		$entityManager = $args[self::TASK_MVC_COMPONENT_CURRENT_INSTANCE_KEY]->getDoctrine()->getManager();
		$tableGateway = $entityManager->getRepository(FrameworkIndependentV3s3Entity::class);
		$entity = $tableGateway->get(reset($args[self::TASK_ARGUMENTS_KEY]));

		$entity =
			/* TASK: CAST ENTITY OBJECT TO ARRAY. */
			FrameworkSpecificV3s3Entity::task(
				'Cast entity object to array.',
				[
					FrameworkSpecificV3s3Entity::TASK_ARGUMENTS_KEY=>[$entity],
					FrameworkSpecificV3s3Entity::TASK_MVC_COMPONENT_TYPE_KEY=>FrameworkSpecificV3s3Entity::TASK_MVC_COMPONENT_TYPE_ENTITY,
					FrameworkSpecificV3s3Entity::TASK_MVC_COMPONENT_CURRENT_INSTANCE_KEY=>null,
					FrameworkSpecificV3s3Entity::TASK_MVC_COMPONENT_CLASS_METHOD_KEY=>null,
					FrameworkSpecificV3s3Entity::TASK_MVC_COMPONENT_CLASS_METHOD_ARGUMENTS_KEY=>null
				]
			);
		/* END: CAST ENTITY OBJECT TO ARRAY. */

		return $entity;
	}

	static function assignStringValueAsTheResponseOutputBodyContent($args) {
		$response = self::getResponseObject();
		$response->setContent(reset($args[self::TASK_ARGUMENTS_KEY]));
	}

	static function getResponseObject($args=null) {
		if(!isset(self::$response) || is_null(self::$response)) {
			return self::$response = new Response;
		} else {
			return self::$response;
		}
	}

	static function sendMultipleResponseHeadersFromArrayOverwriteExistingKeys($args) {
		$response = self::getResponseObject();
		$response->headers->add(reset($args[self::TASK_ARGUMENTS_KEY]));
	}

	static function getSingleRequestUrlQueryParameter($args) {
		return $args[self::TASK_MVC_COMPONENT_CLASS_METHOD_ARGUMENTS_KEY]['request']->get(reset($args[self::TASK_ARGUMENTS_KEY]));
	}

	static function setResponseAttachmentDownloadHeader($args) {
		$response = self::getResponseObject();
		$response->headers->set(
			'Content-Disposition',
			$response->headers->makeDisposition('attachment', reset($args[self::TASK_ARGUMENTS_KEY]))
		);
	}

	static function setResponseStatusReturnJsonResponse($args) {
		return new JsonResponse(end($args[self::TASK_ARGUMENTS_KEY]), reset($args[self::TASK_ARGUMENTS_KEY]));
	}

	static function validateDeleteInputReturnTrueIfSuccessfulOrJsonResponseOnError($args) {
		$name = $args[self::TASK_MVC_COMPONENT_CLASS_METHOD_ARGUMENTS_KEY]['name'];

		try {
			if (empty($name) || ($name == '/')) {
				throw new V3s3InputValidationException(
					self::translate('V3S3_EXCEPTION_DELETE_EMPTY_OBJECT_NAME', $args[self::TASK_MVC_COMPONENT_CURRENT_INSTANCE_KEY]), // TASK: TRANSLATE THE GIVEN STRING USING CURRENT LOCALE LANGUAGE AND THE PROVIDED TRANSLATOR MECHANISM AND TRANSLATION FILES.
					V3s3InputValidationException::DELETE_EMPTY_OBJECT_NAME
				);
			} else if (strlen($name) > 1024) {
				throw new V3s3InputValidationException(
					self::translate('V3S3_EXCEPTION_OBJECT_NAME_TOO_LONG', $args[self::TASK_MVC_COMPONENT_CURRENT_INSTANCE_KEY]), // TASK: TRANSLATE THE GIVEN STRING USING CURRENT LOCALE LANGUAGE AND THE PROVIDED TRANSLATOR MECHANISM AND TRANSLATION FILES.
					V3s3InputValidationException::OBJECT_NAME_TOO_LONG
				);
			}
		} catch(V3s3InputValidationException $e) {
			return self::task(
				'Create JSON response.',
				array_replace(
					$args,
					[
						self::TASK_ARGUMENTS_KEY=>[
							[
								'status'=>0,
								'code'=>$e->getCode(),
								'message'=>$e->getMessage()
							]
						]
					]
				)
			);
		}

		return true;
	}

	static function selectEntityFromPermittedDeleteRequestUrlParametersUpdateTheStatusFieldToDeletedAndReturnTheUpdatedEntityAsArrayOrFalseIfNotFound($args) {
		$entityManager = $args[self::TASK_MVC_COMPONENT_CURRENT_INSTANCE_KEY]->getDoctrine()->getManager();
		$tableGateway = $entityManager->getRepository(FrameworkIndependentV3s3Entity::class);
		$entity = $tableGateway->api_delete(reset($args[self::TASK_ARGUMENTS_KEY]));

		$entity =
			/* TASK: CAST ENTITY OBJECT TO ARRAY. */
			FrameworkSpecificV3s3Entity::task(
				'Cast entity object to array.',
				[
					FrameworkSpecificV3s3Entity::TASK_ARGUMENTS_KEY=>[$entity],
					FrameworkSpecificV3s3Entity::TASK_MVC_COMPONENT_TYPE_KEY=>FrameworkSpecificV3s3Entity::TASK_MVC_COMPONENT_TYPE_ENTITY,
					FrameworkSpecificV3s3Entity::TASK_MVC_COMPONENT_CURRENT_INSTANCE_KEY=>null,
					FrameworkSpecificV3s3Entity::TASK_MVC_COMPONENT_CLASS_METHOD_KEY=>null,
					FrameworkSpecificV3s3Entity::TASK_MVC_COMPONENT_CLASS_METHOD_ARGUMENTS_KEY=>null
				]
			);
		/* END: CAST ENTITY OBJECT TO ARRAY. */

		return $entity;
	}

	static function getRawRequestBodyContentAsString($args) {
		return $args[self::TASK_MVC_COMPONENT_CLASS_METHOD_ARGUMENTS_KEY]['request']->getContent();
	}

	static function validateRawPostRequestBodyContentInputAndParseItAsJsonReturnJsonResponseOnError($args) {
		$input = reset($args[self::TASK_ARGUMENTS_KEY]);

		$serializer = new Serializer([], [new JsonEncoder]);
		$parsed_input = $serializer->decode($input, 'json');

		if(!empty($input) && empty($parsed_input)) {
			try {
				throw new V3s3InputValidationException(self::translate('V3S3_EXCEPTION_POST_INVALID_REQUEST', $args[self::TASK_MVC_COMPONENT_CURRENT_INSTANCE_KEY]), V3s3Exception::POST_INVALID_REQUEST);
			} catch(V3s3InputValidationException $e) {
				return
					/* TASK: CREATE JSON RESPONSE. */
					self::task(
						'Create JSON response.',
						array_replace(
							$args,
							[
								self::TASK_ARGUMENTS_KEY=>[
									[
										'status'=>0,
										'code'=>$e->getCode(),
										'message'=>$e->getMessage()
									]
								]
							]
						)
					);
					/* TASK: CREATE JSON RESPONSE. */
			}
		}

		return $parsed_input;
	}

	static function selectMultipleEntitiesResultSetFromPermittedParametersFromThePostJsonFilterKeyAndReturnTheResultSetAsArrayOrFalseIfNotFound($args) {
		$entityManager = $args[self::TASK_MVC_COMPONENT_CURRENT_INSTANCE_KEY]->getDoctrine()->getManager();
		$tableGateway = $entityManager->getRepository(FrameworkIndependentV3s3Entity::class);
		$entityResultSet = $tableGateway->post(reset($args[self::TASK_ARGUMENTS_KEY]));

		foreach($entityResultSet as &$entity) {
			$entity =
				/* TASK: CAST ENTITY OBJECT TO ARRAY. */
				FrameworkSpecificV3s3Entity::task(
					'Cast entity object to array.',
					[
						FrameworkSpecificV3s3Entity::TASK_ARGUMENTS_KEY => [$entity],
						FrameworkSpecificV3s3Entity::TASK_MVC_COMPONENT_TYPE_KEY => FrameworkSpecificV3s3Entity::TASK_MVC_COMPONENT_TYPE_ENTITY,
						FrameworkSpecificV3s3Entity::TASK_MVC_COMPONENT_CURRENT_INSTANCE_KEY => null,
						FrameworkSpecificV3s3Entity::TASK_MVC_COMPONENT_CLASS_METHOD_KEY => null,
						FrameworkSpecificV3s3Entity::TASK_MVC_COMPONENT_CLASS_METHOD_ARGUMENTS_KEY => null
					]
				);
				/* END: CAST ENTITY OBJECT TO ARRAY. */
		}

		return $entityResultSet;
	}

	static function createXmlFromArrayUsingHelper($args) {
		return V3s3Xml::simple_xml(reset($args[self::TASK_ARGUMENTS_KEY]));
	}

	static function createXmlResponse($args) {
		$response = self::getResponseObject();
		$response->headers->set('Content-Type', 'text/xml; charset=utf-8');
		self::assignStringValueAsTheResponseOutputBodyContent($args);
		return $response;
	}

	static function createHtmlFromArrayUsingHelper($args) {
		return V3s3Html::simple_table(reset($args[self::TASK_ARGUMENTS_KEY]));
	}

	static function createHtmlResponse($args) {
		$response = self::getResponseObject();
		$response->headers->set('Content-Type', 'text/html; charset=utf-8');
		self::assignStringValueAsTheResponseOutputBodyContent($args);
		return $response;
	}

	static function createJsonResponseWithPrettyPrint($args) {
		$serializer = new Serializer([], [new JsonEncoder]);
		$json = $serializer->encode(
			reset($args[self::TASK_ARGUMENTS_KEY]),
			'json',
			[
				'json_encode_options'=>JSON_PRETTY_PRINT
			]
		);
		return new JsonResponse($json, 200, [], true);
	}
}