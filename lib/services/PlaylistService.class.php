<?php
/**
 * @date Thu, 26 Feb 2009 11:28:04 +0000
 * @author intarand
 * @package 
 */
class videos_PlaylistService extends f_persistentdocument_DocumentService
{
	/**
	 * @var videos_PlaylistService
	 */
	private static $instance;

	/**
	 * @return videos_PlaylistService
	 */
	public static function getInstance()
	{
		if (self::$instance === null)
		{
			self::$instance = self::getServiceClassInstance(get_class());
		}
		return self::$instance;
	}

	/**
	 * @return videos_persistentdocument_playlist
	 */
	public function getNewDocumentInstance()
	{
		return $this->getNewDocumentInstanceByModelName('modules_videos/playlist');
	}

	/**
	 * Create a query based on 'modules_videos/playlist' model
	 * @return f_persistentdocument_criteria_Query
	 */
	public function createQuery()
	{
		return $this->pp->createQuery('modules_videos/playlist');
	}
}