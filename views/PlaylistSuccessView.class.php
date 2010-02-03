<?php
/**
 * videos_PlaylistSuccessView
 * @param modules.video
 */
class videos_PlaylistSuccessView extends f_view_BaseView
{
	/**
	 * @param Context $context
	 * @param Request $request
	 */
	public function _execute($context, $request)
	{
	    $this->setTemplateName('Videos-Action-Playlist-Success', K::XML);
        $this->setAttributes($request->getParameters());
	}
}
