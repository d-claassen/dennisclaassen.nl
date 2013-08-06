<?php 

class Blog_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
      // Fetch all blogs
    	$blogItemMapper = new Blog_Model_Mapper_Blog_Post();
      $blogs = array_reverse( $blogItemMapper->fetchAll() );
      
    	// Get the TagCloud filled with labels
    	$cloud = Blog_Model_Blog_Label::getCloud();
    	// Style the Cloud
      $cloudDecorator = new Zend_Tag_Cloud_Decorator_HtmlCloud();
      $cloudDecorator->setHtmlTags( array(
          'div' => array( 
            'class' => 'center well'
          ) ) );
      $tagDecorator = new Zend_Tag_Cloud_Decorator_HtmlTag();
      $tagDecorator->setHtmlTags( array( 'span' ) );
    	$cloud->setCloudDecorator( $cloudDecorator )
        ->setTagDecorator( $tagDecorator );

      // Get all categories
      $categoryMapper = new Blog_Model_Mapper_Blog_Category();
      $categories = $categoryMapper->fetchAll();
      
      $this->view->blogs = $blogs;
      $this->view->cloud = $cloud;
      $this->view->categories = $categories;
    }
}