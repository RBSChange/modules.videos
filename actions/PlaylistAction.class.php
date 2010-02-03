<?php
/**
 * videos_PlaylistAction
 * @package modules.videos
 */
class videos_PlaylistAction extends f_action_BaseAction
{
	/**
	 * @param Context $context
	 * @param Request $request
	 */
	public function _execute($context, $request)
	{
		$id = $request->getModuleParameter('videos', K::COMPONENT_ID_ACCESSOR);
		
		$playlist = DocumentHelper::getDocumentInstance($id);		
		if ($playlist !== null)
		{
			$image = ModuleService::getInstance()->getPreferenceValue('videos', 'image');
			if ($image !== null)
			{
				$request->setParameter('defaultImage', MediaHelper::getPublicFormatedUrl($image));
			}
			$request->setParameter('playlist', $playlist);
		}
		
		return View::SUCCESS;
	}
		
	/**
	 * @return Boolean
	 */
	public function isSecure()
	{
		return false;
	}
}