<?php
/**
 * DisplayDailymotionVideoBoSuccessView
 * @param modules.video
 */
class videos_DisplayDailymotionVideoBoSuccessView extends f_view_BaseView
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
