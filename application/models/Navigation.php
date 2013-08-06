<?php

class Application_Model_Navigation extends Zend_Navigation
{
	public function loadPages($parentId = null)
	{
		$mapper = new Application_Model_Mapper_Navigation();
		$loadedPages = $mapper->loadPages();
		$pagesTotal = count( $loadedPages );
		$pagesAdded = 0;

		while( $pagesTotal !== $pagesAdded )
		{
			$changed = false;
				
			foreach( $loadedPages as $page )
			{
				if ( is_null( $page->getParentId() ) )
				{
					$this->addPage( $page );
					$pagesAdded++;
					$changed = true;
						
				}
				elseif( $parent = $this->findById( $page->getParentId() ) )
				{
					$parent->addPage( $page );
					$pagesAdded++;
					$changed = true;
				}
			}

			if ( !$changed )
			{
				throw new Exception('No page could be added to the navigation!');
			}
		}
	}
}