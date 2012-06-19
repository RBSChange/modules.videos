<?php
/**
 * @package modules.videos
 * @method videos_YoutubevideoService getInstance()  
 */
class videos_YoutubevideoService extends f_persistentdocument_DocumentService
{
	/**
	 * @return videos_persistentdocument_youtubevideo
	 */
	public function getNewDocumentInstance()
	{
		return $this->getNewDocumentInstanceByModelName('modules_videos/youtubevideo');
	}
	
	/**
	 * Create a query based on 'modules_videos/youtubevideo' model
	 * @return f_persistentdocument_criteria_Query
	 */
	public function createQuery()
	{
		return $this->getPersistentProvider()->createQuery('modules_videos/youtubevideo');
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
		$iframeUrl = LinkHelper::getUIActionLink('videos', 'DisplayYoutubeVideoBo');
		$iframeUrl->setQueryParameter('cmpref', $document->getId());
		$iframeUrl->setQueryParameter('t', time());	
		$data['content']['iframeurl'] = $iframeUrl->getUrl();
		return $data;
	}
	
	/**
	 * @param videos_persistentdocument_youtubevideo $document
	 * @param array<string, string> $attributes
	 * @param integer $mode
	 * @param string $moduleName
	 */
	public function completeBOAttributes($document, &$attributes, $mode, $moduleName)
	{
		if ($mode & DocumentHelper::MODE_RESOURCE)
		{
			$lang = RequestContext::getInstance()->getLang();
			$title = $document->getLabelAsHtml();
			$ms = ModuleService::getInstance();
			$styleAttributes = array(
				'width' => $ms->getPreferenceValue('videos', 'youtubeWidth') . 'px',
				'height' => $ms->getPreferenceValue('videos', 'youtubeHeight') . 'px',
				'background-image' => 'url(' . MediaHelper::getIcon('youtubevideo', 'small') . ')'
			);
			$style = f_util_HtmlUtils::buildStyleAttribute($styleAttributes);
			$attributes['htmllink'] = '<a rel="cmpref:' . $document->getId() . '" title="' . $title . '" href="#" lang="' . $lang . '" class="document-dummy" style="' . $style . '">' . $title . '</a>';
		}
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
		
		$youtubeVideo = array();
		$youtubeVideo['getUrl'] = $document->getUrl() . '&color1=' . $prefs->getCleanColor1() . '&color2=' . $prefs->getCleanColor2() . '&fs=' . $prefs->getFs() . '&border=' . $prefs->getBorder() . ';&autoplay=' . $prefs->getYoutubeAutoPlay();
		$youtubeVideo['getLabel'] = $document->getLabel();
		$youtubeVideo['getWidth'] = $prefs->getYoutubeWidth();
		$youtubeVideo['getHeight'] = $prefs->getYoutubeHeight();
		
		$templateComponent = TemplateLoader::getInstance()->setpackagename('modules_videos')->setMimeContentType('html')->load('Videos-Block-Youtubevideo-Success');
		$templateComponent->setAttribute('video', $youtubeVideo);
		$content = $templateComponent->execute();
		return $content;
	}
}