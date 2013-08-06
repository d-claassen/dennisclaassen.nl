<?php

class Blog_CategoryController extends Zend_Controller_Action
{
  public function init()
  {

  }

  public function indexAction()
  {
    $mapper = new Blog_Model_Mapper_Blog_Category();
    $categories = $mapper->fetchAll();
    $this->view->categories = $categories;
  }

  public function viewAction()
  {
    $mapper = new Blog_Model_Mapper_Blog_Category();
    $category = $mapper->fetchBySlug( $this->_getParam( 'slug' ) );
    $category = $category[ 0 ];

    // update the navigation to show the correct name
    $active = $this->view->navigation()
      ->setRenderInvisible( true )
      ->findActive( $this->view->navigation()->getContainer() );
    if( count( $active ) )
    {
      $active = $active[ 'page' ];
      $active->setLabel( $category->getName() );
    }
    $itemMapper = new Blog_Model_Mapper_Blog_Post();
    $items = $itemMapper->fetchByCategory_Id( $category->getId() );

    $labelMapper = new Blog_Model_Mapper_Blog_Label();
    $labels = array();
    foreach( $items as $item ):
      $blogLabels = $labelMapper->getLabelsByBlog( $item->getId() );
      foreach( $blogLabels as $label ):
        if( !array_key_exists( $label->getId(), $labels ) )
        {
          $labels[ $label->getId() ] = array(
            'count' => 0,
            'label' => $label
          );
        }
        $labels[ $label->getId() ][ 'count' ]++;
      endforeach;
    endforeach;

    $counts = array();
    foreach( $labels as $label ):
      $counts[] = $label[ 'count' ];
    endforeach;
    array_multisort( $counts, SORT_DESC, $labels );

    $this->view->labels = $labels;
    $this->view->items = $items;
    $this->view->category = $category;
  }
}