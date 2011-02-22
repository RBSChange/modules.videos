<?php
class videos_VideoService extends f_persistentdocument_DocumentService
{
	private static $instance = null;
	
	/**
	 * @return videos_VideoService
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
	 * @return videos_persistentdocument_video
	 */
	public function getNewDocumentInstance()
	{
		return $this->getNewDocumentInstanceByModelName("modules_videos/video");
	}
	
	/**
	 * @param videos_persistentdocument_video $document
	 * @param Integer $parentNodeId Parent node ID where to save the document (optionnal => can be null !).
	 * @return void
	 */
	protected function preSave($document, $parentNodeId)
	{
		$mediaService = media_MediaService::getInstance();
		$tmpMedia = $document->getFile();
		if ($tmpMedia instanceof media_persistentdocument_tmpfile)
		{
			$document->setFile(null);
			$document->setFile($mediaService->importFromTempFile($tmpMedia));
		}
		$this->updateMediaInfos($document, $document->getFile());
	}
	
	/**
	 * @param videos_persistentdocument_video $document
	 */
	protected function postDelete($document)
	{
		$file = $document->getFile();
		if (TreeService::getInstance()->getInstanceByDocument($file) === null)
		{
			$file->delete();
		}
	}
	
	/**
	 * Mise à jour des informations des medias attaché à la
	 *
	 * @param videos_persistentdocument_video $document
	 * @param media_persistentdocument_media $media
	 */
	private function updateMediaInfos($document, $media)
	{
		if ($media instanceof media_persistentdocument_media && $media->isContextLangAvailable())
		{
			$media->setLabel($document->getLabel());
			$media->setTitle($document->getLabel());
			$media->setDescription($document->getLabel());
			if ($media->isModified())
			{
				$media->save();
			}
		}
	}
	
	/**
	 * Returns an associative array of attributes to display in the backoffice
	 * preview panel.
	 *
	 * @param videos_persistentdocument_video $document
	 * @return array<string, string>
	 */
	public function getPreviewAttributes($document)
	{
		$preview = array();
		$preview['previewUrl'] = LinkHelper::getDocumentUrl($document, null, array('videosParam[preview]' => 'true'));
		return $preview;
	}

	/**
	 * @param f_persistentdocument_PersistentDocument $document
	 * @param string $forModuleName
	 * @param array $allowedSections
	 * @return array
	 */
	public function getResume($document, $forModuleName, $allowedSections)
	{
		$data = parent::getResume($document, $forModuleName, $allowedSections);
		$iframeUrl = LinkHelper::getUIActionLink('videos', 'DisplayVideoBo');
		$iframeUrl->setQueryParameter('cmpref', $document->getId());
		$iframeUrl->setQueryParameter('t', time());		
		$data['content']['iframeurl'] = $iframeUrl->getUrl();
		return $data;
	}
	
	/**
	 * @param videos_persistentdocument_video $document
	 * @param string $moduleName
	 * @param string $treeType
	 * @param array<string, string> $nodeAttributes
	 */
	public function addTreeAttributes($document, $moduleName, $treeType, &$nodeAttributes)
	{
		$nodeAttributes['filesize'] = $document->getFilesize();
	}
}