<?php
/**
 * @package modules.videos
 * @method videos_PreferencesService getInstance() 
 */
class videos_PreferencesService extends f_persistentdocument_DocumentService
{
	/**
	 * Create a query based on 'modules_videos/playlist' model
	 * @return f_persistentdocument_criteria_Query
	 */
	public function createQuery()
	{
		return $this->getPersistentProvider()->createQuery('modules_videos/preferences');
	}
	
	/**
	 * @return videos_persistentdocument_preferences
	 */
	public function getNewDocumentInstance()
	{
		return $this->getNewDocumentInstanceByModelName('modules_videos/preferences');
	}
}