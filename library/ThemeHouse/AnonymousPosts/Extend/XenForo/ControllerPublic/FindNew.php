<?php

/**
 *
 * @see XenForo_ControllerPublic_FindNew
 */
class ThemeHouse_AnonymousPosts_Extend_XenForo_ControllerPublic_FindNew extends XFCP_ThemeHouse_AnonymousPosts_Extend_XenForo_ControllerPublic_FindNew
{

	/**
	 *
	 * @see XenForo_ControllerPublic_FindNew::actionPosts()
	 */
	public function actionPosts()
	{
		$response = parent::actionPosts();

		if ($response instanceof XenForo_ControllerResponse_View && isset($response->subView->params['threads'])) {
			$threads = $response->subView->params['threads'];
			$postIds = array();
			foreach ($threads as $key => $thread) {
			   $postIds[] = $thread['last_post_id'];
			}
			$anonymousPostIds = array_keys($this->_getPostModel()->getAnonymousPostIdsFromIds($postIds));
			if (!empty($anonymousPostIds)) {
				foreach ($threads as $key => $thread) {
					if (in_array($thread['last_post_id'], $anonymousPostIds)) {
						$response->subView->params['threads'][$key]['anonymous_post'] = 1;
					}
				}
				$response->subView->params['anonymousUser'] = array('user_id' => '0');
			}
		}

		return $response;
	} /* END actionPosts */

	/**
	 *
	 * @return XenForo_Model_Post
	 */
	protected function _getPostModel()
	{
		return $this->getModelFromCache('XenForo_Model_Post');
	} /* END _getPostModel */
}