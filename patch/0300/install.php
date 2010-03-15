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
		// Implement your patch here.
		$this->executeSQLQuery("alter table m_videos_doc_youtubevideo_i18n add `document_publicationstatus_i18n` ENUM('DRAFT', 'CORRECTION', 'ACTIVE', 'PUBLICATED', 'DEACTIVATED', 'FILED', 'DEPRECATED', 'TRASH', 'WORKFLOW') NULL DEFAULT NULL");
		$this->executeSQLQuery("alter table m_videos_doc_dailymotionvideo_i18n add `document_publicationstatus_i18n` ENUM('DRAFT', 'CORRECTION', 'ACTIVE', 'PUBLICATED', 'DEACTIVATED', 'FILED', 'DEPRECATED', 'TRASH', 'WORKFLOW') NULL DEFAULT NULL");
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
