<?php

/**
 *
 * @see XenForo_Model_Post
 */
class ThemeHouse_AnonymousPosts_Extend_XenForo_Model_Post extends XFCP_ThemeHouse_AnonymousPosts_Extend_XenForo_Model_Post
{
	public function getAnonymousPostIdsFromIds(array $postIds)
	{
		return $this->fetchAllKeyed('
			SELECT post.post_id
			FROM xf_post AS post
			WHERE post.post_id IN (' . $this->_getDb()->quote($postIds) . ')
			AND post.anonymous_post = 1
		', 'post_id');
	} /* END getAnonymousPostIdsFromIds */

	public function checkAnonymousPostByPostId($postId)
	{
		return $this->_getDb()->fetchOne('
			SELECT post.anonymous_post
			FROM xf_post AS post
			WHERE post.post_id = ?
			', $postId);
	} /* END checkAnonymousPostByPostId */

	protected function _getQuoteWrapperBbCode(array $post, $message)
	{
		if ($post['anonymous_post']) {
			$post['user_id'] = 0;
			$post['username'] = new XenForo_Phrase('th_anonymous_anonymousposts');
		}

		return parent::_getQuoteWrapperBbCode($post, $message);
	}
}

if (false) {
	class XFCP_ThemeHouse_AnonymousPosts_Extend_XenForo_Model_Post extends XenForo_Model_Post {}
}