<?php

/**
 *
 * @see XenForo_ControllerPublic_RecentActivity
 */
class ThemeHouse_AnonymousPosts_Extend_XenForo_ControllerPublic_RecentActivity extends XFCP_ThemeHouse_AnonymousPosts_Extend_XenForo_ControllerPublic_RecentActivity
{

	/**
	 *
	 * @see XenForo_ControllerPublic_RecentActivity::actionIndex()
	 */
	public function actionIndex()
	{
		$response = parent::actionIndex();

		if ($response instanceof XenForo_ControllerResponse_View && !empty($response->params['newsFeed'])) {
			$threadIds = array();
			$postIds = array();
			$feedItems = $response->params['newsFeed'];

			foreach ($feedItems as $item) {
				if ($item['content_type'] == 'post') {
					$postIds[] = $item['content']['post_id'];
				} elseif ($item['content_type'] == 'thread') {
					$threadIds[] = $item['content']['thread_id'];
				}
			}
			if (!empty($threadIds)) {
				$threadIds = array_keys($this->_getThreadModel()->getAnonymousThreadIdsFromIds($threadIds));
				foreach ($feedItems as $key => $item) {
					if ($item['content_type'] == 'thread' && in_array($item['content']['thread_id'], $threadIds)) {
						unset($response->params['newsFeed'][$key]);
					}
				}
			}
			if (!empty($postIds)) {
				$postIds = array_keys($this->_getPostModel()->getAnonymousPostIdsFromIds($postIds));
				foreach ($feedItems as $key => $item) {
					if ($item['content_type'] == 'post' && in_array($item['content']['post_id'], $postIds)) {
						unset($response->params['newsFeed'][$key]);
					}
				}
			}
		}
		return $response;
	} /* END actionIndex */

	/**
	 *
	 * @return XenForo_Model_Thread
	 */
	protected function _getThreadModel()
	{
		return $this->getModelFromCache('XenForo_Model_Thread');
	} /* END _getThreadModel */

	/**
	 *
	 * @return XenForo_Model_Post
	 */
	protected function _getPostModel()
	{
		return $this->getModelFromCache('XenForo_Model_Post');
	} /* END _getPostModel */
}