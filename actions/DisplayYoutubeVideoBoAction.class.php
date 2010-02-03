<?php
/**
 * videos_DisplayYoutubeVideoBoAction
 * @package modules.videos.actions
 */
class videos_DisplayYoutubeVideoBoAction extends f_action_BaseAction
{
	/**
	 * @param Context $context
	 * @param Request $request
	 */
	public function _execute($context, $request)
	{
		$request->setParameter("video", $this->getDocumentInstanceFromRequest($request));
		return 'Success';
	}
}