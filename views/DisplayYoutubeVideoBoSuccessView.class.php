<?php
/**
 * DisplayYoutubeVideoBoSuccessView
 * @param modules.video
 */
class videos_DisplayYoutubeVideoBoSuccessView extends f_view_BaseView
{
	/**
	 * @param Context $context
	 * @param Request $request
	 */
	public function _execute($context, $request)
	{
		
	    $this->setTemplateName('YoutubeVideo-Success');	    
        $this->setAttributes($request->getParameters());
	}
}
