<?php
/**
 * videos_PlaylistScriptDocumentElement
 * @package modules.videos.persistentdocument.import
 */
class videos_PlaylistScriptDocumentElement extends import_ScriptDocumentElement
{
    /**
     * @return videos_persistentdocument_playlist
     */
    protected function initPersistentDocument()
    {
    	return videos_PlaylistService::getInstance()->getNewDocumentInstance();
    }
    
    /**
	 * @return f_persistentdocument_PersistentDocumentModel
	 */
	protected function getDocumentModel()
	{
		return f_persistentdocument_PersistentDocumentModel::getInstanceFromDocumentModelName('modules_videos/playlist');
	}
}