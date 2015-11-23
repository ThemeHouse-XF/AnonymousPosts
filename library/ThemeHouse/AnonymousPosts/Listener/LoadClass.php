<?php

class ThemeHouse_AnonymousPosts_Listener_LoadClass extends ThemeHouse_Listener_LoadClass
{

	protected function _getExtendedClasses()
	{
		return array(
			'ThemeHouse_AnonymousPosts' => array(
				'datawriter' => array(
					'XenForo_DataWriter_DiscussionMessage_Post',
					'XenForo_DataWriter_Discussion_Thread'
				), /* END 'datawriter' */
				'controller' => array(
					'XenForo_ControllerPublic_Member',
					'XenForo_ControllerPublic_Forum',
					'XenForo_ControllerPublic_Thread',
					'XenForo_ControllerPublic_Search',
					'XenForo_ControllerPublic_FindNew',
					'XenForo_ControllerPublic_Watched',
					'XenForo_ControllerPublic_RecentActivity'
				), /* END 'controller' */
				'model' => array(
					'XenForo_Model_Thread',
					'XenForo_Model_Post',
					'XenForo_Model_Forum',
				), /* END 'model' */
			), /* END 'ThemeHouse_AnonymousPosts' */
		);
	} /* END _getExtendedClasses */

	public static function loadClassDataWriter($class, array &$extend)
	{
		$loadClassDataWriter = new ThemeHouse_AnonymousPosts_Listener_LoadClass($class, $extend, 'datawriter');
		$extend = $loadClassDataWriter->run();
	} /* END loadClassDataWriter */

	public static function loadClassController($class, array &$extend)
	{
		$loadClassController = new ThemeHouse_AnonymousPosts_Listener_LoadClass($class, $extend, 'controller');
		$extend = $loadClassController->run();
	} /* END loadClassController */

	public static function loadClassModel($class, array &$extend)
	{
		$loadClassModel = new ThemeHouse_AnonymousPosts_Listener_LoadClass($class, $extend, 'model');
		$extend = $loadClassModel->run();
	} /* END loadClassModel */
}