<?php
/**
 * videos_PlaylistSuccessView
 * @param modules.video
 */
class videos_PlaylistSuccessView extends change_View
{
	/**
	 * @param change_Context $context
	 * @param change_Request $request
	 */
	public function _execute($context, $request)
	{
		$this->setTemplateName('Videos-Action-Playlist-Success', 'xml');
		$this->setAttributes($request->getParameters());
	}
}
