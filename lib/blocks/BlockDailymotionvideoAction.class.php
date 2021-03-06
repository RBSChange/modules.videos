<?php
/**
 * videos_BlockDailymotionvideoAction
 * @package modules.videos
 */
class videos_BlockDailymotionvideoAction extends website_BlockAction
{
	
	/**
	 * @see website_BlockAction::execute()
	 *
	 * @param f_mvc_Request $request
	 * @param f_mvc_Response $response
	 * @return String
	 */
	function execute($request, $response)
	{
		if ($this->isInBackofficeEdition())
		{
			return website_BlockView::DUMMY;
		}
		$video = $this->getDocumentParameter(K::COMPONENT_ID_ACCESSOR, "videos_persistentdocument_dailymotionvideo");
		if ($video === null || !$video->isPublished())
		{
			return website_BlockView::NONE;
		}
		
		$prefs = ModuleService::getInstance()->getPreferencesDocument('videos');
		
		$dailyVideo = array();
		$dailyVideo['getUrl'] = $video->getUrl() . '&background=' . $prefs->getBackgroundForDailymotion() . '&highlight=' . $prefs->getHighlightForDailymotion() . '&foreground=' . $prefs->getForegroundForDailymotion() . '&autoPlay=' . $prefs->getDailyAutoPlay();
		$dailyVideo['getLabel'] = $video->getLabel();
		$dailyVideo['getWidth'] = $prefs->getDailyWidth();
		$dailyVideo['getHeight'] = $prefs->getDailyHeight();
		$request->setAttribute('video', $dailyVideo);
		return website_BlockView::SUCCESS;
	}
}