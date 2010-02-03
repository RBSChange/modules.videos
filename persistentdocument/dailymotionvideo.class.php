<?php
/**
 * videos_persistentdocument_dailymotionvideo
 * @package modules.videos
 */
class videos_persistentdocument_dailymotionvideo extends videos_persistentdocument_dailymotionvideobase 
{
	/**
	 * @return String
	 */
	public function getUrl()
	{
		return 'http://www.dailymotion.com/swf/' . $this->getVideoId();
	}
	
	public function getWidth()
	{
		return ModuleService::getInstance()->getPreferenceValue('videos', 'youtubeWidth');
	}
	
	public function getHeight()
	{
		return ModuleService::getInstance()->getPreferenceValue('videos', 'youtubeHeight');
	}
	
	public function getCompleteUrl()
	{	
		return $this->getUrl();
	}
}