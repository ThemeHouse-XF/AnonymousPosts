<?php

class ThemeHouse_AnonymousPosts_Install_Controller extends ThemeHouse_Install
{
	protected $_resourceManagerUrl = 'http://xenforo.com/community/resources/anonymous-posts-and-threads.2868/';

	protected $_minVersionId = 1020000;

	/**
	 * @see ThemeHouse_Install::_getTableChanges()
	 */
	protected function _getTableChanges()
	{
		return array(
			'xf_post' => array(
				'anonymous_post' => 'BOOLEAN NOT NULL DEFAULT 0', /* 'anonymous_post' */
			), /* END 'xf_post' */
			'xf_thread' => array(
				'anonymous_thread'		=> 'BOOLEAN NOT NULL DEFAULT 0', /* 'anonymous_thread' */
				'last_post_anonymous'	=> 'BOOLEAN NOT NULL DEFAULT 0', /* 'last_post_anonymous' */
			), /* END 'xf_thread' */
		);
	} /* END _getTableChanges */
}
