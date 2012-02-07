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
    
    /**
     * @return f_persistentdocument_PersistentDocumentModel
     */
    protected function getDocumentModel()
    {
    	return f_persistentdocument_PersistentDocumentModel::getInstanceFromDocumentModelName('modules_videos/video');
    }
    
    public function endProcess()
    {
    	$document = $this->getPersistentDocument();
    	if ($document->getPublicationstatus() == 'DRAFT')
    	{
    		$document->activate();
    	}
    }
}