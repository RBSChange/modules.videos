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

	/**
	 * @param videos_persistentdocument_preferences $document
	 * @param integer $parentNodeId Parent node ID where to save the document (optionnal => can be null !).
	 * @return void
	 */
	protected function preSave($document, $parentNodeId)
	{
		$document->setLabel('&modules.videos.bo.general.Module-name;');	
	}
}