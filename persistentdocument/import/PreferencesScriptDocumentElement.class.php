<?php
/**
 * videos_PreferencesScriptDocumentElement
 * @package modules.videos.persistentdocument.import
 */
class videos_PreferencesScriptDocumentElement extends import_ScriptDocumentElement
{
	/**
	 * @return videos_persistentdocument_preferences
	 */
	protected function initPersistentDocument()
	{
		$document = ModuleService::getInstance()->getPreferencesDocument('videos');
		return ($document !== null) ? $document : videos_PreferencesService::getInstance()->getNewDocumentInstance();
	}
}