<?php

/**
 *
 * @see XenForo_ControllerPublic_Search
 */
class ThemeHouse_AnonymousPosts_Extend_XenForo_ControllerPublic_Search extends XFCP_ThemeHouse_AnonymousPosts_Extend_XenForo_ControllerPublic_Search
{

	/**
	 * @see XenForo_ControllerPublic_Search::actionResults()
	 */
	public function actionResults()
	{
		$response = parent::actionResults();

		//TODO - add in check for Controller_Member or search_type = member or includes username search
		//, if true remove search anonymous items.
		//TODO - write method to tag anonymous results instead of removing them

		if ($response instanceof XenForo_ControllerResponse_View) {
			if (isset($response->params['results']['results'])) {
				$results = $response->params['results']['results'];
				if (is_array($results)) {
					foreach ($results as $key => $result) {
						if ($result['0'] == 'post' && $result['content']['anonymous_post']) {
							unset($response->params['results']['results'][$key]);
						}
						if ($result['0'] == 'thread' && $result['content']['anonymous_thread']) {
							unset($response->params['results']['results'][$key]);
						}
					}
				}
			}
			//TODO -
			//If first page of results is emptied return no results response
			//Note that this can be improved in future by changing search model...
			if (empty($response->params['results']['results'])) {
				return $this->getNoSearchResultsResponse($response->params['search']);
			}
		}
		return $response;
	} /* END actionResults */
}