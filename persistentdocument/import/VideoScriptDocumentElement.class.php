<?php
/**
 * videos_VideoScriptDocumentElement
 * @package modules.videos.persistentdocument.import
 */
class videos_VideoScriptDocumentElement extends import_ScriptDocumentElement
{
    /**
     * @return videos_persistentdocument_video
     */
    protected function initPersistentDocument()
    {
    	return videos_VideoService::getInstance()->getNewDocumentInstance();
    }
}