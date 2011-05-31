<?php
/**
 * @date Mon, 02 Mar 2009 13:37:28 +0000
 * @author intarand
 * @package 
 */
class videos_DailymotionvideoService extends f_persistentdocument_DocumentService
{
	/**
	 * @var videos_DailymotionvideoService
	 */
	private static $instance;

	/**
	 * @return videos_DailymotionvideoService
	 */
	public static function getInstance()
	{
		if (self::$instance === null)
		{
			self::$instance = self::getServiceClassInstance(get_class());
		}
		return self::$instance;
	}

	/**
	 * @return videos_persistentdocument_dailymotionvideo
	 */
	public function getNewDocumentInstance()
	{
		return $this->getNewDocumentInstanceByModelName('modules_videos/dailymotionvideo');
	}

	/**
	 * Create a query based on 'modules_videos/dailymotionvideo' model
	 * @return f_persistentdocument_criteria_Query
	 */
	public function createQuery()
	{
		return $this->pp->createQuery('modules_videos/dailymotionvideo');
	}

	/**
	 * @see f_persistentdocument_DocumentService::getResume()
	 *
	 * @param f_persistentdocument_PersistentDocument $document
	 * @param string $forModuleName
	 * @param array $allowedSections
	 * @return array
	 */
	public function getResume($document, $forModuleName, $allowedSections)
	{
		$data = parent::getResume($document, $forModuleName, $allowedSections);
		$iframeUrl = LinkHelper::getUIActionLink('videos', 'DisplayDailymotionVideoBo');
		$iframeUrl->setQueryParameter('cmpref', $document->getId());
		$iframeUrl->setQueryParameter('t', time());
		$data['content']['iframeurl'] = $iframeUrl->getUrl();
		return $data;
	}
	
	/**
	 * @param videos_persistentdocument_dailymotionvideo $document
	 * @param string $moduleName
	 * @param string $treeType
	 * @param array<string, string> $nodeAttributes
	 */
	public function addTreeAttributes($document, $moduleName, $treeType, &$nodeAttributes)
	{
		$lang = RequestContext::getInstance()->getLang();
		$title = $document->getLabelAsHtml();
		$ms = ModuleService::getInstance();
		$styleAttributes = array(
			'width' => $ms->getPreferenceValue('videos', 'dailyWidth') . 'px',
			'height' => $ms->getPreferenceValue('videos', 'dailyHeight') . 'px',
			'background-image' => 'url(' . MediaHelper::getIcon('dailymotionvideo', 'small') . ')'
		);
		$style = f_util_HtmlUtils::buildStyleAttribute($styleAttributes);
		$nodeAttributes[f_tree_parser_AttributesBuilder::HTMLLINK_ATTRIBUTE] = '<a rel="cmpref:' . $document->getId() . '" title="' . $title . '" href="#" lang="' . $lang . '" class="document-dummy" style="' . $style . '">' . $title . '</a>';
	}
	
	/**
	 * @param videos_persistentdocument_dailymotionvideo $document
	 * @param array $attributes
	 * @param string $content
	 * @param string $lang
	 * @return string
	 */
	public function getXhtmlFragment($document, $attributes, $content, $lang)
	{
		$prefs = ModuleService::getInstance()->getPreferencesDocument('videos');
		
		$dailyVideo = array();
		$dailyVideo['getUrl'] = $document->getUrl() . '&background=' . $prefs->getBackgroundForDailymotion() . '&highlight=' . $prefs->getHighlightForDailymotion() . '&foreground=' . $prefs->getForegroundForDailymotion() . '&autoPlay=' . $prefs->getDailyAutoPlay();
		$dailyVideo['getLabel'] = $document->getLabel();
		$dailyVideo['getWidth'] = $prefs->getDailyWidth();
		$dailyVideo['getHeight'] = $prefs->getDailyHeight();
				
		$templateComponent = TemplateLoader::getInstance()->setpackagename('modules_videos')->setMimeContentType(K::HTML)->load('Videos-Block-Dailymotionvideo-Success');
		$templateComponent->setAttribute('video', $dailyVideo);
		$content = $templateComponent->execute();
		return $content;
	}
}