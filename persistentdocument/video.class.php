<?php
/**
 * videos_persistentdocument_video
 * @package videos
 */
class videos_persistentdocument_video extends videos_persistentdocument_videobase
{
	public function getFileUrl()
	{
		return MediaHelper::getPublicFormatedUrl($this->getFile(), null);
	}

	public function getFilesize()
	{
		return MediaHelper::getFileSize($this->getFile());
	}

	public function getExtension()
	{
		$info =  $this->getFile()->getInfo();
		return $info['extension'];
	}
	
	/**
	 * @param string $moduleName
	 * @param string $treeType
	 * @param array<string, string> $nodeAttributes
	 */
	protected function addTreeAttributes($moduleName, $treeType, &$nodeAttributes)
	{
		$nodeAttributes['filesize'] = $this->getFilesize();
		
		$lang = RequestContext::getInstance()->getLang();
		$title = $this->getLabelAsHtml();
		$ms = ModuleService::getInstance();
		$styleAttributes = array(
			'width' => $ms->getPreferenceValue('videos', 'videoWidth') . 'px',
			'height' => $ms->getPreferenceValue('videos', 'videoHeight') . 'px',
			'background-image' => 'url(' . MediaHelper::getIcon('video', 'small') . ')'
		);
		$style = f_util_HtmlUtils::buildStyleAttribute($styleAttributes);
		$nodeAttributes[f_tree_parser_AttributesBuilder::HTMLLINK_ATTRIBUTE] = '<a rel="cmpref:' . $this->getId() . '" title="' . $title . '" href="#" lang="' . RequestContext::getInstance()->getLang() . '" class="document-dummy" style="' . $style . '">' . $title . '</a>';
	}
}