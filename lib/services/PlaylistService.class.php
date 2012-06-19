<?php
/**
 * @package modules.videos
 * @method videos_PlaylistService getInstance() 
 */
class videos_PlaylistService extends f_persistentdocument_DocumentService
{
	/**
	 * @return videos_persistentdocument_playlist
	 */
	public function getNewDocumentInstance()
	{
		return $this->getNewDocumentInstanceByModelName('modules_videos/playlist');
	}

	/**
	 * Create a query based on 'modules_videos/playlist' model
	 * @return f_persistentdocument_criteria_Query
	 */
	public function createQuery()
	{
		return $this->pp->createQuery('modules_videos/playlist');
	}
	
	/**
	 * @param array $params
	 * @param videos_persistentdocument_preferences $prefs
	 * @param videos_persistentdocument_video $video
	 * @return array
	 */
	public function getFlashvars($params, $prefs, $video)
	{
		$flashvars = videos_VideoService::getInstance()->getFlashvars($params, $prefs, $video);
		$flashvars['playlist'] = 'playlist=' . $video->getPosition();
		return $flashvars;
	}
}