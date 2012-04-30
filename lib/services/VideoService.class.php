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
	 * Create a query based on 'modules_videos/video' model
	 * @return f_persistentdocument_criteria_Query
	 */
	public function createQuery()
	{
		return $this->pp->createQuery('modules_videos/video');
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
	public function getResume($document, $forModuleName, $allowedSections = null)
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
		
		$lang = RequestContext::getInstance()->getLang();
		$title = $document->getLabelAsHtml();
		$ms = ModuleService::getInstance();
		$styleAttributes = array(
			'width' => $ms->getPreferenceValue('videos', 'videoWidth') . 'px',
			'height' => $ms->getPreferenceValue('videos', 'videoHeight') . 'px',
			'background-image' => 'url(' . MediaHelper::getIcon('video', 'small') . ')'
		);
		$style = f_util_HtmlUtils::buildStyleAttribute($styleAttributes);
		$nodeAttributes['htmllink'] = '<a rel="cmpref:' . $document->getId() . '" title="' . $title . '" href="#" lang="' . $lang . '" class="document-dummy" style="' . $style . '">' . $title . '</a>';
		
	}
	
	/**
	 * @param videos_persistentdocument_youtubevideo $document
	 * @param array $attributes
	 * @param string $content
	 * @param string $lang
	 * @return string
	 */
	public function getXhtmlFragment($document, $attributes, $content, $lang)
	{
		$prefs = ModuleService::getInstance()->getPreferencesDocument('videos');
		
		$video['getId'] = $document->getId();
		
		$player['getPlayerUrl'] = $prefs->getPlayerUrl();
		$player['getWidth'] = $prefs->getVideoWidth();
		$player['getHeight'] = $prefs->getVideoHeight();
		$player['getCleanBackColor'] = $prefs->getCleanBackColor();
		$player['getUsefullscreen'] = $prefs->getUsefullscreen();
		$player['getFlashvars'] = implode('&', $this->getFlashvars(null, $prefs, $document));
		
		$templateComponent = TemplateLoader::getInstance()->setpackagename('modules_videos')->setMimeContentType(K::HTML)->load('Videos-Block-Video-Success');
		$templateComponent->setAttribute('video', $video);
		$templateComponent->setAttribute('player', $player);
		$content = $templateComponent->execute();
		return $content;
	}
	
	/**
	 * @param array $params
	 * @param videos_persistentdocument_preferences $prefs
	 * @param videos_persistentdocument_video $video
	 * @return array
	 */
	public function getFlashvars($params, $prefs, $video)
	{
		$flashvars = array();
		
		$properties = array('videoWidth', 'videoHeight', 'image', 'backcolor', 'frontcolor', 'lightcolor', 'screencolor', 'logo', 'icons', 'controlbar', 'usefullscreen', 'autostart', 'repeat');
		$propNameToFlashName = array('videoWidth' => 'width', 'videoHeight' => 'height');
		foreach ($properties as $propertyName)
		{
			if (isset($params[$propertyName]))
			{
				if ($propertyName == 'logo')
				{
					$value = MediaHelper::getPublicFormatedUrl(DocumentHelper::getDocumentInstance($params[$propertyName]), 'modules.videos.frontoffice/logovideo');
				}
				else
				{
					$value = $params[$propertyName];
				}
			}
			else
			{
				$methodName = 'get' . ucfirst($propertyName);
				$value = $prefs->$methodName();
				if (is_string($value) && preg_match("/\|#([a-f0-9]{6})/i", $value, $matches))
				{
					$value = '0x' . $matches[1];
				}
				else if ($value instanceof media_persistentdocument_media)
				{
					$methodName = 'get' . ucfirst($propertyName) . 'Url';
					$value = $prefs->$methodName();
				}
			}
			
			if ($propertyName == 'repeat')
			{
				$value = ($value === 'true' || $value === true) ? 'always' : 'none';
			}
			
			if (isset($propNameToFlashName[$propertyName]))
			{
				$propertyName = $propNameToFlashName[$propertyName];
			}
			
			$flashvars[$propertyName] = $propertyName . '=' . $value;
		}
		
		if ($video instanceof videos_persistentdocument_video && $video->getImage() !== null)
		{
			$flashvars['image'] = 'image=' . MediaHelper::getPublicFormatedUrl($video->getImage(), 'modules.videos.frontoffice/imagevideo');
		}
		$flashvars['file'] = 'file=' . $video->getFileUrl();
		return $flashvars;
	}
}