<?php
/**
 * @date Tue, 03 Mar 2009 13:03:59 +0000
 * @author intarand
 * @package 
 */
class videos_YoutubevideoService extends f_persistentdocument_DocumentService
{
	/**
	 * @var videos_YoutubevideoService
	 */
	private static $instance;
	
	/**
	 * @return videos_YoutubevideoService
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
		return $this->pp->createQuery('modules_videos/youtubevideo');
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
		$iframeUrl = LinkHelper::getUIActionLink('videos', 'DisplayYoutubeVideoBo');
		$iframeUrl->setQueryParameter('cmpref', $document->getId());
		$iframeUrl->setQueryParameter('t', time());	
		$data['content']['iframeurl'] = $iframeUrl->getUrl();
		return $data;
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
		
		$templateComponent = TemplateLoader::getInstance()->setpackagename('modules_videos')->setMimeContentType(K::HTML)->load('Videos-Block-Youtubevideo-Success');
		$templateComponent->setAttribute('video', $youtubeVideo);
		$content = $templateComponent->execute();
		return $content;
	}
}