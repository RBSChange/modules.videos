<?php
/**
 * videos_persistentdocument_preferences
 * @package videos
 */
class videos_persistentdocument_preferences extends videos_persistentdocument_preferencesbase
{
	/**
	 * @see f_persistentdocument_PersistentDocumentImpl::getLabel()
	 *
	 * @return String
	 */
	public function getLabel()
	{
		return f_Locale::translateUI(parent::getLabel());
	}	
	
	public function getPlayerUrl()
	{
		return MediaHelper::getFrontofficeStaticPath('jwplayer.swf');
	}
	
	public function getImageUrl()
	{
		return MediaHelper::getPublicFormatedUrl($this->getImage(), 'modules.videos.frontoffice/imagevideo');
	}
	
	public function getLogoUrl()
	{
		return MediaHelper::getPublicFormatedUrl($this->getLogo(), 'modules.videos.frontoffice/logovideo');
	}
	
	/**
	 * @return String
	 */
	public function getCleanBackColor()
	{
		return $this->cleanColor($this->getBackcolor());
	}
	
	/**
	 * @return String
	 */
	public function getCleanBackground()
	{
		return $this->cleanColor($this->getBackground());
	}
	
	/**
	 * @return String
	 */
	public function getCleanGlow()
	{
		return $this->cleanColor($this->getGlow());
	}
	
	/**
	 * @return String
	 */
	public function getCleanForeground()
	{
		return $this->cleanColor($this->getForeground());
	}
	
	/**
	 * @return String
	 */
	public function getCleanSpecial()
	{
		return $this->cleanColor($this->getSpecial());
	}
	
	/**
	 * @return String
	 */
	public function getCleanColor1()
	{
		return $this->cleanColor($this->getColor1());
	}
	
	/**
	 * @return String
	 */
	public function getCleanColor2()
	{
		return $this->cleanColor($this->getColor2());
	}
	
	/**
	 * @param String $color
	 * @return String
	 */
	private function cleanColor($color)
	{
		$value = $color;
		if (is_string($value) && preg_match("/\|#([a-f0-9]{6})/i", $value, $matches))
		{
			$value = '0x' . $matches[1];
		}
		return $value;
	}
}