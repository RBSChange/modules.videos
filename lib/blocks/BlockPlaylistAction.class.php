<?php
/**
 * videos_BlockPlaylistAction
 * @package modules.videos
 */
class videos_BlockPlaylistAction extends videos_BlockVideoAction
{
	public function getCacheKeyParameters($request)
	{
		$result = parent::getCacheKeyParameters($request);
		$plist = $this->getDocumentParameter(K::COMPONENT_ID_ACCESSOR, 'videos_persistentdocument_playlist');
		if ($plist !== null)
		{
			$result['position'] = $plist->getPosition;
		}
		return $result;
	}
	
	public function getCacheDependencies()
	{
		$deps = parent::getCacheDependencies();
		$deps[] = 'modules_video/playlist';
		return $deps;
	}
	
	/**
	 * @return videos_persistentdocument_playlist
	 */
	protected function getVideo()
	{
		$plist = $this->getDocumentParameter(K::COMPONENT_ID_ACCESSOR, 'videos_persistentdocument_playlist');
		if ($plist === null)
		{
			return null;
		}
		if ($plist->getPosition() === 'none')
		{
			$videoArray = $plist->getPublishedVideoArray();
			$key = array_rand($videoArray);
			return $videoArray[$key];
		}
		return $plist;
	}
	
	/**
	 * @param Array $params
	 * @param videos_persistentdocument_preferences $prefs
	 * @param videos_persistentdocument_video $video
	 */
	protected function getFlashvars($params, $prefs, $video)
	{
		$flashvars = parent::getFlashvars($params, $prefs, $video);
		if ($video instanceof videos_persistentdocument_playlist)
		{
			$flashvars['playlist'] = 'playlist=' . $video->getPosition();
		}
		return $flashvars;
	}
}