<?php
/**
 * videos_persistentdocument_video
 * @package videos
 */
class videos_persistentdocument_video extends videos_persistentdocument_videobase
{
	/**
	 * @return string
	 */
	public function getFileUrl()
	{
		return MediaHelper::getPublicFormatedUrl($this->getFile(), null);
	}

	/**
	 * @return string
	 */
	public function getFilesize()
	{
		return MediaHelper::getFileSize($this->getFile());
	}

	/**
	 * @return string
	 */
	public function getExtension()
	{
		$info =  $this->getFile()->getInfo();
		return $info['extension'];
	}
}