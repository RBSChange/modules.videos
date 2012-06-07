<?php
/**
 * videos_BlockYoutubevideoAction
 * @package modules.videos
 */
class videos_BlockYoutubevideoAction extends website_BlockAction
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
		$video = $this->getDocumentParameter(change_Request::DOCUMENT_ID, "videos_persistentdocument_youtubevideo");
		if ($video === null || !$video->isPublished())
		{
			return website_BlockView::NONE;
		}
		$prefs = ModuleService::getInstance()->getPreferencesDocument('videos');
		$youtubeVideo = array();
		$youtubeVideo['getUrl'] = $video->getUrl() . '&color1=' . $prefs->getCleanColor1() . '&color2=' . $prefs->getCleanColor2() . '&fs=' . $prefs->getFs() . '&border=' . $prefs->getBorder() . ';&autoplay=' . $prefs->getYoutubeAutoPlay();
		$youtubeVideo['getLabel'] = $video->getLabel();
		$youtubeVideo['getWidth'] = $prefs->getYoutubeWidth();
		$youtubeVideo['getHeight'] = $prefs->getYoutubeHeight();
		$request->setAttribute('video', $youtubeVideo);
		return website_BlockView::SUCCESS;
	}

}