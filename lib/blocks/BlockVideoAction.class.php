<?php
/**
 * videos_BlockVideoAction
 * @package modules.videos
 */
class videos_BlockVideoAction extends website_BlockAction
{
	/**
	 * @return array<String, String> couples of (parameter name / value) that are used by the block
	 */
	public function getCacheKeyParameters($request)
	{
		$keys = array('params' => $this->getConfigurationParameters());
		$keys['cmpref'] = $this->getDocumentIdParameter();
		$keys['lang'] = $this->getLang();
		$keys['pageId'] = $this->getPage()->getId();
		return $keys;
	}
	
	/**
	 * @return array<String>
	 */
	public function getCacheDependencies()
	{
		return array('modules_videos/video', 'module_media/media', 'modules_videos/preferences');
	}
	
	protected function getVideo()
	{
		return $this->getDocumentParameter(K::COMPONENT_ID_ACCESSOR, 'videos_persistentdocument_video');
	}
	
	/**
	 * @see website_BlockAction::execute()
	 *
	 * @param f_mvc_Request $request
	 * @param f_mvc_Response $response
	 * @return String
	 */
	function execute($request, $response)
	{
		if ($this->isInBackoffice())
		{
			$prefs = ModuleService::getInstance()->getPreferencesDocument('videos');
			$style['width'] = $this->getParameter('width', $prefs->getWidth()) . "px";
			$style['height'] = $this->getParameter('height', $prefs->getHeight()) . "px";
			$style['border'] = '1px dotted grey';
			$request->setAttribute('video', $this->getDocumentParameter(K::COMPONENT_ID_ACCESSOR, 'videos_persistentdocument_video'));
			$request->setAttribute('style', f_util_HtmlUtils::buildStyleAttribute($style));
			return website_BlockView::DUMMY;
		}
		$video = $this->getVideo();
		
		if ($video === null || !$video->isPublished())
		{
			return website_BlockView::NONE;
		}
		$prefs = ModuleService::getInstance()->getPreferencesDocument('videos');
		
		$player = array();
		$player['getPlayerUrl'] = $prefs->getPlayerUrl();
		$player['getWidth'] = $this->getConfigurationParameter('width', $prefs->getWidth());
		$player['getHeight'] = $this->getConfigurationParameter('height', $prefs->getHeight());
		$player['getCleanBackColor'] = $prefs->getCleanBackColor();
		$player['getUsefullscreen'] = $this->getConfigurationParameter('usefullscreen', $prefs->getUsefullscreen());
		$player['getFlashvars'] = implode('&', $this->getFlashvars($this->getConfigurationParameters(), $prefs, $video));
		$request->setAttribute('video', $video);
		$request->setAttribute('player', $player);
		return website_BlockView::SUCCESS;
	}
	
	/**
	 * @param Array $params
	 * @param videos_persistentdocument_preferences $prefs
	 * @param videos_persistentdocument_video $video
	 */
	protected function getFlashvars($params, $prefs, $video)
	{
		$flashvars = array();
		
		$properties = array('width', 'height', 'image', 'backcolor', 'frontcolor', 'lightcolor', 'screencolor', 'logo', 'icons', 'controlbar', 'usefullscreen', 'autostart', 'repeat');
		foreach ($properties as $propertyName)
		{
			if (isset($params[$propertyName]))
			{
				if ($propertyName == 'logo')
				{
					$value = MediaHelper::getPublicFormatedUrl(DocumentHelper::getDocumentInstance($params[$propertyName]), 'modules.videos.frontoffice/logovideo');
				}
				else
				{
					$value = $params[$propertyName];
				}
			}
			else
			{
				$methodName = 'get' . ucfirst($propertyName);
				$value = $prefs->$methodName();
				if (is_string($value) && preg_match("/\|#([a-f0-9]{6})/i", $value, $matches))
				{
					$value = '0x' . $matches[1];
				}
				else if ($value instanceof media_persistentdocument_media)
				{
					$methodName = 'get' . ucfirst($propertyName) . 'Url';
					$value = $prefs->$methodName();
				}
			}
			
			if ($propertyName == 'repeat')
			{
				$value = ($value === 'true' || $value === true) ? 'always' : 'none';
			}
			
			$flashvars[$propertyName] = $propertyName . '=' . $value;
		}
		
		if ($video instanceof videos_persistentdocument_video && $video->getImage() !== null)
		{
			$flashvars['image'] = 'image=' . MediaHelper::getPublicFormatedUrl($video->getImage(), 'modules.videos.frontoffice/imagevideo');
		}
		$flashvars['file'] = 'file=' . $video->getFileUrl();
		return $flashvars;
	}
}