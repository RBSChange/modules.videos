<?php
/**
 * videos_BlockVideoAction
 * @package modules.videos
 */
class videos_BlockVideoAction extends website_BlockAction
{
	/**
	 * @return array<String, String> couples of (parameter name / value) that are used by the block
	 */
	public function getCacheKeyParameters($request)
	{
		$keys = array('params' => $this->getConfigurationParameters());
		$keys['cmpref'] = $this->getDocumentIdParameter();
		$keys['lang'] = $this->getLang();
		$keys['pageId'] = $this->getPage()->getId();
		return $keys;
	}
	
	/**
	 * @return array<String>
	 */
	public function getCacheDependencies()
	{
		return array('modules_videos/video', 'module_media/media', 'modules_videos/preferences');
	}
	
	protected function getVideo()
	{
		return $this->getDocumentParameter(K::COMPONENT_ID_ACCESSOR, 'videos_persistentdocument_video');
	}
	
	/**
	 * @see website_BlockAction::execute()
	 *
	 * @param f_mvc_Request $request
	 * @param f_mvc_Response $response
	 * @return String
	 */
	function execute($request, $response)
	{
		if ($this->isInBackoffice())
		{
			$prefs = ModuleService::getInstance()->getPreferencesDocument('videos');
			$style['width'] = $this->getParameter('videoWidth', $prefs->getVideoWidth()) . "px";
			$style['height'] = $this->getParameter('videoHeight', $prefs->getVideoHeight()) . "px";
			$style['border'] = '1px dotted grey';
			$request->setAttribute('video', $this->getDocumentParameter(K::COMPONENT_ID_ACCESSOR, 'videos_persistentdocument_video'));
			$request->setAttribute('style', f_util_HtmlUtils::buildStyleAttribute($style));
			return website_BlockView::DUMMY;
		}
		
		$video = $this->getVideo();
		
		if ($video === null || !$video->isPublished())
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
}