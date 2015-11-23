<?php

/**
 *
 * @see XenForo_DataWriter_Discussion_Thread
 */
class ThemeHouse_AnonymousPosts_Extend_XenForo_DataWriter_Discussion_Thread extends XFCP_ThemeHouse_AnonymousPosts_Extend_XenForo_DataWriter_Discussion_Thread
{

	/**
	 *
	 * @see XenForo_DataWriter_Discussion_Thread::_getFields()
	 */
	protected function _getFields()
	{
		$fields = parent::_getFields();
		$fields['xf_thread']['anonymous_thread'] = array(
			'type' => self::TYPE_BOOLEAN,
			'default' => 0
		);
		$fields['xf_thread']['last_post_anonymous'] = array(
			'type' => self::TYPE_BOOLEAN,
			'default' => 0
		);
		return $fields;
	} /* END _getFields */

	/**
	 *
	 * @see XenForo_DataWriter_Discussion_Thread::_discussionPreSave()
	 */
	protected function _discussionPreSave()
	{
		$visitor = XenForo_Visitor::getInstance();
		if (isset($GLOBALS['XenForo_ControllerPublic_Forum'])) {
			/* @var $controller XenForo_ControllerPublic_Forum */
			$controller = $GLOBALS['XenForo_ControllerPublic_Forum'];
			$userId = $this->get('user_id');
			$nodeId = $controller->getInput()->filterSingle('node_id', XenForo_Input::UINT);
			if ($this->_canMakeAnonymouThread($userId, $nodeId)) {
				if (XenForo_Application::get('options')->th_anonymousPosts_defaultAnonymous && $this->isInsert() && $visitor->hasPermission('general', 'seeAnonymousPostAuthor')) {
					$this->set('anonymous_thread', 1);
				} else {
					$this->set('anonymous_thread',
						$controller->getInput()
							->filterSingle('anonymous_thread', XenForo_Input::BOOLEAN));
				}
			}
		}

		if (isset($GLOBALS['last_post_anonymous'] )) {
			$this->set('last_post_anonymous', 1);
		}
		return parent::_discussionPreSave();
	} /* END _discussionPreSave */

	protected function _canMakeAnonymouThread($userId, $nodeId)
	{
		$userFetchOptions = array(
			'join' => XenForo_Model_User::FETCH_USER_PERMISSIONS
		);
		$user = $this->_getUserModel()->getUserById($userId, $userFetchOptions);
		$user['permissions'] = @unserialize($user['global_permission_cache']);

		$nodePermissions = $this->_getNodeModel()->getNodePermissionsForPermissionCombination($user['permission_combination_id']);

		return XenForo_Permission::hasContentPermission($nodePermissions[$nodeId], 'postAnonymousReply');
	}

	protected function _postSaveAfterTransaction()
	{
		return parent::_postSaveAfterTransaction();
	}

	/**
	 * @return XenForo_Model_Node
	 */
	protected function _getNodeModel()
	{
		return $this->getModelFromCache('XenForo_Model_Node');
	}
}