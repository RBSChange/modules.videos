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
	
	protected function addTreeAttributes($moduleName, $treeType, &$nodeAttributes)
	{
		$nodeAttributes['filesize'] = $this->getFilesize();
	}	
}