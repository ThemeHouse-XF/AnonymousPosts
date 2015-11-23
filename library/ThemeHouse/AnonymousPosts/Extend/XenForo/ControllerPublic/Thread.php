<?php

/**
 *
 * @see XenForo_ControllerPublic_Thread
 */
class ThemeHouse_AnonymousPosts_Extend_XenForo_ControllerPublic_Thread extends XFCP_ThemeHouse_AnonymousPosts_Extend_XenForo_ControllerPublic_Thread
{

	/**
	 *
	 * @see XenForo_ControllerPublic_Thread::actionIndex()
	 */
	public function actionIndex()
	{
		$response = parent::actionIndex();
		if ($response instanceof XenForo_ControllerResponse_View) {
			$response->params['anonymousUser'] = array(
				'user_id' => '0',
				'username' => new XenForo_Phrase('th_anonymous_anonymousposts')
			);

			$visitor = XenForo_Visitor::getInstance();
			$response->params['canSeeAnonymousPostAuthor'] = $visitor->hasPermission('general', 'seeAnonymousPostAuthor');
		}
		return $response;
	} /* END actionIndex */

	/**
	 *
	 * @see XenForo_ControllerPublic_Thread::actionAddReply()
	 */
	public function actionAddReply()
	{
		$GLOBALS['XenForo_ControllerPublic_Thread'] = $this;
		return parent::actionAddReply();
	} /* END actionAddReply */

	public function actionReply()
	{
		$visitor = XenForo_Visitor::getInstance();
		$response = parent::actionReply();
		if ($response instanceof XenForo_ControllerResponse_View) {
			$forum = $response->params['forum'];

			$response->params['canPostAnonymousReply'] = $this->_getForumModel()->canPostAnonymousReplyInForum($forum);
		}

		return $response;
	}

	/**
	 * Updates an existing thread.
	 * Adds anonymous thread check.
	 *
	 * @see XenForo_ControllerPublic_Thread::actionSave()
	 */
	public function actionSave()
	{
		$GLOBALS['XenForo_ControllerPublic_Forum'] = $this;
		return parent::actionSave();
	} /* END actionSave */

	protected function _getNewPosts(array $thread, array $forum, $lastDate, $limit = 3)
	{
		$params = parent::_getNewPosts($thread, $forum, $lastDate, $limit);
		$params['anonymousUser'] = array(
			'user_id'	=> '0',
			'username'	=> new XenForo_Phrase('th_anonymous_anonymousposts'),
			'signature'	=> '',
		);
		return $params;
	} /* END _getNewPosts */
}