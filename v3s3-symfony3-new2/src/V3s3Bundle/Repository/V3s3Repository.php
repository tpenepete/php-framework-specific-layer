<?php

namespace V3s3Bundle\Repository;

use V3s3Bundle\Entity\V3s3;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

use V3s3Bundle\FrameworkSpecific\SF3\Repository\V3s3Repository as FrameworkSpecificV3s3Repository;

class V3s3Repository extends EntityRepository {
	// 1. GET ALL OR FILLABLE ENTITY PROPERTIES OR TABLE COLUMNS AS ARRAY.
	// 2. INSERT ENTITY INTO STORAGE AND RETURN THE ENTITY OBJECT.
	public function put(Array $attr) {
		$attr = array_intersect_key(
			$attr,
			/* TASK: GET ALL OR FILLABLE ENTITY PROPERTIES OR TABLE COLUMNS AS ARRAY. */
			FrameworkSpecificV3s3Repository::task(
				'Get all or fillable entity properties or table columns as array.',
				[
					FrameworkSpecificV3s3Repository::TASK_ARGUMENTS_KEY=>[],
					FrameworkSpecificV3s3Repository::TASK_MVC_COMPONENT_TYPE_KEY=>FrameworkSpecificV3s3Repository::TASK_MVC_COMPONENT_TYPE_REPOSITORY,
					FrameworkSpecificV3s3Repository::TASK_MVC_COMPONENT_CURRENT_INSTANCE_KEY=>$this,
					FrameworkSpecificV3s3Repository::TASK_MVC_COMPONENT_CLASS_METHOD_KEY=>__FUNCTION__,
					FrameworkSpecificV3s3Repository::TASK_MVC_COMPONENT_CLASS_METHOD_ARGUMENTS_KEY=>[[$this, __FUNCTION__], func_get_args()]
				]
			)
			/* TASK: GET ALL OR FILLABLE ENTITY PROPERTIES OR TABLE COLUMNS AS ARRAY. */
		);
		$attr['timestamp'] = (isset($attr['timestamp'])?$attr['timestamp']:time());
		$attr['date_time'] = date('Y-m-d H:i:s O', $attr['timestamp']);
		if(isset($attr['name'])) {
			$attr['hash_name'] = sha1($attr['name']);
		} else {
			unset($attr['hash_name']);
		}
		$attr['status'] = (isset($attr['status'])?$attr['status']:V3s3::STATUS_ACTIVE);
		unset($attr['id']);

		return
			/* TASK: INSERT ENTITY INTO STORAGE AND RETURN THE ENTITY OBJECT. */
			FrameworkSpecificV3s3Repository::task(
				'Insert entity into storage and return the entity object.',
				[
					FrameworkSpecificV3s3Repository::TASK_ARGUMENTS_KEY=>[$attr],
					FrameworkSpecificV3s3Repository::TASK_MVC_COMPONENT_TYPE_KEY=>FrameworkSpecificV3s3Repository::TASK_MVC_COMPONENT_TYPE_REPOSITORY,
					FrameworkSpecificV3s3Repository::TASK_MVC_COMPONENT_CURRENT_INSTANCE_KEY=>$this,
					FrameworkSpecificV3s3Repository::TASK_MVC_COMPONENT_CLASS_METHOD_KEY=>__FUNCTION__,
					FrameworkSpecificV3s3Repository::TASK_MVC_COMPONENT_CLASS_METHOD_ARGUMENTS_KEY=>[[$this, __FUNCTION__], func_get_args()]
				]
			);
			/* TASK: INSERT ENTITY INTO STORAGE AND RETURN THE ENTITY OBJECT. */
	}

	// 1. GET ALL OR FILLABLE ENTITY PROPERTIES OR TABLE COLUMNS AS ARRAY.
	// 2. FETCH ONE SINGLE ENTITY RESULT SET.
	// 3. GET FETCH RESULT ROW COUNT.
	// 4. GET ONE SINGLE FIRST OR CURRENT ENTITY OBJECT FROM RESULT SET.
	public function get(Array $attr) {
		$attr = array_intersect_key(
			$attr,
			/* TASK: GET ALL OR FILLABLE ENTITY PROPERTIES OR TABLE COLUMNS AS ARRAY. */
			FrameworkSpecificV3s3Repository::task(
				'Get all or fillable entity properties or table columns as array.',
				[
					FrameworkSpecificV3s3Repository::TASK_ARGUMENTS_KEY=>[],
					FrameworkSpecificV3s3Repository::TASK_MVC_COMPONENT_TYPE_KEY=>FrameworkSpecificV3s3Repository::TASK_MVC_COMPONENT_TYPE_REPOSITORY,
					FrameworkSpecificV3s3Repository::TASK_MVC_COMPONENT_CURRENT_INSTANCE_KEY=>$this,
					FrameworkSpecificV3s3Repository::TASK_MVC_COMPONENT_CLASS_METHOD_KEY=>__FUNCTION__,
					FrameworkSpecificV3s3Repository::TASK_MVC_COMPONENT_CLASS_METHOD_ARGUMENTS_KEY=>[[$this, __FUNCTION__], func_get_args()]
				]
			)
			/* TASK: GET ALL OR FILLABLE ENTITY PROPERTIES OR TABLE COLUMNS AS ARRAY. */
		);

		if(isset($attr['name'])) {
			$attr['hash_name'] = sha1($attr['name']);
		} else {
			unset($attr['hash_name']);
		}
		unset($attr['name']);


		$row =
			/* TASK: FETCH ONE SINGLE ENTITY RESULT SET. */
			FrameworkSpecificV3s3Repository::task(
				'Fetch one single entity result set.',
				[
					FrameworkSpecificV3s3Repository::TASK_ARGUMENTS_KEY=>[
						'where'=>$attr,
						'orderBy'=>['id'=>'DESC'],
						'limit'=>1
					],
					FrameworkSpecificV3s3Repository::TASK_MVC_COMPONENT_TYPE_KEY=>FrameworkSpecificV3s3Repository::TASK_MVC_COMPONENT_TYPE_REPOSITORY,
					FrameworkSpecificV3s3Repository::TASK_MVC_COMPONENT_CURRENT_INSTANCE_KEY=>$this,
					FrameworkSpecificV3s3Repository::TASK_MVC_COMPONENT_CLASS_METHOD_KEY=>__FUNCTION__,
					FrameworkSpecificV3s3Repository::TASK_MVC_COMPONENT_CLASS_METHOD_ARGUMENTS_KEY=>[[$this, __FUNCTION__], func_get_args()]
				]
			);
			/* TASK: FETCH ONE SINGLE ENTITY RESULT SET. */

		$rows_count =
			/* TASK: GET FETCH RESULT ROW COUNT. */
			FrameworkSpecificV3s3Repository::task(
				'Get fetch result row count.',
				[
					FrameworkSpecificV3s3Repository::TASK_ARGUMENTS_KEY=>[$row],
					FrameworkSpecificV3s3Repository::TASK_MVC_COMPONENT_TYPE_KEY=>FrameworkSpecificV3s3Repository::TASK_MVC_COMPONENT_TYPE_REPOSITORY,
					FrameworkSpecificV3s3Repository::TASK_MVC_COMPONENT_CURRENT_INSTANCE_KEY=>$this,
					FrameworkSpecificV3s3Repository::TASK_MVC_COMPONENT_CLASS_METHOD_KEY=>__FUNCTION__,
					FrameworkSpecificV3s3Repository::TASK_MVC_COMPONENT_CLASS_METHOD_ARGUMENTS_KEY=>[[$this, __FUNCTION__], func_get_args()]
				]
			);
			/* TASK: GET FETCH RESULT ROW COUNT. */

		if(empty($rows_count)) {
			return false;
		}

		return
			/* TASK: GET ONE SINGLE FIRST OR CURRENT ENTITY OBJECT FROM RESULT SET. */
			FrameworkSpecificV3s3Repository::task(
				'Get one single first or current entity object from result set.',
				[
					FrameworkSpecificV3s3Repository::TASK_ARGUMENTS_KEY=>[$row],
					FrameworkSpecificV3s3Repository::TASK_MVC_COMPONENT_TYPE_KEY=>FrameworkSpecificV3s3Repository::TASK_MVC_COMPONENT_TYPE_REPOSITORY,
					FrameworkSpecificV3s3Repository::TASK_MVC_COMPONENT_CURRENT_INSTANCE_KEY=>$this,
					FrameworkSpecificV3s3Repository::TASK_MVC_COMPONENT_CLASS_METHOD_KEY=>__FUNCTION__,
					FrameworkSpecificV3s3Repository::TASK_MVC_COMPONENT_CLASS_METHOD_ARGUMENTS_KEY=>[[$this, __FUNCTION__], func_get_args()]
				]
			);
			/* TASK: GET ONE SINGLE FIRST OR CURRENT ENTITY OBJECT FROM RESULT SET. */
	}

	// 1. GET ALL OR FILLABLE ENTITY PROPERTIES OR TABLE COLUMNS AS ARRAY.
	// 2. FETCH ONE SINGLE ENTITY RESULT SET.
	// 3. GET FETCH RESULT ROW COUNT.
	// 4. GET ONE SINGLE FIRST OR CURRENT ENTITY OBJECT FROM RESULT SET.
	// 5. UPDATE ENTITY IN STORAGE AND RETURN THE ENTITY AS ARRAY.
	public function api_delete(Array $attr) {
		$attr = array_intersect_key(
			$attr,
			/* TASK: GET ALL OR FILLABLE ENTITY PROPERTIES OR TABLE COLUMNS AS ARRAY. */
			FrameworkSpecificV3s3Repository::task(
				'Get all or fillable entity properties or table columns as array.',
				[
					FrameworkSpecificV3s3Repository::TASK_ARGUMENTS_KEY=>[],
					FrameworkSpecificV3s3Repository::TASK_MVC_COMPONENT_TYPE_KEY=>FrameworkSpecificV3s3Repository::TASK_MVC_COMPONENT_TYPE_REPOSITORY,
					FrameworkSpecificV3s3Repository::TASK_MVC_COMPONENT_CURRENT_INSTANCE_KEY=>$this,
					FrameworkSpecificV3s3Repository::TASK_MVC_COMPONENT_CLASS_METHOD_KEY=>__FUNCTION__,
					FrameworkSpecificV3s3Repository::TASK_MVC_COMPONENT_CLASS_METHOD_ARGUMENTS_KEY=>[[$this, __FUNCTION__], func_get_args()]
				]
			)
			/* TASK: GET ALL OR FILLABLE ENTITY PROPERTIES OR TABLE COLUMNS AS ARRAY. */
		);

		$attr['timestamp_deleted'] = (isset($attr['timestamp_deleted'])?$attr['timestamp_deleted']:time());
		$attr['date_time_deleted'] = date('Y-m-d H:i:s O', $attr['timestamp_deleted']);
		if(isset($attr['name'])) {
			$attr['hash_name'] = sha1($attr['name']);
		} else {
			unset($attr['hash_name']);
		}
		$attr['status'] = (isset($attr['status'])?$attr['status']:V3s3::STATUS_DELETED);
		unset($attr['name']);

		$where = $attr;
		unset($where['status']);
		unset($where['timestamp_deleted']);
		unset($where['date_time_deleted']);
		unset($where['ip_deleted_from']);

		$row =
			/* TASK: FETCH ONE SINGLE ENTITY RESULT SET. */
			FrameworkSpecificV3s3Repository::task(
				'Fetch one single entity result set.',
				[
					FrameworkSpecificV3s3Repository::TASK_ARGUMENTS_KEY=>[
						'where'=>$where,
						'orderBy'=>['id'=>'DESC'],
						'limit'=>1
					],
					FrameworkSpecificV3s3Repository::TASK_MVC_COMPONENT_TYPE_KEY=>FrameworkSpecificV3s3Repository::TASK_MVC_COMPONENT_TYPE_REPOSITORY,
					FrameworkSpecificV3s3Repository::TASK_MVC_COMPONENT_CURRENT_INSTANCE_KEY=>$this,
					FrameworkSpecificV3s3Repository::TASK_MVC_COMPONENT_CLASS_METHOD_KEY=>__FUNCTION__,
					FrameworkSpecificV3s3Repository::TASK_MVC_COMPONENT_CLASS_METHOD_ARGUMENTS_KEY=>[[$this, __FUNCTION__], func_get_args()]
				]
			);
			/* TASK: FETCH ONE SINGLE ENTITY RESULT SET. */

		$rows_count =
			/* TASK: GET FETCH RESULT ROW COUNT. */
			FrameworkSpecificV3s3Repository::task(
				'Get fetch result row count.',
				[
					FrameworkSpecificV3s3Repository::TASK_ARGUMENTS_KEY=>[$row],
					FrameworkSpecificV3s3Repository::TASK_MVC_COMPONENT_TYPE_KEY=>FrameworkSpecificV3s3Repository::TASK_MVC_COMPONENT_TYPE_REPOSITORY,
					FrameworkSpecificV3s3Repository::TASK_MVC_COMPONENT_CURRENT_INSTANCE_KEY=>$this,
					FrameworkSpecificV3s3Repository::TASK_MVC_COMPONENT_CLASS_METHOD_KEY=>__FUNCTION__,
					FrameworkSpecificV3s3Repository::TASK_MVC_COMPONENT_CLASS_METHOD_ARGUMENTS_KEY=>[[$this, __FUNCTION__], func_get_args()]
				]
			);
			/* TASK: GET FETCH RESULT ROW COUNT. */

		if(empty($rows_count)) {
			return false;
		}

		$row =
			/* TASK: GET ONE SINGLE FIRST OR CURRENT ENTITY OBJECT FROM RESULT SET. */
			FrameworkSpecificV3s3Repository::task(
				'Get one single first or current entity object from result set.',
				[
					FrameworkSpecificV3s3Repository::TASK_ARGUMENTS_KEY=>[$row],
					FrameworkSpecificV3s3Repository::TASK_MVC_COMPONENT_TYPE_KEY=>FrameworkSpecificV3s3Repository::TASK_MVC_COMPONENT_TYPE_REPOSITORY,
					FrameworkSpecificV3s3Repository::TASK_MVC_COMPONENT_CURRENT_INSTANCE_KEY=>$this,
					FrameworkSpecificV3s3Repository::TASK_MVC_COMPONENT_CLASS_METHOD_KEY=>__FUNCTION__,
					FrameworkSpecificV3s3Repository::TASK_MVC_COMPONENT_CLASS_METHOD_ARGUMENTS_KEY=>[[$this, __FUNCTION__], func_get_args()]
				]
			);
		/* TASK: GET ONE SINGLE FIRST OR CURRENT ENTITY OBJECT FROM RESULT SET. */

		return
			/* TASK: UPDATE ENTITY IN STORAGE AND RETURN THE ENTITY AS ARRAY. */
			FrameworkSpecificV3s3Repository::task(
				'Update entity in storage and return the entity as array.',
				[
					FrameworkSpecificV3s3Repository::TASK_ARGUMENTS_KEY=>[$row, $attr],
					FrameworkSpecificV3s3Repository::TASK_MVC_COMPONENT_TYPE_KEY=>FrameworkSpecificV3s3Repository::TASK_MVC_COMPONENT_TYPE_REPOSITORY,
					FrameworkSpecificV3s3Repository::TASK_MVC_COMPONENT_CURRENT_INSTANCE_KEY=>$this,
					FrameworkSpecificV3s3Repository::TASK_MVC_COMPONENT_CLASS_METHOD_KEY=>__FUNCTION__,
					FrameworkSpecificV3s3Repository::TASK_MVC_COMPONENT_CLASS_METHOD_ARGUMENTS_KEY=>[[$this, __FUNCTION__], func_get_args()]
				]
			);
			/* TASK: UPDATE ENTITY IN STORAGE AND RETURN THE ENTITY AS ARRAY. */
	}

	// 1. GET ALL OR FILLABLE ENTITY PROPERTIES OR TABLE COLUMNS AS ARRAY.
	// 2. FETCH MULTIPLE ENTITIES RESULT SET.
	// 3. GET FETCH RESULT ROW COUNT.
	public function post(Array $attr) {
		$attr = array_intersect_key(
			$attr,
			/* TASK: GET ALL OR FILLABLE ENTITY PROPERTIES OR TABLE COLUMNS AS ARRAY. */
			FrameworkSpecificV3s3Repository::task(
				'Get all or fillable entity properties or table columns as array.',
				[
					FrameworkSpecificV3s3Repository::TASK_ARGUMENTS_KEY=>[],
					FrameworkSpecificV3s3Repository::TASK_MVC_COMPONENT_TYPE_KEY=>FrameworkSpecificV3s3Repository::TASK_MVC_COMPONENT_TYPE_REPOSITORY,
					FrameworkSpecificV3s3Repository::TASK_MVC_COMPONENT_CURRENT_INSTANCE_KEY=>$this,
					FrameworkSpecificV3s3Repository::TASK_MVC_COMPONENT_CLASS_METHOD_KEY=>__FUNCTION__,
					FrameworkSpecificV3s3Repository::TASK_MVC_COMPONENT_CLASS_METHOD_ARGUMENTS_KEY=>[[$this, __FUNCTION__], func_get_args()]
				]
			)
			/* TASK: GET ALL OR FILLABLE ENTITY PROPERTIES OR TABLE COLUMNS AS ARRAY. */
		);
		if(isset($attr['name'])) {
			$attr['hash_name'] = sha1($attr['name']);
		} else {
			unset($attr['hash_name']);
		}
		unset($attr['name']);

		$rows =
			/* TASK: FETCH MULTIPLE ENTITIES RESULT SET. */
			FrameworkSpecificV3s3Repository::task(
				'Fetch multiple entities result set.',
				[
					FrameworkSpecificV3s3Repository::TASK_ARGUMENTS_KEY=>[
						'where'=>$attr,
					],
					FrameworkSpecificV3s3Repository::TASK_MVC_COMPONENT_TYPE_KEY=>FrameworkSpecificV3s3Repository::TASK_MVC_COMPONENT_TYPE_REPOSITORY,
					FrameworkSpecificV3s3Repository::TASK_MVC_COMPONENT_CURRENT_INSTANCE_KEY=>$this,
					FrameworkSpecificV3s3Repository::TASK_MVC_COMPONENT_CLASS_METHOD_KEY=>__FUNCTION__,
					FrameworkSpecificV3s3Repository::TASK_MVC_COMPONENT_CLASS_METHOD_ARGUMENTS_KEY=>[[$this, __FUNCTION__], func_get_args()]
				]
			);
		/* TASK: FETCH MULTIPLE ENTITIES RESULT SET. */

		$rows_count =
			/* TASK: GET FETCH RESULT ROW COUNT. */
			FrameworkSpecificV3s3Repository::task(
				'Get fetch result row count.',
				[
					FrameworkSpecificV3s3Repository::TASK_ARGUMENTS_KEY=>[$rows],
					FrameworkSpecificV3s3Repository::TASK_MVC_COMPONENT_TYPE_KEY=>FrameworkSpecificV3s3Repository::TASK_MVC_COMPONENT_TYPE_REPOSITORY,
					FrameworkSpecificV3s3Repository::TASK_MVC_COMPONENT_CURRENT_INSTANCE_KEY=>$this,
					FrameworkSpecificV3s3Repository::TASK_MVC_COMPONENT_CLASS_METHOD_KEY=>__FUNCTION__,
					FrameworkSpecificV3s3Repository::TASK_MVC_COMPONENT_CLASS_METHOD_ARGUMENTS_KEY=>[[$this, __FUNCTION__], func_get_args()]
				]
			);
			/* TASK: GET FETCH RESULT ROW COUNT. */

		return (!empty($rows_count)?$rows:[]);
	}
}
