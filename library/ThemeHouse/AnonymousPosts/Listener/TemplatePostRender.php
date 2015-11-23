<?php

class ThemeHouse_AnonymousPosts_Listener_TemplatePostRender extends ThemeHouse_Listener_TemplatePostRender
{

	protected function _getTemplates()
	{
		return array(
			'forum_view',
			'thread_view'
		);
	} /* END _getTemplates */

	public static function templatePostRender($templateName, &$content, array &$containerData, XenForo_Template_Abstract $template)
	{
		$templatePostRender = new ThemeHouse_AnonymousPosts_Listener_TemplatePostRender($templateName, $content, $containerData, $template);
		list($content, $containerData) = $templatePostRender->run();
	} /* END templatePostRender */

	protected function _forumView()
	{
		$pattern = '#(<span class="avatarContainer">\s*<a href=")(.*)(".*forcetype="default".*alt=")(.*)(")#Us';
		$replacement = new XenForo_Phrase('th_anonymous_anonymousposts');
		//$this->_contents = preg_replace($pattern, '$1$3' . $replacement . '$5', $this->_contents);
	} /* END _forumView */

	protected function _threadView()
	{
		$pattern = '#(<div class="avatarHolder">.*<a href=")(.*)(".*forcetype="default".*alt=")(.*)(")#Us';
		$replacement = new XenForo_Phrase('th_anonymous_anonymousposts');
		//$this->_contents = preg_replace($pattern, '$1$3' . $replacement . '$5', $this->_contents);
	} /* END _threadView */
}