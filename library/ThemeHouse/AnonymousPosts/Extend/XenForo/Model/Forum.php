<?php
class ThemeHouse_AnonymousPosts_Extend_XenForo_Model_Forum extends XFCP_ThemeHouse_AnonymousPosts_Extend_XenForo_Model_Forum
{
	/**
	 * Determines if a new anonymous thread can be posted in the specified forum,
	 * with the given permissions. If no permissions are specified, permissions
	 * are retrieved from the currently visiting user. This does not check viewing permissions.
	 *
	 * @param array $forum Info about the forum posting in
	 * @param string $errorPhraseKey Returned phrase key for a specific error
	 * @param array|null $nodePermissions
	 * @param array|null $viewingUser
	 *
	 * @return boolean
	 */
	public function canPostAnonymousThreadInForum(array $forum, &$errorPhraseKey = '', array $nodePermissions = null, array $viewingUser = null)
	{
		$this->standardizeViewingUserReferenceForNode($forum['node_id'], $viewingUser, $nodePermissions);

		return XenForo_Permission::hasContentPermission($nodePermissions, 'postAnonymousThread');
	}

	/**
	 * Determines if a new anonymous reply can be posted in the specified forum,
	 * with the given permissions. If no permissions are specified, permissions
	 * are retrieved from the currently visiting user. This does not check viewing permissions.
	 *
	 * @param array $forum Info about the forum posting in
	 * @param string $errorPhraseKey Returned phrase key for a specific error
	 * @param array|null $nodePermissions
	 * @param array|null $viewingUser
	 *
	 * @return boolean
	 */
	public function canPostAnonymousReplyInForum(array $forum, &$errorPhraseKey = '', array $nodePermissions = null, array $viewingUser = null)
	{
		$this->standardizeViewingUserReferenceForNode($forum['node_id'], $viewingUser, $nodePermissions);

		return XenForo_Permission::hasContentPermission($nodePermissions, 'postAnonymousReply');
	}
}

if (false) {
	class XFCP_ThemeHouse_AnonymousPosts_Extend_XenForo_Model_Forum extends XenForo_Model_Forum {}
}