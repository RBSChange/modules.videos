<?php
/**
 * videos_DisplayVideoBoAction
 * @package modules.videos.actions
 */
class videos_DisplayVideoBoAction extends change_Action 
{
	/**
	 * @param change_Context $context
	 * @param change_Request $request
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