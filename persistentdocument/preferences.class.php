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
	 * @return string
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
	 * @return string
	 */
	public function getCleanBackColor()
	{
		return $this->cleanColor($this->getBackcolor());
	}
	
	/**
	 * @return string
	 */
	public function getCleanBackground()
	{
		return $this->cleanColor($this->getBackground());
	}
	
	/**
	 * @return string
	 */
	public function getBackgroundForDailyMotion()
	{
		return $this->normalizeColorDailymotion($this->getBackground());
	}
	
	/**
	 * @return string
	 */
	public function getCleanGlow()
	{
		return $this->cleanColor($this->getGlow());
	}
	
	/**
	 * @return string
	 */
	public function getGlowForDailyMotion()
	{
		return $this->normalizeColorDailymotion($this->getGlow());
	}
	
	/**
	 * @return string
	 */
	public function getCleanForeground()
	{
		return $this->cleanColor($this->getForeground());
	}
	
	/**
	 * @return string
	 */
	public function getForegroundForDailyMotion()
	{
		return $this->normalizeColorDailymotion($this->getForeground());
	}
	
	/**
	 * @return string
	 */
	public function getCleanSpecial()
	{
		return $this->cleanColor($this->getSpecial());
	}
	
	/**
	 * @return string
	 */
	public function getSpecialForDailyMotion()
	{
		return $this->normalizeColorDailymotion($this->getSpecial());
	}
	
	/**
	 * @return string
	 */
	public function getHighlightForDailymotion()
	{
		return $this->normalizeColorDailymotion($this->getDailymotionhighlight());
	}
	
	/**
	 * @return string
	 */
	public function getCleanColor1()
	{
		return $this->cleanColor($this->getColor1());
	}
	
	/**
	 * @return string
	 */
	public function getCleanColor2()
	{
		return $this->cleanColor($this->getColor2());
	}
	
	/**
	 * @param string $color
	 * @return string
	 */
	private function cleanColor($color)
	{
		$value = $color;
		if (is_string($value) && preg_match("/#([a-f0-9]{6})/i", $value, $matches))
		{
			$value = '0x' . $matches[1];
		}
		return $value;
	}
	
	private function normalizeColorDailymotion($color)
	{
		return str_replace('#', '', $color);
	}
}