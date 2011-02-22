<?php
/**
 * videos_patch_0301
 * @package modules.videos
 */
class videos_patch_0301 extends patch_BasePatch
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
		$this->log("compile-documents");
		$this->execChangeCommand("compile-documents");
		
		$this->log("compile-locales videos");
		$this->execChangeCommand("compile-locales", array("videos"));
		
		$this->log("compile-blocks");
		$this->execChangeCommand("compile-blocks");
		
		$this->log("migrage page contents");
		$rc = RequestContext::getInstance();
		$pageService = website_PageService::getInstance();
		$scriptPath = "modules/videos/patch/0301/migratePageContent.php";
		foreach ($rc->getSupportedLanguages() as $lang)
		{
			$rc->beginI18nWork($lang);
			$ids = $pageService->createQuery()
				->setProjection(Projections::property("id", "i"))
				->add(Restrictions::orExp(
					Restrictions::like("content", "modules_videos_video", MatchMode::ANYWHERE()),
					Restrictions::like("content", "modules_videos_playlist", MatchMode::ANYWHERE())))
				->findColumn("i");
			
			$idsCount = count($ids);
			$offset = 0;
			$chunkLength = 1;
			while ($offset < $idsCount)
			{
				$subIds = array_slice($ids, $offset, $chunkLength);
				$ret = f_util_System::execHTTPScript($scriptPath, array($lang, $subIds));
				if (!is_numeric($ret))
				{
					$this->logError("Error while processing " . ($offset * $chunkLength) . " - " . (($offset + 1) * $chunkLength) . ": $ret");
				}
				else
				{
					$this->log(($offset * $chunkLength) . " - " . (($offset + 1) * $chunkLength) . " processed: " . $ret . " content updated ($lang)");
				}
				$offset += $chunkLength;
			}
			
			$rc->endI18nWork();
		}
		
		$this->log("alter schema");
		$this->executeSQLQuery("ALTER TABLE `m_videos_doc_preferences` CHANGE `width` `videowidth` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL");
		$this->executeSQLQuery("ALTER TABLE `m_videos_doc_preferences` CHANGE `height` `videoheight` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL");
		$this->executeSQLQuery("TRUNCATE TABLE `f_cache`");
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
		return '0301';
	}
}