<?php
/**
 * videos_persistentdocument_dailymotionvideo
 * @package modules.videos
 */
class videos_persistentdocument_dailymotionvideo extends videos_persistentdocument_dailymotionvideobase
{
	/**
	 * @return String
	 */
	public function getUrl()
	{
		return 'http://www.dailymotion.com/swf/' . $this->getVideoId();
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
		return $this->getUrl();
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
			'width' => $ms->getPreferenceValue('videos', 'dailyWidth') . 'px',
			'height' => $ms->getPreferenceValue('videos', 'dailyHeight') . 'px',
			'background-image' => 'url(' . MediaHelper::getIcon('dailymotionvideo', 'small') . ')'
		);
		$style = f_util_HtmlUtils::buildStyleAttribute($styleAttributes);
		$nodeAttributes[f_tree_parser_AttributesBuilder::HTMLLINK_ATTRIBUTE] = '<a rel="cmpref:' . $this->getId() . '" title="' . $title . '" href="#" lang="' . RequestContext::getInstance()->getLang() . '" class="document-dummy" style="' . $style . '">' . $title . '</a>';
	}
}