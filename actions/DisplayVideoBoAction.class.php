<?php
/**
 * videos_DisplayVideoBoAction
 * @package modules.videos.actions
 */
class videos_DisplayVideoBoAction extends f_action_BaseAction 
{
	/**
	 * @param Context $context
	 * @param Request $request
	 */
	public function _execute($context, $request)
	{
		$video = $this->getDocumentInstanceFromRequest($request);
		$request->setParameter("video", $video);
		$prefs = ModuleService::getInstance()->getPreferencesDocument('videos');
		$player = array();
		$player['getPlayerUrl'] = $prefs->getPlayerUrl();
		$player['getWidth'] = 400;
		$player['getHeight'] = 300;
		$player['getCleanBackColor'] = $prefs->getCleanBackColor();
		$player['getUsefullscreen'] = false;
		$player['getFlashvars'] = '&file=' . $video->getFileUrl();		
		$request->setParameter("player", $player);
		return "Success";
	}
}