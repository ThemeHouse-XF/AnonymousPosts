<?php

/**
 *
 * @see XenForo_ControllerPublic_Member
 */
class ThemeHouse_AnonymousPosts_Extend_XenForo_ControllerPublic_Member extends XFCP_ThemeHouse_AnonymousPosts_Extend_XenForo_ControllerPublic_Member
{


	/**
	 * Redirect anonymous posts user links and guests to a modified error message
	 *
	 * @see XenForo_ControllerPublic_Member::actionIndex()
	 */
	/*public function actionIndex()
	{
		$userId = $this->_input->filterSingle('user_id', XenForo_Input::UINT);
		if ($userId)
		{
			return $this->responseReroute(__CLASS__, 'member');
		}
		else if ($this->_input->inRequest('user_id'))
		{
			return $this->responseError(new XenForo_Phrase('th_posted_by_guest_or_anonymous_anonymousposts'));
		}
		return parent::actionIndex();
	} /* END actionIndex */
	/**
	 * Filters out posts and threads as required
	 *
	 * @see XenForo_ControllerPublic_Member::actionRecentContent()
	 */
	public function actionRecentContent()
	{
		$response = parent::actionRecentContent();

		if ($response instanceof XenForo_ControllerResponse_View) {
			$results = $response->params['results']['results'];
			foreach ($results as $key => $result) {
				if ($result['0'] == 'post' && $result['content']['anonymous_post']) {
					unset($response->params['results']['results'][$key]);
				}
				if ($result['0'] == 'thread' && $result['content']['anonymous_thread']) {
					unset($response->params['results']['results'][$key]);
				}
			}
		}

		return $response;
	} /* END actionRecentContent */

	/**
	 * Filters out posts and threads as required
	 *
	 * @see XenForo_ControllerPublic_Member::actionRecentActivity()
	 */
	public function actionRecentActivity()
	{
		$response = parent::actionRecentActivity();

		if ($response instanceof XenForo_ControllerResponse_View && isset($response->params['newsFeed'])) {
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
	} /* END actionRecentActivity */

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