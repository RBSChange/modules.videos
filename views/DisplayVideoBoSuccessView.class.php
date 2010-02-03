<?php
/**
 * videos_DisplayVideoBoSuccessView
 * @param modules.video
 */
class videos_DisplayVideoBoSuccessView extends f_view_BaseView
{
	/**
	 * @param Context $context
	 * @param Request $request
	 */
	public function _execute($context, $request)
	{
	    $this->setTemplateName('Video-Success');
        $this->setAttributes($request->getParameters());
	}
}
