<?php
/**
 * videos_DisplayVideoBoSuccessView
 * @param modules.video
 */
class videos_DisplayVideoBoSuccessView extends change_View
{
	/**
	 * @param change_Context $context
	 * @param change_Request $request
	 */
	public function _execute($context, $request)
	{
		$this->setTemplateName('Video-Success');
		$this->setAttributes($request->getParameters());
	}
}
