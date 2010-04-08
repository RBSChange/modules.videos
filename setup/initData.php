<?php
/**
 * videos_Setup
 * @package modules.video
 */
class videos_Setup extends object_InitDataSetup
{
	/**
	 * This methode is calls when using the builder.
	 * change import-init-data
	 *
	 * look methode class
	 * @return void
	 */
	public function install()
	{
		try
		{
			$scriptReader = import_ScriptReader::getInstance();
       	 	$scriptReader->executeModuleScript('videos', 'init.xml');
		}
		catch (Exception $e)
		{
			echo "ERROR: " . $e->getMessage() . "\n";
			Framework::exception($e);
		}
		
		try
		{
			$this->importPlayer();
		}
		catch (Exception $e)
		{
			echo $e->getMessage()."\n";
		}
	}

	private function importPlayer()
	{
		$playerPath = FileResolver::getInstance()->setPackageName('modules_videos')
			->setDirectory('player')->getPath('jwplayer.swf');
		$destPath = f_util_FileUtils::buildWebeditPath('media', 'frontoffice', 'jwplayer.swf');
		f_util_FileUtils::cp($playerPath, $destPath, f_util_FileUtils::OVERRIDE);
	}
}
