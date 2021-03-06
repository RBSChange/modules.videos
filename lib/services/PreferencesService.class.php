<?php
/**
 * @date Fri, 22 Jun 2007 17:40:42 +0200
 * @author intportg
 */
class videos_PreferencesService extends f_persistentdocument_DocumentService
{
	private static $instance = null;

	/**
	 * @return videos_PreferencesService
	 */
	public static function getInstance()
	{
		if (is_null(self::$instance))
		{
			$className = get_class();
			self::$instance = new $className();
		}
		return self::$instance;
	}

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

	/**
	 * @param videos_persistentdocument_preferences $document
	 * @param Integer $parentNodeId Parent node ID where to save the document (optionnal => can be null !).
	 * @return void
	 */
	protected function preSave($document, $parentNodeId)
	{
		$document->setLabel('&modules.videos.bo.general.Module-name;');	
	}
}