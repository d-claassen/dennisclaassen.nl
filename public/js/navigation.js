$( function()
{
	function prepare()
	{
		$( 'ul.collapsable > li > span.bullet-plus-icon' ).toggle( open, close );
		$( 'ul.collapsable > li > span.bullet-minus-icon' ).toggle( close, open );
	}
	
	function open()
	{
		$( this ).removeClass( 'bullet-plus-icon' )
			.addClass( 'bullet-minus-icon' );
		$( $( this ).parent() ).children( 'ul' ).css( 'display', 'block' );
		
		// prepare();
	}
	
	function close()
	{
		$( this ).removeClass( 'bullet-minus-icon' )
			.addClass( 'bullet-plus-icon' );
		$( $( this ).parent() ).children( 'ul' ).css( 'display', 'none' );
		
		// prepare();
	}
	
	prepare();
} );