<?php
/**
 * videos_DailymotionvideoScriptDocumentElement
 * @package modules.videos.persistentdocument.import
 */
class videos_DailymotionvideoScriptDocumentElement extends import_ScriptDocumentElement
{
	/**
	 * @return videos_persistentdocument_dailymotionvideo
	 */
	protected function initPersistentDocument()
	{
		return videos_DailymotionvideoService::getInstance()->getNewDocumentInstance();
	}
	
	/**
	 * @return f_persistentdocument_PersistentDocumentModel
	 */
	protected function getDocumentModel()
	{
		return f_persistentdocument_PersistentDocumentModel::getInstanceFromDocumentModelName('modules_videos/dailymotionvideo');
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