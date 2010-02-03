<?php
/**
 * videos_persistentdocument_youtubevideo
 * @package modules.videos
 */
class videos_persistentdocument_youtubevideo extends videos_persistentdocument_youtubevideobase
{
	/**
	 * @return String
	 */
	public function getUrl()
	{
		return 'http://www.youtube.com/v/' . $this->getVideoId();
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
		$prefs = ModuleService::getInstance()->getPreferencesDocument('videos');
		return $this->getUrl() . '&color1=' .  $prefs->getCleanColor1(). '&color2=' . $prefs->getCleanColor2() . '&fs=true' /*. $prefs->getFs() */. '&border=' . $prefs->getBorder() . ';&autoplay=' . $prefs->getYoutubeAutoPlay();
	}
}