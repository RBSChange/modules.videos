<?php
/**
 * videos_persistentdocument_youtubevideo
 * @package modules.videos
 */
class videos_persistentdocument_youtubevideo extends videos_persistentdocument_youtubevideobase
{
	/**
	 * @return String
	 */
	public function getUrl()
	{
		return 'http://www.youtube.com/v/' . $this->getVideoId();
	}
	
	public function getWidth()
	{
		return ModuleService::getInstance()->getPreferenceValue('videos', 'youtubeWidth');
	}
	
	public function getHeight()
	{
		return ModuleService::getInstance()->getPreferenceValue('videos', 'youtubeHeight');
	}
	
	public function getCompleteUrl()
	{
		$prefs = ModuleService::getInstance()->getPreferencesDocument('videos');
		return $this->getUrl() . '&color1=' .  $prefs->getCleanColor1(). '&color2=' . $prefs->getCleanColor2() . '&fs=true' /*. $prefs->getFs() */. '&border=' . $prefs->getBorder() . ';&autoplay=' . $prefs->getYoutubeAutoPlay();
	}
	
	/**
	 * @param string $moduleName
	 * @param string $treeType
	 * @param array<string, string> $nodeAttributes
	 */
	protected function addTreeAttributes($moduleName, $treeType, &$nodeAttributes)
	{
		$lang = RequestContext::getInstance()->getLang();
		$title = $this->getLabelAsHtml();
		$ms = ModuleService::getInstance();
		$styleAttributes = array(
			'width' => $ms->getPreferenceValue('videos', 'youtubeWidth') . 'px',
			'height' => $ms->getPreferenceValue('videos', 'youtubeHeight') . 'px',
			'background-image' => 'url(' . MediaHelper::getIcon('youtubevideo', 'small') . ')'
		);
		$style = f_util_HtmlUtils::buildStyleAttribute($styleAttributes);
		$nodeAttributes[f_tree_parser_AttributesBuilder::HTMLLINK_ATTRIBUTE] = '<a rel="cmpref:' . $this->getId() . '" title="' . $title . '" href="#" lang="' . RequestContext::getInstance()->getLang() . '" class="document-dummy" style="' . $style . '">' . $title . '</a>';
	}
}