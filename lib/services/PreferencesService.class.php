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
	 * @return videos_persistentdocument_preferences
	 */
	public function getNewDocumentInstance()
	{
		return parent::getNewDocumentInstance('modules_videos/preferences');
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