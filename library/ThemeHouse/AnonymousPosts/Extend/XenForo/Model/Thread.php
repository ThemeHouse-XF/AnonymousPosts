<?php

/**
 *
 * @see XenForo_Model_Thread
 */
class ThemeHouse_AnonymousPosts_Extend_XenForo_Model_Thread extends XFCP_ThemeHouse_AnonymousPosts_Extend_XenForo_Model_Thread
{

	// 0x01 reserved by ThemeHouse_CustomFields
	// 0x02 reserved by ThemeHouse_SocialGroups
	const FETCH_ANONYMOUS_POST = 0x04;
	// 0x08 reserved by ThemeHouse_ThreadEvents

	/**
	 *
	 * @see XenForo_Model_Thread::prepareThreadFetchOptions()
	 */
	public function prepareThreadFetchOptions(array $fetchOptions)
	{
		$threadFetchOptions = parent::prepareThreadFetchOptions($fetchOptions);

		$selectFields = $threadFetchOptions['selectFields'];
		$joinTables = $threadFetchOptions['joinTables'];

		if (isset($fetchOptions['th_join']) & self::FETCH_ANONYMOUS_POST) {
			$selectFields .= ',
					anonymous_post.anonymous_post';
			$joinTables .= '
					LEFT JOIN xf_post AS anonymous_post ON
						(anonymous_post.post_id = thread.last_post_id)';
		}

		return array(
			'selectFields' => $selectFields,
			'joinTables' => $joinTables,
			'orderClause' => $threadFetchOptions['orderClause']
		);
	} /* END prepareThreadFetchOptions */

	public function getAnonymousThreadIdsFromIds(array $threadIds)
	{
		return $this->fetchAllKeyed('
			SELECT thread.thread_id
			FROM xf_thread AS thread
			WHERE thread.thread_id IN (' . $this->_getDb()->quote($threadIds) . ')
			AND thread.anonymous_thread = 1
		', 'thread_id');
	} /* END getAnonymousThreadIdsFromIds */

	public function checkAnonymousThreadId($threadId)
	{
		return $this->_getDb()->fetchOne('
			SELECT thread.anonymous_thread
			FROM xf_thread AS thread
			WHERE thread.thread_id = ?
			AND thread.anonymous_thread = 1
		', $threadId);
	} /* END checkAnonymousThreadId */
}