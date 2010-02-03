<?php
class videos_XmlListTreeParser extends tree_parser_XmlListTreeParser
{
	
	/**
     * Returns the document's specific and/or overridden attributes.
     *
	 * @param f_persistentdocument_PersistentDocument $document
	 * @param XmlElement $treeNode
	 * @param f_persistentdocument_PersistentDocument $reference
	 * @return array<mixed>
	 */
	protected function getAttributes($document, $treeNode, $reference = null)
	{
		$attributes = parent::getAttributes($document, $treeNode, $reference);
		
		switch($document->getDocumentModelName())
		{
			case 'modules_videos/video':
				$attributes['filesize'] = $document->getFilesize();
			break;
			
			default:
		}
		
		return $attributes;
	}
	
}
