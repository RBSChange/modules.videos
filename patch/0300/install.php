<?php
/**
 * videos_patch_0300
 * @package modules.videos
 */
class videos_patch_0300 extends patch_BasePatch
{
//  by default, isCodePatch() returns false.
//  decomment the following if your patch modify code instead of the database structure or content.
    /**
     * Returns true if the patch modify code that is versionned.
     * If your patch modify code that is versionned AND database structure or content,
     * you must split it into two different patches.
     * @return Boolean true if the patch modify code that is versionned.
     */
//	public function isCodePatch()
//	{
//		return true;
//	}
 
	/**
	 * Entry point of the patch execution.
	 */
	public function execute()
	{
		$newPath = f_util_FileUtils::buildWebeditPath('modules/videos/persistentdocument/preferences.xml');
		$newModel = generator_PersistentModel::loadModelFromString(f_util_FileUtils::read($newPath), 'videos', 'preferences');
		$newProp = $newModel->getPropertyByName('dailymotionhighlight');
		f_persistentdocument_PersistentProvider::getInstance()->addProperty('videos', 'preferences', $newProp);
		$prefs = ModuleService::getPreferencesDocument('videos');
		if ($prefs !== null)
		{
			$prefs->setModificationdate(null);
			$prefs->save();
		}
	}

	/**
	 * @return String
	 */
	protected final function getModuleName()
	{
		return 'videos';
	}

	/**
	 * @return String
	 */
	protected final function getNumber()
	{
		return '0300';
	}
}