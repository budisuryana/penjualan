( function( $, pusher, addItem ) {

var itemActionChannel = pusher.subscribe( 'itemAction' );

itemActionChannel.bind( "App\\Events\\ItemCreated", function( data ) {

    addItem( data.id, false );
} );



} )( jQuery, pusher, addItem);