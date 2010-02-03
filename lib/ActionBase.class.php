<?php
class videos_ActionBase extends f_action_BaseAction
{
	
	/**
	 * Returns the videos_PreferencesService to handle documents of type "modules_videos/preferences".
	 *
	 * @return videos_PreferencesService
	 */
	public function getPreferencesService()
	{
		return videos_PreferencesService::getInstance();
	}
	
	/**
	 * Returns the videos_VideoService to handle documents of type "modules_videos/video".
	 *
	 * @return videos_VideoService
	 */
	public function getVideoService()
	{
		return videos_VideoService::getInstance();
	}
	
}