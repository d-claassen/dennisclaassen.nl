( function( $ ) {

  var settings = {
    'dataClass': 'confirm-class'
  }

  var methods = {
    init : function( options )
    {
      options = $.extend( settings, options );
      var items = this;
      $( document ).click( function()
      {
        items
          .removeClass( "clicked" )
          .removeClass( function()
          {
            return $( this ).data( options.dataClass );
          } );
      } );

      return this.click( function( e )
      {
        var $this = $( this );
        if( !$this.hasClass( $( this ).data( options.dataClass ) ) )
        {
          items
            .removeClass( "clicked" )
            .removeClass( function()
            {
              return $this.data( options.dataClass )
            } );

          $this
            .addClass( "clicked" )
            .addClass( $this.data( options.dataClass ) );

          e.preventDefault();
          return false;
        }
        e.stopPropagation();
      } );
    }
  };

  $.fn.confirm = function( method )
  {
    if( methods[method] )
    {
      return methods[ method ].apply( this, Array.prototype.slice.call( arguments, 1 ) );
    }
    else if( typeof method === 'object' || !method )
    {
      return methods.init.apply( this, arguments );
    }
    else
    {
      $.error( 'Method ' +  method + ' does not exist on jQuery.confirm' );
    }    
  }
} )( jQuery );