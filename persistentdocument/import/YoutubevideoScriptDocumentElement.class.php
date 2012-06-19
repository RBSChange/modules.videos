<?php
/**
 * videos_YoutubevideoScriptDocumentElement
 * @package modules.videos.persistentdocument.import
 */
class videos_YoutubevideoScriptDocumentElement extends import_ScriptDocumentElement
{
	/**
	 * @return videos_persistentdocument_youtubevideo
	 */
	protected function initPersistentDocument()
	{
		return videos_YoutubevideoService::getInstance()->getNewDocumentInstance();
	}
	
	/**
	 * @return f_persistentdocument_PersistentDocumentModel
	 */
	protected function getDocumentModel()
	{
		return f_persistentdocument_PersistentDocumentModel::getInstanceFromDocumentModelName('modules_videos/youtubevideo');
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