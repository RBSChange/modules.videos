<?php
/**
 * videos_BlockVideoAction
 * @package modules.videos
 */
class videos_BlockVideoAction extends website_BlockAction
{
	/**
	 * @param f_mvc_Request $request
	 * @param f_mvc_Response $response
	 * @return String
	 */
	public function execute($request, $response)
	{
		if ($this->isInBackofficeEdition())
		{
			$prefs = ModuleService::getInstance()->getPreferencesDocument('videos');
			$style['width'] = $this->getParameter('videoWidth', $prefs->getVideoWidth()) . "px";
			$style['height'] = $this->getParameter('videoHeight', $prefs->getVideoHeight()) . "px";
			$style['border'] = '1px dotted grey';
			$request->setAttribute('video', $this->getDocumentParameter());
			$request->setAttribute('style', f_util_HtmlUtils::buildStyleAttribute($style));
			return website_BlockView::DUMMY;
		}
		
		// This block will be used for the detail page of all types of videos, so forward to the appropriate block.
		$video = $this->getVideo();
		if ($video instanceof videos_persistentdocument_dailymotionvideo)
		{
			$this->forward('videos', 'Dailymotionvideo');
			return website_BlockView::NONE;
		}
		elseif ($video instanceof videos_persistentdocument_youtubevideo)
		{
			$this->forward('videos', 'Youtubevideo');
			return website_BlockView::NONE;
		}
		elseif ((!($video instanceof videos_persistentdocument_video) && !($video instanceof videos_persistentdocument_playlist)) || !$video->isPublished())
		{
			return website_BlockView::NONE;
		}
		$prefs = ModuleService::getInstance()->getPreferencesDocument('videos');
		
		$player = array();
		$player['getPlayerUrl'] = $prefs->getPlayerUrl();
		$player['getWidth'] = $this->getConfigurationParameter('videoWidth', $prefs->getVideoWidth());
		$player['getHeight'] = $this->getConfigurationParameter('videoHeight', $prefs->getVideoHeight());
		$player['getCleanBackColor'] = $prefs->getCleanBackColor();
		$player['getUsefullscreen'] = $this->getConfigurationParameter('usefullscreen', $prefs->getUsefullscreen());
		$player['getFlashvars'] = implode('&', $this->getFlashvars($this->getConfigurationParameters(), $prefs, $video));
		$request->setAttribute('video', $video);
		$request->setAttribute('player', $player);
		return website_BlockView::SUCCESS;
	}
	
	/**
	 * @param array $params
	 * @param videos_persistentdocument_preferences $prefs
	 * @param videos_persistentdocument_video $video
	 * @return array
	 */
	protected function getFlashvars($params, $prefs, $video)
	{
		return $video->getDocumentService()->getFlashvars($params, $prefs, $video);
	}
	
	/**
	 * @return f_persistentdocument_PersistentDocument
	 */
	protected function getVideo()
	{
		return $this->getDocumentParameter();
	}
}