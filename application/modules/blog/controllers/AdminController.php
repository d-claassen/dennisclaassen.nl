<?php

class Blog_AdminController extends Zend_Controller_Action
{
    public function init()
    {
        $user = Zend_Registry::get('user');

        if ( !$user->isLoggedIn() )
        {
            return $this->_redirect( $this->view->url(array(
                'module' => 'admin',
                'controller' => 'user',
                'action' => 'login'
            ), 'default' ) );
        }

        /* Initialize action controller here */
    	$this->view->headTitle()->prepend( 'Blog' );

      $layout = Zend_Layout::getMvcInstance();
      // Set a layout script path:
      $layout->setLayoutPath( APPLICATION_PATH . '/modules/admin/layouts/scripts/' );
      // choose a different layout script:
      $layout->setLayout( 'layout' );
    }

    public function indexAction()
    {
    	$mapper = new Blog_Model_Mapper_Blog_Post();
    	$blogs = $mapper->fetchAll();
        
    	$this->view->blogs = $blogs;
    }

    public function addAction()
    {
        if( $this->getRequest()->isPost() )
        {
            $Blog = new Blog_Model_Blog_Post();
            $Blog->setTitle( $this->_getParam( 'blog-title' ) );
            $Blog->setDescription( $this->_getParam( 'blog-description' ) );
            $Blog->setContent( $this->_getParam( 'blog-content' ) );
            $Blog->setStatus( $this->_getParam( 'blog-status' ) );

            $user = Zend_Registry::get( 'user' );
            $Blog->setAuthorId( $user->getId() );

            $Blog->setCreatedOn( date( 'Y-m-d h:i:s' ) );

            $Blog->save();

            print_r( $Blog );
        }
    }

    public function editAction()
    {
        if( is_null( $this->_getParam( 'id' ) ) )
        {
            $this->_redirect( $this->view->url( array( 'action' => 'add' ) ) );
        }

        $Blog = new Blog_Model_Mapper_Blog_Post();
        $blogs = $Blog->fetchById( $this->_getParam( 'id' ) );
        $Blog = $blogs[ 0 ];

        $this->view->blog = $Blog;
        $this->render( 'add' );
    }

    public function deleteAction()
    {
        if( !is_null( $this->_getParam( 'id' ) ) )
        {
            $Blog = new Blog_Model_Mapper_Blog_Post();
            $blogs = $Blog->fetchById( $this->_getParam( 'id' ) );
            if( $blogs === 1 )
            {
                $Blog = $blogs[ 0 ];
                $Blog->delete();
            }
        }

        $this->_redirect( $this->view->url( array( 'action' => 'index' ) ) );
    }
}