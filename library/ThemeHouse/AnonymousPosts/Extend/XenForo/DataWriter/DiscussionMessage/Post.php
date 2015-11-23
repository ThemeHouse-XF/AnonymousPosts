<?php

/**
 *
 * @see XenForo_DataWriter_DiscussionMessage_Post
 */
class ThemeHouse_AnonymousPosts_Extend_XenForo_DataWriter_DiscussionMessage_Post extends XFCP_ThemeHouse_AnonymousPosts_Extend_XenForo_DataWriter_DiscussionMessage_Post
{

	/**
	 *
	 * @see XenForo_DataWriter_DiscussionMessage_Post::_getFields()
	 */
	protected function _getFields()
	{
		$fields = parent::_getFields();
		$fields['xf_post']['anonymous_post'] = array(
			'type' => self::TYPE_BOOLEAN,
			'default' => 0
		);
		return $fields;
	} /* END _getFields */

	/**
	 *
	 * @see XenForo_DataWriter_DiscussionMessage_Post::_messagePreSave()
	 */
	protected function _messagePreSave()
	{
		$userId = $this->get('user_id');
		$visitor = XenForo_Visitor::getInstance();
		if (isset($GLOBALS['XenForo_ControllerPublic_Thread'])) {
			/* @var $controller XenForo_ControllerPublic_Thread */
			$controller = $GLOBALS['XenForo_ControllerPublic_Thread'];
			$thread = $this->_getThreadModel()->getThreadById($controller->getInput()->filterSingle('thread_id', XenForo_Input::UINT));
			$nodeId = $thread['node_id'];
			if ($this->_canMakeAnonymousPost($userId, $nodeId)) {
				if (XenForo_Application::get('options')->th_anonymousPosts_defaultAnonymous && $this->isInsert() && $visitor->hasPermission('general',
						'seeAnonymousPostAuthor')
				) {
					$this->set('anonymous_post', 1);
				} else {

					$this->set('anonymous_post',
						$controller->getInput()
							->filterSingle('anonymous_post', XenForo_Input::BOOLEAN));
				}
			}
		}
		if ($this->isDiscussionFirstMessage() && isset($GLOBALS['XenForo_ControllerPublic_Forum'])) {
			/* @var $controller XenForo_ControllerPublic_Forum */
			$controller = $GLOBALS['XenForo_ControllerPublic_Forum'];
			$nodeId = $controller->getInput()->filterSingle('node_id', XenForo_Input::UINT);
			if ($this->_canMakeAnonymousPost($userId, $nodeId)) {
				if ($controller->getInput()->filterSingle('anonymous_thread',
						XenForo_Input::BOOLEAN) || (XenForo_Application::get('options')->th_anonymousPosts_defaultAnonymous && $this->isInsert() && $visitor->hasPermission('general',
							'seeAnonymousPostAuthor'))
				) {
					$this->set('anonymous_post', '1');
				}
			}
		}

		$anonymousPost = $this->get('anonymous_post');
		if ($anonymousPost) {
			$GLOBALS['last_post_anonymous'] = 1;
		}
		return parent::_messagePreSave();
	} /* END _messagePreSave */

	protected function _canMakeAnonymousPost($userId, $nodeId)
	{
		$userFetchOptions = array(
			'join' => XenForo_Model_User::FETCH_USER_PERMISSIONS
		);
		$user = $this->_getUserModel()->getUserById($userId, $userFetchOptions);
		$user['permissions'] = @unserialize($user['global_permission_cache']);

		$nodePermissions = $this->_getNodeModel()->getNodePermissionsForPermissionCombination($user['permission_combination_id']);

		return XenForo_Permission::hasContentPermission($nodePermissions[$nodeId], 'postAnonymousReply');
	}


	/**
	 *
	 * @see XenForo_DataWriter_DiscussionMessage_Post::_postSaveAfterTransaction()
	 */
	protected function _postSaveAfterTransaction()
	{
		if ($this->get('anonymous_post')) {
			$this->set('username', 'Anonymous', '', array(
				'setAfterPreSave' => true
			));
			$this->set('user_id', '0', '', array(
				'setAfterPreSave' => true
			));
			$this->set('email', '', '', array(
				'setAfterPreSave' => true
			));
		}
		return parent::_postSaveAfterTransaction();
	} /* END _postSaveAfterTransaction */

	/**
	 * @return XenForo_Model_Node
	 */
	protected function _getNodeModel()
	{
		return $this->getModelFromCache('XenForo_Model_Node');
	}
}

if (false) {
	class XFCP_ThemeHouse_AnonymousPosts_Extend_XenForo_DataWriter_DiscussionMessage_Post extends XenForo_DataWriter_DiscussionMessage_Post {}
}