<?php

/**
 *
 * @see XenForo_ControllerPublic_Watched
 */
class ThemeHouse_AnonymousPosts_Extend_XenForo_ControllerPublic_Watched extends XFCP_ThemeHouse_AnonymousPosts_Extend_XenForo_ControllerPublic_Watched
{

	/**
	 *
	 * @see XenForo_ControllerPublic_Watched::actionForums()
	 */
	public function actionForums()
	{
		$response = parent::actionForums();

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
							if (isset($forum['lastPost']['post_id']) && in_array($forum['lastPost']['post_id'], $postIds)) {
								$response->params['nodeList']['nodesGrouped'][$primaryKey][$secondaryKey]['lastPost']['anonymous_post'] = 1;
							}
						}
					}
					$response->params['anonymousUser'] = array(
						'user_id' => '0'
					);
				}
			}
		}
		return $response;
	} /* END actionForums */

	/**
	 *
	 * @see XenForo_ControllerPublic_Watched::actionForums()
	 */
	public function actionThreads()
	{
		$response = parent::actionThreads();
		if ($response instanceof XenForo_ControllerResponse_View) {
			$response->params['anonymousUser'] = array(
				'user_id' => '0',
				'username' => new XenForo_Phrase('th_anonymous_anonymousposts')
			);
		}
		return $response;
	} /* END actionThreads */

	/**
	 *
	 * @see XenForo_ControllerPublic_Watched::_prepareWatchedThreads()
	 */
	protected function _prepareWatchedThreads(array $threads)
	{
		$threads = parent::_prepareWatchedThreads($threads);

		if (empty($threads)) {
			return array();
		}
		$postIds = array();
		foreach ($threads as $key => $thread) {
			$postIds[] = $thread['last_post_id'];
		}
		$anonymousPostIds = array_keys($this->_getPostModel()->getAnonymousPostIdsFromIds($postIds));
		if (!empty($anonymousPostIds)) {
			foreach ($threads as $key => $thread) {
				if (in_array($thread['last_post_id'], $anonymousPostIds)) {
					$threads[$key]['anonymous_post'] = 1;
				}
			}
		}
		return $threads;
	} /* END _prepareWatchedThreads */

	/**
	 *
	 * @return XenForo_Model_Post
	 */
	protected function _getPostModel()
	{
		return $this->getModelFromCache('XenForo_Model_Post');
	} /* END _getPostModel */
}