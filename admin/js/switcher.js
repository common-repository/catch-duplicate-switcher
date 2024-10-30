jQuery(function($) {
    $(document).ready(function() {
        $( '.misc-pub-section.curtime.misc-pub-section-last' ).removeClass( 'misc-pub-section-last' );
        $( '#edit-post-type-switcher' ).on( 'click', function(e) {
            $( this ).hide();
            $( '#post-type-select' ).slideDown();
            e.preventDefault();
        });
        $( '#save-post-type-switcher' ).on( 'click', function(e) {
            $( '#post-type-select' ).slideUp();
            $( '#edit-post-type-switcher' ).show();
            $( '#post-type-display' ).text( $( '#pts_post_type :selected' ).text() );
            //console.log($( '#pts_post_type :selected' ));
            e.preventDefault();
        });
        $( '#cancel-post-type-switcher' ).on( 'click', function(e) {
            $( '#post-type-select' ).slideUp();
            $( '#edit-post-type-switcher' ).show();
            e.preventDefault();
        });
    });
});