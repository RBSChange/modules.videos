<?php
/**
 * videos_BlockPlaylistAction
 * @package modules.videos
 */
class videos_BlockPlaylistAction extends videos_BlockVideoAction
{	
	/**
	 * @return videos_persistentdocument_playlist
	 */
	protected function getVideo()
	{
		$plist = $this->getDocumentParameter(change_Request::DOCUMENT_ID, 'videos_persistentdocument_playlist');
		if ($plist === null)
		{
			return website_BlockView::NONE;
		}
		
		if ($plist->getPosition() === 'none')
		{
			$videoArray = $plist->getPublishedVideoArray();
			$key = array_rand($videoArray);
			return $videoArray[$key];
		}
		return $plist;
	}
}