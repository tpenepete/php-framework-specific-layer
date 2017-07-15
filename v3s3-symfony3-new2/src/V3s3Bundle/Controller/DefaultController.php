<?php

namespace V3s3Bundle\Controller;

use finfo;

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Component\HttpFoundation\Request;

use V3s3Bundle\FrameworkSpecific\SF3\Controller\V3s3Controller as FrameworkSpecificV3s3Controller;
use V3s3Bundle\FrameworkSpecific\SF3\Service\V3s3Translator as FrameworkSpecificV3s3Translator;

class DefaultController extends Controller {
	/**
	 * @Route("/{name}", requirements={"name"=".+"}, name="v3s3_put")
	 * @Method("PUT")
	 */
	// 1. VALIDATE PUT INPUT. RETURN TRUE IF SUCCESSFUL OR JSON RESPONSE ON ERROR.
	// 2. GET ROUTE PARAMETER OR REQUEST URL PATH. (as $name)
	// 3. GET RAW REQUEST INPUT BODY CONTENT. (as $data)
	// 4. GET SINGLE REQUEST HEADER. (use the Content-Type request header or attempt to determine the MIME type from $data using PHP's finfo as $mime_type)
	// 5. GET REQUEST CLIENT IP ADDRESS.
	// 6. INSERT ENTITY FROM PUT REQUEST AND RETURN THE ENTITY ARRAY. (pass the obtained values to the table gateway for insertion into the database)
	// 7. SET SINGLE RESPONSE HEADER. RETURN JSON RESPONSE. (v3s3-object-id: ID of inserted entity row)
	public function putAction($name, Request $request) {
		if(
			($inputValid =
				/* TASK: VALIDATE PUT INPUT. RETURN TRUE IF SUCCESSFUL OR JSON RESPONSE ON ERROR. */
				FrameworkSpecificV3s3Controller::task(
					'Validate PUT input. Return true if successful or JSON response on error.',
					[
						FrameworkSpecificV3s3Controller::TASK_ARGUMENTS_KEY=>[],
						FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_TYPE_KEY=>FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_TYPE_CONTROLLER,
						FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CURRENT_INSTANCE_KEY=>$this,
						FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CLASS_METHOD_KEY=>__FUNCTION__,
						FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CLASS_METHOD_ARGUMENTS_KEY=>[[$this, __FUNCTION__], func_get_args()]
					]
				)
				/* END: VALIDATE PUT INPUT. RETURN TRUE IF SUCCESSFUL OR JSON RESPONSE ON ERROR. */
			) !== true
		) {
			return $inputValid;
		}

		$name =
			/* TASK: GET ROUTE PARAMETER OR REQUEST URL PATH. */
			FrameworkSpecificV3s3Controller::task(
				'Get route parameter or request URL path.',
				[
					FrameworkSpecificV3s3Controller::TASK_ARGUMENTS_KEY=>[],
					FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_TYPE_KEY=>FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_TYPE_CONTROLLER,
					FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CURRENT_INSTANCE_KEY=>$this,
					FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CLASS_METHOD_KEY=>__FUNCTION__,
					FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CLASS_METHOD_ARGUMENTS_KEY=>[[$this, __FUNCTION__], func_get_args()]
				]
			);
			/* END: GET ROUTE PARAMETER OR REQUEST URL PATH. */

		$data =
			/* TASK: GET RAW REQUEST INPUT BODY CONTENT. */
			FrameworkSpecificV3s3Controller::task(
				'Get raw request input body content.',
				[
					FrameworkSpecificV3s3Controller::TASK_ARGUMENTS_KEY=>[],
					FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_TYPE_KEY=>FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_TYPE_CONTROLLER,
					FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CURRENT_INSTANCE_KEY=>$this,
					FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CLASS_METHOD_KEY=>__FUNCTION__,
					FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CLASS_METHOD_ARGUMENTS_KEY=>[[$this, __FUNCTION__], func_get_args()]
				]
			);
			/* END: GET RAW REQUEST INPUT BODY CONTENT. */

		$content_type =
			/* TASK: GET SINGLE REQUEST HEADER. */
			FrameworkSpecificV3s3Controller::task(
				'Get single request header.',
				[
					FrameworkSpecificV3s3Controller::TASK_ARGUMENTS_KEY=>['Content-Type'],
					FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_TYPE_KEY=>FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_TYPE_CONTROLLER,
					FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CURRENT_INSTANCE_KEY=>$this,
					FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CLASS_METHOD_KEY=>__FUNCTION__,
					FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CLASS_METHOD_ARGUMENTS_KEY=>[[$this, __FUNCTION__], func_get_args()]
				]
			);
			/* END: GET SINGLE REQUEST HEADER. */

		$mime_type = (is_null($content_type)?(new finfo(FILEINFO_MIME))->buffer($data):$content_type);

		$row =
			/* TASK: INSERT ENTITY FROM PUT REQUEST AND RETURN THE ENTITY AS ARRAY. */
			FrameworkSpecificV3s3Controller::task(
				'Insert entity from PUT request and return the entity as array.',
				[
					FrameworkSpecificV3s3Controller::TASK_ARGUMENTS_KEY=>[
						[
							'ip'=>
								/* TASK: GET REQUEST CLIENT IP ADDRESS */
								FrameworkSpecificV3s3Controller::task(
									'Get request client ip address.',
									[
										FrameworkSpecificV3s3Controller::TASK_ARGUMENTS_KEY=>[],
										FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_TYPE_KEY=>FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_TYPE_CONTROLLER,
										FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CURRENT_INSTANCE_KEY=>$this,
										FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CLASS_METHOD_KEY=>__FUNCTION__,
										FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CLASS_METHOD_ARGUMENTS_KEY=>[[$this, __FUNCTION__], func_get_args()]
									]
								),
								/* END: GET REQUEST CLIENT IP ADDRESS */
							'name'=>$name,
							'data'=>$data,
							'mime_type'=>$mime_type,
						]
					],
					FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_TYPE_KEY=>FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_TYPE_CONTROLLER,
					FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CURRENT_INSTANCE_KEY=>$this,
					FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CLASS_METHOD_KEY=>__FUNCTION__,
					FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CLASS_METHOD_ARGUMENTS_KEY=>[[$this, __FUNCTION__], func_get_args()]
				]
			);
			/* END: INSERT ENTITY FROM PUT REQUEST AND RETURN THE ENTITY AS ARRAY. */

		return
			/* TASK: SET SINGLE RESPONSE HEADER. RETURN JSON RESPONSE. */
			FrameworkSpecificV3s3Controller::task(
				'Set single response header. Return JSON response.',
				[
					FrameworkSpecificV3s3Controller::TASK_ARGUMENTS_KEY=>[
						['v3s3-object-id', $row['id']],
						[
							'status'=>1,
							'message'=>FrameworkSpecificV3s3Translator::translate('V3S3_MESSAGE_PUT_OBJECT_ADDED_SUCCESSFULLY', $this) // TASK: TRANSLATE THE GIVEN STRING USING CURRENT LOCALE LANGUAGE AND THE PROVIDED TRANSLATOR MECHANISM AND TRANSLATION FILES.
						]
					],
					FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_TYPE_KEY=>FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_TYPE_CONTROLLER,
					FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CURRENT_INSTANCE_KEY=>$this,
					FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CLASS_METHOD_KEY=>__FUNCTION__,
					FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CLASS_METHOD_ARGUMENTS_KEY=>[[$this, __FUNCTION__], func_get_args()]
				]
			);
			/* END: SET SINGLE RESPONSE HEADER. RETURN JSON RESPONSE. */
	}

	/**
	 * @Route("/{name}", requirements={"name"=".+"}, name="v3s3_get")
	 * @Method("GET")
	 */
	// 1. VALIDATE GET INPUT. RETURN TRUE IF SUCCESSFUL OR JSON RESPONSE ON ERROR.
	// 2. GET ROUTE PARAMETER OR REQUEST URL PATH. (as $name)
	// 3. GET ALL URL QUERY PARAMETERS AS ARRAY. (as $input)
	// 4. SELECT ONE SINGLE ENTITY RESULT FROM PERMITTED GET REQUEST URL PARAMETERS AND RETURN THE ENTITY AS ARRAY OR FALSE IF NOT FOUND.
	// {if such entity has been found}
	// 5.1.1. ASSIGN STRING VALUE AS THE RESPONSE OUTPUT BODY CONTENT. (send the entity data column contents as response body)
	// 5.1.2. SEND MULTIPLE RESPONSE HEADERS FROM ARRAY. OVERWRITE EXISTING KEYS. (send the v3s3-object-id (entity ID), Content-Type and Content-Length HTTP headers)
	// 5.1.3. GET SINGLE REQUEST URL QUERY PARAMETER.
	// 5.1.4. SET RESPONSE ATTACHMENT DOWNLOAD HEADER. (if the "download" GET request URL parameter is not empty set the Content-Disposition HTTP header)
	// 5.1.5. GET RESPONSE OBJECT. (and return it to the container)
	// {else}
	// 5.2 SET RESPONSE STATUS. RETURN JSON RESPONSE. (respond with a 404 status and a JSON result)
	// {endif}
	public function getAction($name, Request $request) {
		if(
			($inputValid =
				/* TASK: VALIDATE GET INPUT. RETURN TRUE IF SUCCESSFUL OR JSON RESPONSE ON ERROR. */
				FrameworkSpecificV3s3Controller::task(
					'Validate GET input. Return true if successful or JSON response on error.',
					[
						FrameworkSpecificV3s3Controller::TASK_ARGUMENTS_KEY=>[],
						FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_TYPE_KEY=>FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_TYPE_CONTROLLER,
						FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CURRENT_INSTANCE_KEY=>$this,
						FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CLASS_METHOD_KEY=>__FUNCTION__,
						FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CLASS_METHOD_ARGUMENTS_KEY=>[[$this, __FUNCTION__], func_get_args()]
					]
				)
				/* END: VALIDATE GET INPUT. RETURN TRUE IF SUCCESSFUL OR JSON RESPONSE ON ERROR. */
			) !== true
		) {
			return $inputValid;
		}

		$name =
			/* TASK: GET ROUTE PARAMETER OR REQUEST URL PATH. */
			FrameworkSpecificV3s3Controller::task(
				'Get route parameter or request URL path.',
				[
					FrameworkSpecificV3s3Controller::TASK_ARGUMENTS_KEY=>[],
					FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_TYPE_KEY=>FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_TYPE_CONTROLLER,
					FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CURRENT_INSTANCE_KEY=>$this,
					FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CLASS_METHOD_KEY=>__FUNCTION__,
					FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CLASS_METHOD_ARGUMENTS_KEY=>[[$this, __FUNCTION__], func_get_args()]
				]
			);
			/* END: GET ROUTE PARAMETER OR REQUEST URL PATH. */

		$input =
			/* TASK: GET ALL REQUEST URL QUERY PARAMETERS AS ARRAY. */
			FrameworkSpecificV3s3Controller::task(
				'Get all request URL query parameters as array.',
				[
					FrameworkSpecificV3s3Controller::TASK_ARGUMENTS_KEY=>[],
					FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_TYPE_KEY=>FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_TYPE_CONTROLLER,
					FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CURRENT_INSTANCE_KEY=>$this,
					FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CLASS_METHOD_KEY=>__FUNCTION__,
					FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CLASS_METHOD_ARGUMENTS_KEY=>[[$this, __FUNCTION__], func_get_args()]
				]
			);
			/* TASK: GET ALL REQUEST URL QUERY PARAMETERS AS ARRAY. */

		$row =
			/* TASK: SELECT ONE SINGLE ENTITY RESULT FROM PERMITTED GET REQUEST URL PARAMETERS AND RETURN THE ENTITY AS ARRAY OR FALSE IF NOT FOUND. */
			FrameworkSpecificV3s3Controller::task(
				'Select one single entity result from permitted GET request URL parameters and return the entity as array or false if not found.',
				[
					FrameworkSpecificV3s3Controller::TASK_ARGUMENTS_KEY=>[
						array_replace(
							$input,
							[
								'name'=>$name,
							]
						)
					],
					FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_TYPE_KEY=>FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_TYPE_CONTROLLER,
					FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CURRENT_INSTANCE_KEY=>$this,
					FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CLASS_METHOD_KEY=>__FUNCTION__,
					FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CLASS_METHOD_ARGUMENTS_KEY=>[[$this, __FUNCTION__], func_get_args()]
				]
			);
			/* END: SELECT ONE SINGLE ENTITY RESULT FROM PERMITTED GET REQUEST URL PARAMETERS AND RETURN THE ENTITY AS ARRAY OR FALSE IF NOT FOUND. */

		if(!empty($row) && is_array($row)) {
			if(empty($row['mime_type'])) {
				$row['mime_type'] = (new finfo(FILEINFO_MIME))->buffer($row['data']);
			}

			/* TASK: ASSIGN STRING VALUE AS THE RESPONSE OUTPUT BODY CONTENT. */
			FrameworkSpecificV3s3Controller::task(
				'Assign string value as the response output body content.',
				[
					FrameworkSpecificV3s3Controller::TASK_ARGUMENTS_KEY=>[$row['data']],
					FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_TYPE_KEY=>FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_TYPE_CONTROLLER,
					FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CURRENT_INSTANCE_KEY=>$this,
					FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CLASS_METHOD_KEY=>__FUNCTION__,
					FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CLASS_METHOD_ARGUMENTS_KEY=>[[$this, __FUNCTION__], func_get_args()]
				]
			);
			/* END: ASSIGN STRING VALUE AS THE RESPONSE OUTPUT BODY CONTENT. */

			/* TASK: SEND MULTIPLE RESPONSE HEADERS FROM ARRAY. OVERWRITE EXISTING KEYS. */
			FrameworkSpecificV3s3Controller::task(
				'Send multiple response headers from array. Overwrite existing keys.',
				[
					FrameworkSpecificV3s3Controller::TASK_ARGUMENTS_KEY=>[
						[
							'v3s3-object-id'=>$row['id'],
							'Content-Type'=>$row['mime_type'],
							'Content-Length'=>strlen($row['data'])
						]
					],
					FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_TYPE_KEY=>FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_TYPE_CONTROLLER,
					FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CURRENT_INSTANCE_KEY=>$this,
					FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CLASS_METHOD_KEY=>__FUNCTION__,
					FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CLASS_METHOD_ARGUMENTS_KEY=>[[$this, __FUNCTION__], func_get_args()]
				]
			);
			/* END: SEND MULTIPLE RESPONSE HEADERS FROM ARRAY. OVERWRITE EXISTING KEYS. */

			if(
				!empty(
					/* TASK: GET SINGLE REQUEST URL QUERY PARAMETER. */
					FrameworkSpecificV3s3Controller::task(
						'Get single request URL query parameter.',
						[
							FrameworkSpecificV3s3Controller::TASK_ARGUMENTS_KEY=>['download'],
							FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_TYPE_KEY=>FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_TYPE_CONTROLLER,
							FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CURRENT_INSTANCE_KEY=>$this,
							FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CLASS_METHOD_KEY=>__FUNCTION__,
							FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CLASS_METHOD_ARGUMENTS_KEY=>[[$this, __FUNCTION__], func_get_args()]
						]
					)
					/* END: GET SINGLE REQUEST URL QUERY PARAMETER. */
				)
			) {
				$filename = basename($name);

				/* TASK: SET RESPONSE ATTACHMENT DOWNLOAD HEADER. */
				FrameworkSpecificV3s3Controller::task(
					'Set response attachment download header.',
					[
						FrameworkSpecificV3s3Controller::TASK_ARGUMENTS_KEY=>[$filename],
						FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_TYPE_KEY=>FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_TYPE_CONTROLLER,
						FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CURRENT_INSTANCE_KEY=>$this,
						FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CLASS_METHOD_KEY=>__FUNCTION__,
						FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CLASS_METHOD_ARGUMENTS_KEY=>[[$this, __FUNCTION__], func_get_args()]
					]
				);
				/* END: SET RESPONSE ATTACHMENT DOWNLOAD HEADER. */
			}

			return
				/* TASK: GET RESPONSE OBJECT. */
				FrameworkSpecificV3s3Controller::task(
					'Get response object.',
					[
						FrameworkSpecificV3s3Controller::TASK_ARGUMENTS_KEY=>[],
						FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_TYPE_KEY=>FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_TYPE_CONTROLLER,
						FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CURRENT_INSTANCE_KEY=>$this,
						FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CLASS_METHOD_KEY=>__FUNCTION__,
						FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CLASS_METHOD_ARGUMENTS_KEY=>[[$this, __FUNCTION__], func_get_args()]
					]
				);
				/* END: GET RESPONSE OBJECT. */
		} else {
			return
				/* TASK: SET RESPONSE STATUS. RETURN JSON RESPONSE. */
				FrameworkSpecificV3s3Controller::task(
					'Set response status. Return JSON response.',
					[
						FrameworkSpecificV3s3Controller::TASK_ARGUMENTS_KEY=>[
							404,
							[
								'status'=>1,
								'results'=>0,
								'message'=>FrameworkSpecificV3s3Translator::translate('V3S3_MESSAGE_404', $this) // TASK: TRANSLATE THE GIVEN STRING USING CURRENT LOCALE LANGUAGE AND THE PROVIDED TRANSLATOR MECHANISM AND TRANSLATION FILES.
							]
						],
						FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_TYPE_KEY=>FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_TYPE_CONTROLLER,
						FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CURRENT_INSTANCE_KEY=>$this,
						FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CLASS_METHOD_KEY=>__FUNCTION__,
						FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CLASS_METHOD_ARGUMENTS_KEY=>[[$this, __FUNCTION__], func_get_args()]
					]
				);
				/* END: SET RESPONSE STATUS. RETURN JSON RESPONSE. */
		}
	}

	/**
	 * @Route("/{name}", requirements={"name"=".+"}, name="v3s3_delete")
	 * @Method("DELETE")
	 */
	// 1. VALIDATE DELETE INPUT. RETURN TRUE IF SUCCESSFUL OR JSON RESPONSE ON ERROR.
	// 2. GET ALL URL QUERY PARAMETERS AS ARRAY.
	// 3. GET ROUTE PARAMETER OR REQUEST URL PATH. (as $name)
	// 4. SELECT ENTITY FROM PERMITTED DELETE REQUEST PARAMETERS, UPDATE THE STATUS FIELD TO DELETED AND RETURN THE UPDATED ENTITY AS ARRAY OR FALSE IF NOT FOUND.
	// {if no such entity has been found}
	// 5.1. SET RESPONSE STATUS. RETURN JSON RESPONSE. (return 404 status and a JSON response)
	// {else}
	// 5.2. SET SINGLE RESPONSE HEADER. RETURN JSON RESPONSE. (return a v3s3-object-id (ID of the deleted entity) header and a JSON response)
	// {endif}
	public function deleteAction($name, Request $request) {
		if(
			($inputValid =
				/* TASK: VALIDATE DELETE INPUT. RETURN TRUE IF SUCCESSFUL OR JSON RESPONSE ON ERROR. */
				FrameworkSpecificV3s3Controller::task(
					'Validate DELETE input. Return true if successful or JSON response on error.',
					[
						FrameworkSpecificV3s3Controller::TASK_ARGUMENTS_KEY=>[],
						FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_TYPE_KEY=>FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_TYPE_CONTROLLER,
						FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CURRENT_INSTANCE_KEY=>$this,
						FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CLASS_METHOD_KEY=>__FUNCTION__,
						FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CLASS_METHOD_ARGUMENTS_KEY=>[[$this, __FUNCTION__], func_get_args()]
					]
				)
				/* END: VALIDATE DELETE INPUT. RETURN TRUE IF SUCCESSFUL OR JSON RESPONSE ON ERROR. */
			) !== true
		) {
			return $inputValid;
		}

		$input =
			/* TASK: GET ALL REQUEST URL QUERY PARAMETERS AS ARRAY. */
			FrameworkSpecificV3s3Controller::task(
				'Get all request URL query parameters as array.',
				[
					FrameworkSpecificV3s3Controller::TASK_ARGUMENTS_KEY=>[],
					FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_TYPE_KEY=>FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_TYPE_CONTROLLER,
					FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CURRENT_INSTANCE_KEY=>$this,
					FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CLASS_METHOD_KEY=>__FUNCTION__,
					FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CLASS_METHOD_ARGUMENTS_KEY=>[[$this, __FUNCTION__], func_get_args()]
				]
			);
			/* TASK: GET ALL REQUEST URL QUERY PARAMETERS AS ARRAY. */

		$name =
			/* TASK: GET ROUTE PARAMETER OR REQUEST URL PATH. */
			FrameworkSpecificV3s3Controller::task(
				'Get route parameter or request URL path.',
				[
					FrameworkSpecificV3s3Controller::TASK_ARGUMENTS_KEY=>[],
					FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_TYPE_KEY=>FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_TYPE_CONTROLLER,
					FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CURRENT_INSTANCE_KEY=>$this,
					FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CLASS_METHOD_KEY=>__FUNCTION__,
					FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CLASS_METHOD_ARGUMENTS_KEY=>[[$this, __FUNCTION__], func_get_args()]
				]
			);
			/* END: GET ROUTE PARAMETER OR REQUEST URL PATH. */

		$row =
			/* TASK: SELECT ENTITY FROM PERMITTED DELETE REQUEST PARAMETERS, UPDATE THE STATUS FIELD TO DELETED AND RETURN THE UPDATED ENTITY AS ARRAY OR FALSE IF NOT FOUND. */
			FrameworkSpecificV3s3Controller::task(
				'Select entity from permitted DELETE request URL parameters, update the status field to deleted and return the updated entity as array or false if not found.',
				[
					FrameworkSpecificV3s3Controller::TASK_ARGUMENTS_KEY=>[
						array_replace(
							$input,
							[
								'name'=>$name,
								/* TASK: GET REQUEST CLIENT IP ADDRESS */
								'ip_deleted_from'=>FrameworkSpecificV3s3Controller::task(
									'Get request client ip address.',
									[
										FrameworkSpecificV3s3Controller::TASK_ARGUMENTS_KEY=>[],
										FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_TYPE_KEY=>FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_TYPE_CONTROLLER,
										FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CURRENT_INSTANCE_KEY=>$this,
										FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CLASS_METHOD_KEY=>__FUNCTION__,
										FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CLASS_METHOD_ARGUMENTS_KEY=>[[$this, __FUNCTION__], func_get_args()]
									]
								),
								/* END: GET REQUEST CLIENT IP ADDRESS */
							]
						)
					],
					FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_TYPE_KEY=>FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_TYPE_CONTROLLER,
					FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CURRENT_INSTANCE_KEY=>$this,
					FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CLASS_METHOD_KEY=>__FUNCTION__,
					FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CLASS_METHOD_ARGUMENTS_KEY=>[[$this, __FUNCTION__], func_get_args()]
				]
			);
			/* TASK: SELECT ENTITY FROM PERMITTED DELETE REQUEST PARAMETERS, UPDATE THE STATUS FIELD TO DELETED AND RETURN THE UPDATED ENTITY AS ARRAY OR FALSE IF NOT FOUND. */

		if(empty($row)) {
			return
				/* TASK: SET RESPONSE STATUS. RETURN JSON RESPONSE. */
				FrameworkSpecificV3s3Controller::task(
					'Set response status. Return JSON response.',
					[
						FrameworkSpecificV3s3Controller::TASK_ARGUMENTS_KEY=>[
							404,
							[
								'status'=>1,
								'results'=>0,
								'message'=>FrameworkSpecificV3s3Translator::translate('V3S3_MESSAGE_NO_MATCHING_RESOURCES', $this) // TASK: TRANSLATE THE GIVEN STRING USING CURRENT LOCALE LANGUAGE AND THE PROVIDED TRANSLATOR MECHANISM AND TRANSLATION FILES.
							]
						],
						FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_TYPE_KEY=>FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_TYPE_CONTROLLER,
						FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CURRENT_INSTANCE_KEY=>$this,
						FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CLASS_METHOD_KEY=>__FUNCTION__,
						FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CLASS_METHOD_ARGUMENTS_KEY=>[[$this, __FUNCTION__], func_get_args()]
					]
				);
				/* END: SET RESPONSE STATUS. RETURN JSON RESPONSE. */
		} else {
			return
				/* TASK: SET SINGLE RESPONSE HEADER. RETURN JSON RESPONSE. */
				FrameworkSpecificV3s3Controller::task(
					'Set single response header. Return JSON response.',
					[
						FrameworkSpecificV3s3Controller::TASK_ARGUMENTS_KEY=>[
							['v3s3-object-id', $row['id']],
							[
								'status'=>1,
								'results'=>1,
								'message'=>FrameworkSpecificV3s3Translator::translate('V3S3_MESSAGE_DELETE_OBJECT_DELETED_SUCCESSFULLY', $this) // TASK: TRANSLATE THE GIVEN STRING USING CURRENT LOCALE LANGUAGE AND THE PROVIDED TRANSLATOR MECHANISM AND TRANSLATION FILES.
							]
						],
						FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_TYPE_KEY=>FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_TYPE_CONTROLLER,
						FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CURRENT_INSTANCE_KEY=>$this,
						FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CLASS_METHOD_KEY=>__FUNCTION__,
						FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CLASS_METHOD_ARGUMENTS_KEY=>[[$this, __FUNCTION__], func_get_args()]
					]
				);
				/* END: SET SINGLE RESPONSE HEADER. RETURN JSON RESPONSE. */
		}
	}

	/**
	 * @Route("/{name}", requirements={"name"=".+"}, name="v3s3_post")
	 * @Method("POST")
	 */
	// 1. GET RAW REQUEST BODY CONTENT AS STRING.
	// 2. VALIDATE RAW POST REQUEST BODY CONTENT INPUT AND PARSE IT AS JSON. RETURN JSON RESPONSE ON ERROR.
	// 3. GET ROUTE PARAMETER OR REQUEST URL PATH. (as $name)
	// 4. SELECT MULTIPLE ENTITIES RESULT SET FROM PERMITTED PARAMETERS FROM THE POST JSON FILTER KEY AND RETURN THE RESULT SET AS ARRAY.
	// {if at least one entity has been found}
	//  {if format is xml}
	//   5.1.1. CREATE XML RESPONSE.
	//  {else if format is html}
	//   5.1.2. CREATE HTML RESPONSE.
	//  {else}
	//   5.1.3. CREATE JSON RESPONSE WITH PRETTY PRINT.
	//  {endif}
	// {else}
	//  5.2. CREATE JSON RESPONSE
	// {endif}
	public function postAction($name, Request $request) {
		$input =
			/* TASK: GET RAW REQUEST BODY CONTENT AS STRING. */
			FrameworkSpecificV3s3Controller::task(
				'Get raw request body content as string.',
				[
					FrameworkSpecificV3s3Controller::TASK_ARGUMENTS_KEY=>[],
					FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_TYPE_KEY=>FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_TYPE_CONTROLLER,
					FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CURRENT_INSTANCE_KEY=>$this,
					FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CLASS_METHOD_KEY=>__FUNCTION__,
					FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CLASS_METHOD_ARGUMENTS_KEY=>[[$this, __FUNCTION__], func_get_args()]
				]
			);
			/* END: GET RAW REQUEST BODY CONTENT AS STRING. */

		$parsed_input =
			/* TASK: VALIDATE RAW POST REQUEST BODY CONTENT INPUT AND PARSE IT AS JSON. RETURN JSON RESPONSE ON ERROR. */
			FrameworkSpecificV3s3Controller::task(
				'Validate raw POST request body content input and parse it as JSON. Return JSON response on error.',
				[
					FrameworkSpecificV3s3Controller::TASK_ARGUMENTS_KEY=>[$input],
					FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_TYPE_KEY=>FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_TYPE_CONTROLLER,
					FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CURRENT_INSTANCE_KEY=>$this,
					FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CLASS_METHOD_KEY=>__FUNCTION__,
					FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CLASS_METHOD_ARGUMENTS_KEY=>[[$this, __FUNCTION__], func_get_args()]
				]
			);
			/* END: VALIDATE RAW POST REQUEST BODY CONTENT INPUT AND PARSE IT AS JSON. RETURN JSON RESPONSE ON ERROR. */

		$name =
			/* TASK: GET ROUTE PARAMETER OR REQUEST URL PATH. */
			FrameworkSpecificV3s3Controller::task(
				'Get route parameter or request URL path.',
				[
					FrameworkSpecificV3s3Controller::TASK_ARGUMENTS_KEY=>[],
					FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_TYPE_KEY=>FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_TYPE_CONTROLLER,
					FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CURRENT_INSTANCE_KEY=>$this,
					FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CLASS_METHOD_KEY=>__FUNCTION__,
					FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CLASS_METHOD_ARGUMENTS_KEY=>[[$this, __FUNCTION__], func_get_args()]
				]
			);
			/* END: GET ROUTE PARAMETER OR REQUEST URL PATH. */

		$attr = (!empty($parsed_input['filter'])?$parsed_input['filter']:[]);
		if(!empty($name) && ($name != '/')) {
			$attr['name'] = $name;
		}

		$rows =
			/* TASK: SELECT MULTIPLE ENTITIES RESULT SET FROM PERMITTED PARAMETERS FROM THE POST JSON FILTER KEY AND RETURN THE RESULT SET AS ARRAY. */
			FrameworkSpecificV3s3Controller::task(
				'Select multiple entities result set from permitted parameters from the POST JSON filter key and return the result set as array or false if not found.',
				[
					FrameworkSpecificV3s3Controller::TASK_ARGUMENTS_KEY=>[$attr],
					FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_TYPE_KEY=>FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_TYPE_CONTROLLER,
					FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CURRENT_INSTANCE_KEY=>$this,
					FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CLASS_METHOD_KEY=>__FUNCTION__,
					FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CLASS_METHOD_ARGUMENTS_KEY=>[[$this, __FUNCTION__], func_get_args()]
				]
			);
			/* END: SELECT MULTIPLE ENTITIES RESULT SET FROM PERMITTED PARAMETERS FROM THE POST JSON FILTER KEY AND RETURN THE RESULT SET AS ARRAY. */

		if(!empty($rows)) {
			// remove irrelevant columns from the result and format others accordingly
			foreach ($rows as &$_row) {
				unset($_row['id']);
				unset($_row['timestamp']);
				unset($_row['hash_name']);
				unset($_row['timestamp_deleted']);
				if(empty($_row['mime_type'])) {
					$_row['mime_type'] = (new finfo(FILEINFO_MIME))->buffer($_row['data']).' (determined using PHP finfo)';
				}
				$_row['data'] = (new finfo(FILEINFO_MIME))->buffer($_row['data']);
			}

			$format = ((!empty($parsed_input['format'])&&in_array($parsed_input['format'], ['json', 'xml', 'html']))?strtolower($parsed_input['format']):'json');
			switch($format) {
				case 'xml':
					$rows =
						/* TASK: CREATE XML FROM ARRAY USING HELPER. */
						FrameworkSpecificV3s3Controller::task(
							'Create XML from array using helper.',
							[
								FrameworkSpecificV3s3Controller::TASK_ARGUMENTS_KEY=>[$rows],
								FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_TYPE_KEY=>FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_TYPE_CONTROLLER,
								FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CURRENT_INSTANCE_KEY=>$this,
								FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CLASS_METHOD_KEY=>__FUNCTION__,
								FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CLASS_METHOD_ARGUMENTS_KEY=>[[$this, __FUNCTION__], func_get_args()]
							]
						);
						/* END: CREATE XML FROM ARRAY USING HELPER. */

					return
						/* TASK: CREATE XML RESPONSE. */
						FrameworkSpecificV3s3Controller::task(
							'Create XML response.',
							[
								FrameworkSpecificV3s3Controller::TASK_ARGUMENTS_KEY=>[$rows],
								FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_TYPE_KEY=>FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_TYPE_CONTROLLER,
								FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CURRENT_INSTANCE_KEY=>$this,
								FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CLASS_METHOD_KEY=>__FUNCTION__,
								FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CLASS_METHOD_ARGUMENTS_KEY=>[[$this, __FUNCTION__], func_get_args()]
							]
						);
						/* END: CREATE XML RESPONSE. */
					break;
				case 'html':
					$rows =
						/* TASK: CREATE HTML FROM ARRAY USING HELPER. */
						FrameworkSpecificV3s3Controller::task(
							'Create HTML from array using helper.',
							[
								FrameworkSpecificV3s3Controller::TASK_ARGUMENTS_KEY=>[$rows],
								FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_TYPE_KEY=>FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_TYPE_CONTROLLER,
								FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CURRENT_INSTANCE_KEY=>$this,
								FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CLASS_METHOD_KEY=>__FUNCTION__,
								FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CLASS_METHOD_ARGUMENTS_KEY=>[[$this, __FUNCTION__], func_get_args()]
							]
						);
						/* END: CREATE HTML FROM ARRAY USING HELPER. */

					return
						/* TASK: CREATE HTML RESPONSE. */
						FrameworkSpecificV3s3Controller::task(
							'Create HTML response.',
							[
								FrameworkSpecificV3s3Controller::TASK_ARGUMENTS_KEY=>[$rows],
								FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_TYPE_KEY=>FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_TYPE_CONTROLLER,
								FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CURRENT_INSTANCE_KEY=>$this,
								FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CLASS_METHOD_KEY=>__FUNCTION__,
								FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CLASS_METHOD_ARGUMENTS_KEY=>[[$this, __FUNCTION__], func_get_args()]
							]
						);
						/* END: CREATE HTML RESPONSE. */
					break;
				case 'json':
				default:
					return
						/* TASK: CREATE JSON RESPONSE WITH PRETTY PRINT. */
						FrameworkSpecificV3s3Controller::task(
							'Create JSON response with pretty print.',
							[
								FrameworkSpecificV3s3Controller::TASK_ARGUMENTS_KEY=>[$rows],
								FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_TYPE_KEY=>FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_TYPE_CONTROLLER,
								FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CURRENT_INSTANCE_KEY=>$this,
								FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CLASS_METHOD_KEY=>__FUNCTION__,
								FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CLASS_METHOD_ARGUMENTS_KEY=>[[$this, __FUNCTION__], func_get_args()]
							]
						);
						/* END: CREATE JSON RESPONSE WITH PRETTY PRINT. */
					break;
			}
		} else {
			return
				/* TASK: CREATE JSON RESPONSE. */
				FrameworkSpecificV3s3Controller::task(
					'Create JSON response.',
					[
						FrameworkSpecificV3s3Controller::TASK_ARGUMENTS_KEY=>[
							[
								'status'=>1,
								'results'=>0,
								'message'=>FrameworkSpecificV3s3Translator::translate('V3S3_MESSAGE_NO_MATCHING_RESOURCES', $this) // TASK: TRANSLATE THE GIVEN STRING USING CURRENT LOCALE LANGUAGE AND THE PROVIDED TRANSLATOR MECHANISM AND TRANSLATION FILES.
							]
						],
						FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_TYPE_KEY=>FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_TYPE_CONTROLLER,
						FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CURRENT_INSTANCE_KEY=>$this,
						FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CLASS_METHOD_KEY=>__FUNCTION__,
						FrameworkSpecificV3s3Controller::TASK_MVC_COMPONENT_CLASS_METHOD_ARGUMENTS_KEY=>[[$this, __FUNCTION__], func_get_args()]
					]
				);
				/* END: CREATE JSON RESPONSE. */
		}
	}
}