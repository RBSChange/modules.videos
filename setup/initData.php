<?php
/**
 * @package modules.videos
 */
class videos_Setup extends object_InitDataSetup
{
	public function install()
	{
		$this->executeModuleScript('init.xml');
	}
}