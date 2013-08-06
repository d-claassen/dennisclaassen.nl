<?php 

class Blog_ItemController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    	$this->view->headTitle()->prepend('Blog');
    }

    public function indexAction()
    {
    	$mapper = new Blog_Model_Mapper_Blog_Post();

    	$blogs = $mapper->fetchAll();

    	$this->view->blogs = $blogs;
    }
    
    public function viewAction()
    {
    	$params = $this->getRequest()->getParams();
    	
        $id = $params[ 'id' ];
    	$slug = $params[ 'slug' ];
    	
    	$mapper = new Blog_Model_Mapper_Blog_Post();
    	$blog = $mapper->fetch( 'id = '.$id, 'created_on desc' );
    	if( count( $blog ) != 1 )
    	{
    		throw new Exception( count( $blog ) . " blog items found with " . $id);
    	}
    	// we only need one blog item
    	$blog = $blog[0];
    	/*
    	if ( $blog->getSlug() != $slug )
    	{
    		$this->_redirect($this->view->url(array_merge(
    			$params,
    			array( 'slug' => $blog->getSlug() )
    		)));
    	}
    	*/
    	
    	$this->view->blog = $blog;
    	
    	$this->view->headTitle()->prepend( $blog->getTitle() );

        // In the navigation is a page defined by Blog_Item::View
        // This page gets the active state now, and we replace it's label with the blog items title
        $page = $this->view->navigation()
            ->setRenderInvisible( true )
            ->findActive( $this->view->navigation()->getContainer() );
        $page[ 'page' ]->setLabel( $blog->getTitle() );
    }

}