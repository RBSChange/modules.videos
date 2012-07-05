<?php
/**
 * @package modules.videos
 * @method videos_PreferencesService getInstance() 
 */
class videos_PreferencesService extends f_persistentdocument_DocumentService
{
	/**
	 * @return videos_persistentdocument_preferences
	 */
	public function getNewDocumentInstance()
	{
		return $this->getNewDocumentInstanceByModelName('modules_videos/preferences');
	}
}