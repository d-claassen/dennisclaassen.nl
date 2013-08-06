<?php 

class Blog_ArchiveController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    	$this->view->headTitle()->prepend('Blog');
    }

    public function indexAction()
    {
    	$mapper = new Blog_Model_Mapper_Blog_Item();
    	$blogs = $mapper->fetchAll();
    	$this->view->blogs = $blogs;
    }
 
}