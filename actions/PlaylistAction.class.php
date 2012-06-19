<?php
/**
 * videos_PlaylistAction
 * @package modules.videos
 */
class videos_PlaylistAction extends change_Action
{
	/**
	 * @param change_Context $context
	 * @param change_Request $request
	 */
	public function _execute($context, $request)
	{
		$id = $request->getModuleParameter('videos', change_Request::DOCUMENT_ID);
		
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
		
		return change_View::SUCCESS;
	}
		
	/**
	 * @return boolean
	 */
	public function isSecure()
	{
		return false;
	}
}