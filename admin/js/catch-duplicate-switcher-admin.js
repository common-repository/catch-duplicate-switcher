jQuery(function($) {
     /* CPT switch */
    $( '.ctp-switch' ).on( 'click', function() {
        var loader = $( this ).parent().next();

        loader.show();

        var main_control = $( this );
        var data = {
			action: 'ctp_switch',
			value: this.checked,
			security: $('#ctp_tabs_nonce').val(),
			option_name: main_control.attr('rel'),
		};

        $.post( ajaxurl, data, function( response ) {
            response = $.trim( response );

            if ( '1' == response ) {
                main_control.parent().parent().addClass( 'active' );
                main_control.parent().parent().removeClass( 'inactive' );
            } else if( '0' == response ) {
                main_control.parent().parent().addClass( 'inactive' );
                main_control.parent().parent().removeClass( 'active' );
            } else {
                alert( response );
            }
            loader.hide();
        });
    });
    /* CPT switch End */

    // Tabs
    $('.catchp_widget_settings .nav-tab-wrapper a').on('click', function(e){
        e.preventDefault();

        if( !$(this).hasClass('ui-state-active') ){
            $('.nav-tab').removeClass('nav-tab-active');
            $('.wpcatchtab').removeClass('active').fadeOut(0);

            $(this).addClass('nav-tab-active');

            var anchorAttr = $(this).attr('href');

            $(anchorAttr).addClass('active').fadeOut(0).fadeIn(500);
        }

    });

    // jQuery Match Height init for sidebar spots
    $(document).ready(function() {
        $('.catchp-sidebar-spot .sidebar-spot-inner, .col-2 .catchp-lists li, .col-3 .catchp-lists li').matchHeight();
    });
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
            console.log($( '#pts_post_type :selected' ));
            e.preventDefault();
        });
        $( '#cancel-post-type-switcher' ).on( 'click', function(e) {
            $( '#post-type-select' ).slideUp();
            $( '#edit-post-type-switcher' ).show();
            e.preventDefault();
        });
    });
    // jQuery UI Tooltip initializaion
    $(document).ready(function() {
        $('.tooltip').tooltip();
    });

   });
// switcher metabox section
