<?php
/**
 * DisplayYoutubeVideoBoSuccessView
 * @param modules.video
 */
class videos_DisplayYoutubeVideoBoSuccessView extends change_View
{
	/**
	 * @param change_Context $context
	 * @param change_Request $request
	 */
	public function _execute($context, $request)
	{
	    $this->setTemplateName('YoutubeVideo-Success');	    
        $this->setAttributes($request->getParameters());
	}
}
