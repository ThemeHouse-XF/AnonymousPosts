<?php

/**
 *
 * @see XenForo_ControllerPublic_Forum
 */
class ThemeHouse_AnonymousPosts_Extend_XenForo_ControllerPublic_Forum extends XFCP_ThemeHouse_AnonymousPosts_Extend_XenForo_ControllerPublic_Forum
{

	/**
	 *
	 * @see XenForo_ControllerPublic_Forum::actionIndex()
	 */
	public function actionIndex()
	{
		$response = parent::actionIndex();
		if ($response instanceof XenForo_ControllerResponse_View && isset($response->params['nodeList']['nodesGrouped'])) {
			$response->params['anonymousUser'] = array(
				'user_id' => '0'
			);
			$groupedNodes = $response->params['nodeList']['nodesGrouped'];

			$postIds = array();
			foreach ($groupedNodes as $primaryKey => $node) {
				foreach ($node as $secondaryKey => $forum) {
					if (isset($forum['lastPost']['post_id'])) {
						$postIds[] = $forum['lastPost']['post_id'];
					}
				}
			}
			if (!empty($postIds)) {
				$postIds = $postIds = array_keys($this->_getPostModel()->getAnonymousPostIdsFromIds($postIds));
				if (!empty($postIds)) {
					foreach ($groupedNodes as $primaryKey => $node) {
						foreach ($node as $secondaryKey => $forum) {
							if (isset($forum['lastPost']['post_id']) && in_array($forum['lastPost']['post_id'], $postIds)) {
								$response->params['nodeList']['nodesGrouped'][$primaryKey][$secondaryKey]['lastPost']['anonymous_post'] = 1;
							}
						}
					}
				}
			}

		}
		return $response;
	} /* END actionIndex */

	/**
	 *
	 * @see XenForo_ControllerPublic_Forum::actionForum()
	 */
	public function actionForum()
	{
		$response = parent::actionForum();
		$response->params['anonymousUser'] = array(
			'user_id' => '0'
		);
		if ($response instanceof XenForo_ControllerResponse_View && isset($response->params['nodeList']['nodesGrouped'])) {
			$groupedNodes = $response->params['nodeList']['nodesGrouped'];

			$postIds = array();
			foreach ($groupedNodes as $primaryKey => $node) {
				foreach ($node as $secondaryKey => $forum) {
					if (isset($forum['lastPost']['post_id'])) {
						$postIds[] = $forum['lastPost']['post_id'];
					}
				}
			}
			if (!empty($postIds)) {
				$postIds = $postIds = array_keys($this->_getPostModel()->getAnonymousPostIdsFromIds($postIds));
				if (!empty($postIds)) {
					foreach ($groupedNodes as $primaryKey => $node) {
						foreach ($node as $secondaryKey => $forum) {
							if (in_array($forum['lastPost']['post_id'], $postIds)) {
								$response->params['nodeList']['nodesGrouped'][$primaryKey][$secondaryKey]['lastPost']['anonymous_post'] = 1;
							}
						}
					}
				}
			}
		}
		return $response;
	} /* END actionForum */

	/**
	 *
	 * @see XenForo_ControllerPublic_Forum::_getThreadFetchElements()
	 */
	protected function _getThreadFetchElements(array $forum, array $displayConditions)
	{
		$threadFetchElements = parent::_getThreadFetchElements($forum, $displayConditions);

		if (!isset($threadFetchElements['options']['th_join'])) {
			$threadFetchElements['options']['th_join'] = 0;
		}

		$threadFetchElements['options']['th_join'] |= ThemeHouse_AnonymousPosts_Extend_XenForo_Model_Thread::FETCH_ANONYMOUS_POST;
		return $threadFetchElements;
	} /* END _getThreadFetchElements */

	public function actionCreateThread()
	{
		$visitor = XenForo_Visitor::getInstance();
		$response = parent::actionCreateThread();
		if ($response instanceof XenForo_ControllerResponse_View) {
			$forum = $response->params['forum'];

			$response->params['canPostAnonymousThread'] = $this->_getForumModel()->canPostAnonymousThreadInForum($forum);
		}

		return $response;
	}

	/**
	 *
	 * @see XenForo_ControllerPublic_Forum::actionAddThread()
	 */
	public function actionAddThread()
	{
		$GLOBALS['XenForo_ControllerPublic_Forum'] = $this;
		return parent::actionAddThread();
	} /* END actionAddThread */

	/**
	 *
	 * @return XenForo_Model_Post
	 */
	protected function _getPostModel()
	{
		return $this->getModelFromCache('XenForo_Model_Post');
	} /* END _getPostModel */
}

if (false) {
	class XFCP_ThemeHouse_AnonymousPosts_Extend_XenForo_ControllerPublic_Forum extends XenForo_ControllerPublic_Forum {}
}