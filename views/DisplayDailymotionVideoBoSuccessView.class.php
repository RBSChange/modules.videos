<?php
/**
 * DisplayDailymotionVideoBoSuccessView
 * @param modules.video
 */
class videos_DisplayDailymotionVideoBoSuccessView extends change_View
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
