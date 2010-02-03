<?php
/**
 * videos_persistentdocument_playlist
 * @package videos
 */
class videos_persistentdocument_playlist extends videos_persistentdocument_playlistbase 
{
	/**
	 * @return String
	 */
	public function getFileUrl()
	{
		return LinkHelper::getActionUrl('videos', 'Playlist', array(K::COMPONENT_ID_ACCESSOR => $this->getId()));
	}   
}