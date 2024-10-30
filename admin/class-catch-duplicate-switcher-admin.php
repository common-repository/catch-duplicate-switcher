<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       www.catchplugins.com
 * @since      1.0.0
 *
 * @package    Catch_Duplicate_Switcher
 * @subpackage Catch_Duplicate_Switcher/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Catch_Duplicate_Switcher
 * @subpackage Catch_Duplicate_Switcher/admin
 * @author     Catch Plugins <www.catchplugins.com>
 */
class Catch_Duplicate_Switcher_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Catch_Duplicate_Page_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Catch_Duplicate_Page_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		
		if( isset( $_GET['page'] ) && 'catch-duplicate-switcher' == $_GET['page'] ) {
			wp_enqueue_style( $this->plugin_name. '-display-dashboard', plugin_dir_url( __FILE__ ) . 'css/catch-duplicate-switcher-admin.css', array(), $this->version, 'all' );
              }
            wp_enqueue_style( 'switcher', plugin_dir_url( __FILE__ ) . 'css/switcher.css', array(), $this->version,'all');
		}


	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Catch_Duplicate_Page_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Catch_Duplicate_Page_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		global $pagenow;
		
		if ( isset( $_GET['page'] ) && 'catch-duplicate-switcher' == $_GET['page'] ) {
			wp_enqueue_script( 'matchHeight', plugin_dir_url( __FILE__ ) . 'js/jquery-matchHeight.min.js', array( 'jquery' ), $this->version, false );
			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/catch-duplicate-switcher-admin.js', array( 'jquery', 'matchHeight','jquery-ui-tooltip' ), $this->version, false );
		}
		if( 'edit.php' === $pagenow ) {
			wp_enqueue_script( 'pts_quickedit', plugin_dir_url( __FILE__ ) . 'js/catch-switcher.js', array( 'jquery' ), $this->version, true);
		}
		if ( 'post.php' === $pagenow || 'post-new.php' === $pagenow ) {
			wp_enqueue_script( 'cdp-switcher', plugin_dir_url( __FILE__ ) . 'js/switcher.js', array( 'jquery' ), $this->version, true);
		}
	}


public function add_plugin_settings_menu() {
		add_menu_page(
			esc_html__( 'Catch Duplicate/Switcher ', 'catch-duplicate-switcher' ), // $page_title.
			esc_html__( 'Catch Duplicate/Switcher ', 'catch-duplicate-switcher' ), // $menu_title.
			'manage_options', // $capability.
			'catch-duplicate-switcher', // $menu_slug.
			array( $this, 'settings_page' ), // $callback_function.
			'dashicons-admin-page', // $icon_url.
			'99.01564' // $position.
		);
		add_submenu_page(
				'catch-duplicate-switcher', // $parent_slug.
				esc_html__( 'Catch Duplicate/Switcher', 'catch-duplicate-switcher' ), // $page_title.
				esc_html__( 'Settings', 'catch-duplicate-switcher' ), // $menu_title.
				'manage_options', // $capability.
				'catch-duplicate-switcher', // $menu_slug.
				array( $this,'settings_page' ) // $callback_function.
			);
	}


	public function settings_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
				wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'catch-duplicate-switcher' ) );
			}
			require plugin_dir_path( __FILE__ ) . 'partials/catch-duplicate-switcher-admin-display.php';
		}
		public function register_settings() {
			register_setting(
				'catch-duplicate-switcher-group',
				'catch_duplicate_switcher_options',
				array( $this, 'sanitize_callback' )
			);
	}
	public function sanitize_callback( $input ) {
		if ( isset( $input['reset'] ) && $input['reset'] ) {
			//If reset, restore defaults
			return catch_duplicate_switcher_default_options();
		}
		$message = null;
		$type    = null;

		// Verify the nonce before proceeding.
	    if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
	    	|| ( ! isset( $_POST['catch_duplicate_page_nounce'] )
	    	|| ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['catch_duplicate_page_nounce'] ) ), basename( __FILE__ ) ) )
	    	|| ( ! check_admin_referer( basename( __FILE__ ), 'catch_duplicate_page_nounce' ) ) ) {
				$input['switcher_status'] = ( isset( $input['switcher_status'] ) && '1' == $input['switcher_status'] ) ? '1' : '0';
				if ( isset( $input['duplicate_suffix_name'] ) ) {
					$input['duplicate_suffix_name']        = sanitize_text_field( $input['duplicate_suffix_name'] );
				if ( isset( $input['duplicate_page_redirect'] ) ) {
					$input['duplicate_page_redirect']        = sanitize_text_field( $input['duplicate_page_redirect'] );
				}
				if ( isset( $input['duplicate_status'] ) ) {
					$input['duplicate_status']        = sanitize_text_field( $input['duplicate_status'] );
				}
		}
		return $input;
	} 
	    return 'Invalid Nonce';
	}
	function add_plugin_meta_links( $meta_fields, $file ){
		if( CATCH_DUPLICATE_BASENAME == $file ) {
			$meta_fields[] = "<a href='https://catchplugins.com/support-forum/forum/catch-duplicate-switcher/' target='_blank'>Support Forum</a>";
			$meta_fields[] = "<a href='https://wordpress.org/support/plugin/catch-duplicate-switcher/reviews/#new-post' target='_blank' title='Rate'>
			        <i class='ct-rate-stars'>"
			  . "<svg xmlns='http://www.w3.org/2000/svg' width='15' height='15' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-star'><polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'/></svg>"
			  . "<svg xmlns='http://www.w3.org/2000/svg' width='15' height='15' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-star'><polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'/></svg>"
			  . "<svg xmlns='http://www.w3.org/2000/svg' width='15' height='15' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-star'><polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'/></svg>"
			  . "<svg xmlns='http://www.w3.org/2000/svg' width='15' height='15' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-star'><polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'/></svg>"
			  . "<svg xmlns='http://www.w3.org/2000/svg' width='15' height='15' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-star'><polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'/></svg>"
			  . "</i></a>";

			$stars_color = "#ffb900";

			echo "<style>"
				. ".ct-rate-stars{display:inline-block;color:" . $stars_color . ";position:relative;top:3px;}"
				. ".ct-rate-stars svg{fill:" . $stars_color . ";}"
				. ".ct-rate-stars svg:hover{fill:" . $stars_color . "}"
				. ".ct-rate-stars svg:hover ~ svg{fill:none;}"
				. "</style>";
		}

		return $meta_fields;
	}

	public function dt_duplicate_post_as_draft(){
	global $wpdb;
	$catch_duplicate_switcher_options = catch_duplicate_switcher_get_options();
     
     if (! ( isset( $_GET['post']) || isset( $_POST['post']) || ( isset($_REQUEST['action']) && 'dt_duplicate_post_as_draft' == $_REQUEST['action'] ) ) ) {
					 wp_die('No post to duplicate has been supplied!');
				 } 
	$suffix = !empty($catch_duplicate_switcher_options['duplicate_suffix_name']) ? ' -- '.$catch_duplicate_switcher_options['duplicate_suffix_name'] : '';
	$returnpage = '';
	/** get the original post id */
	$post_id = (isset($_GET['post']) ? $_GET['post'] : $_POST['post']);
    $post = get_post( $post_id ); 
	/** if you don't want current user to be the new post author,then change next couple of lines to this: $new_post_author = $post->post_author;*/
	$current_user = wp_get_current_user();
	$new_post_author = $current_user->ID; 
	/* if post data exists, create the post duplicate*/
	if (isset( $post ) && $post != null) { 
		$args = array(
			'comment_status' => $post->comment_status,
			'ping_status' => $post->ping_status,
			'post_author' => $new_post_author,
			'post_content' => $post->post_content,
			'post_excerpt' => $post->post_excerpt,
			'post_name' => $post->post_name,
			'post_parent' => $post->post_parent,
			'post_password' => $post->post_password,
			'post_status' => $catch_duplicate_switcher_options['duplicate_status'],
			'post_title' => $post->post_title.$suffix,
			'post_type' => $post->post_type,
			'to_ping' => $post->to_ping,
			'menu_order' => $post->menu_order
		); /* insert the post by wp_insert_post() function*/
	        $new_post_id = wp_insert_post( $args ); 
				 /* get all current post terms ad set them to the new post draft*/

				 $taxonomies = get_object_taxonomies($post->post_type);
				 if(!empty($taxonomies) && is_array($taxonomies)):
				 foreach ($taxonomies as $taxonomy) {
					 $post_terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'slugs'));
					 wp_set_object_terms($new_post_id, $post_terms, $taxonomy, false);
				 } 
				 endif;
				 
				 $post_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id");
				 if (count($post_meta_infos)!=0) {
				 $sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
				 foreach ($post_meta_infos as $meta_info) {
					 $meta_key = $meta_info->meta_key;
					 $meta_value = addslashes($meta_info->meta_value);
					 $sql_query_sel[]= "SELECT $new_post_id, '$meta_key', '$meta_value'";
					 }
					 $sql_query.= implode(" UNION ALL ", $sql_query_sel);
					 $wpdb->query($sql_query);
					 } 
					/*
					 * finally, redirecting to your choice
					 */
					if($post->post_type != 'post'):
					   $returnpage = '?post_type='.$post->post_type;
					endif;
					if($catch_duplicate_switcher_options['duplicate_page_redirect'] == 'to_list'): 
						wp_redirect( admin_url( 'edit.php'.$returnpage ) );
					elseif($catch_duplicate_switcher_options['duplicate_page_redirect'] == 'to_page'): 	
						wp_redirect( admin_url( 'post.php?action=edit&post=' . $new_post_id ) );
					else:
						wp_redirect( admin_url( 'edit.php'.$returnpage ) );
					endif;	
					 exit;
					 } else {
						wp_die('Error! Post creation failed, could not find original post: ' . $post_id);
					 }
					}
		    /*Add the duplicate link to action list for post_row_actions*/
		    public function duplicate_post_link( $actions, $post ) {
			$catch_duplicate_switcher_options = catch_duplicate_switcher_get_options();
			
			 if (current_user_can('edit_posts')) {
			 $actions['duplicate'] = '<a href="admin.php?action=dt_duplicate_post_as_draft&amp;post=' . $post->ID . '" title="Catch Duplicate as '.$catch_duplicate_switcher_options['duplicate_status'].'" rel="permalink">'.__( "Duplicate This", "catch-duplicate-switcher" ).'</a>';
			 }
			 return $actions;
		} 


	    public function duplicate_page_button(){
			global $post;
			$catch_duplicate_switcher_options = catch_duplicate_switcher_get_options();

			    
				$html  = '<div id="major-publishing-actions">';
				$html .= '<div id="export-action">';
				$html .= '<a href="admin.php?action=dt_duplicate_post_as_draft&amp;post=' . $post->ID . '" title=" Catch Duplicate as '.$catch_duplicate_switcher_options['duplicate_status'].'" rel="permalink">'.__( "Duplicate This", "catch-duplicate-switcher" ).'</a>';
				$html .= '</div>';
				$html .= '</div>';
				echo $html;
		}

		public function duplicate_page_admin_bar_link(){
			global $wp_admin_bar, $post;
			$catch_duplicate_switcher_options = catch_duplicate_switcher_get_options();
			
			$current_object = get_queried_object();
			if ( empty($current_object) )
			return;
			if ( ! empty( $current_object->post_type )
			&& ( $post_type_object = get_post_type_object( $current_object->post_type ) )
			&& ( $post_type_object->show_ui || $current_object->post_type  == 'attachment') )
			{
				$wp_admin_bar->add_menu( array(
				'parent' => 'edit',
				'id' => 'catch duplicate',
				'title' => __("Duplicate This as ".$catch_duplicate_switcher_options['duplicate_status']."", 'catch-duplicate-switcher'),
				'href' => admin_url().'admin.php?action=dt_duplicate_post_as_draft&amp;post='. $post->ID
				) );
			}
		}


      // switcher section
 
		public function add() {
			$settings = catch_duplicate_switcher_get_options();
			if( isset( $settings['switcher_status'] ) && 1 == $settings['switcher_status'] ) {
			add_meta_box( 'catch-duplicate-switcher', 'Catch Post Type', array( $this, 'metabox' ), null, 'side', 'high' );
		}
		
	}

		public function metabox() {
        // Post types
		$post_type  = get_post_type();
		$post_types = get_post_types( $this->get_post_type_args(), 'objects' );
		$cpt_object = get_post_type_object( $post_type );
		
		// Bail if object does not exist or produces an error
		if ( empty( $cpt_object ) || is_wp_error( $cpt_object ) ) {
			return;
		}

		if ( ! in_array( $cpt_object, $post_types, true ) ) {
			$post_types[ $post_type ] = $cpt_object;
		}

		// Unset attachment types, since support seems to be broken
		if ( isset( $post_types['attachment'] ) ) {
			unset( $post_types['attachment'] );
		}

		?><div class="misc-pub-section misc-pub-section-last post-type-switcher">
			<label for="pts_post_type"><?php esc_html_e( ' Catch Post Type:', 'catch-duplicate-switcher' ); ?></label>
			<span id="post-type-display"><?php echo esc_html( $cpt_object->labels->singular_name ); ?></span>

			<?php if ( current_user_can( $cpt_object->cap->publish_posts ) ) : ?>

				
				<div id="post-type-select">
					<select name="pts_post_type" id="pts_post_type"><?php

						foreach ( $post_types as $_post_type => $pt ) :

							if ( ! current_user_can( $pt->cap->publish_posts ) ) :
								continue;
							endif;

							?><option value="<?php echo esc_attr( $pt->name ); ?>" <?php selected( $post_type, $_post_type ); ?>><?php echo esc_html( $pt->labels->singular_name ); ?></option><?php

						endforeach;

					?></select>
					
				</div><?php

				wp_nonce_field( 'post-type-selector', 'pts-nonce-select' );

			endif;

		?></div>

	<?php
	}
	// Add post type column
	public function add_column( $columns ) {
		return array_merge( $columns, array( 'post_type' => esc_html__( 'Type', 'catch-duplicate-switcher' ) ) );
	}
	 //manage the post type column
	public function manage_column( $column, $post_id ) {
		switch( $column ) {
			case 'post_type' :
				$post_type = get_post_type_object( get_post_type( $post_id ) ); ?>

				<span data-post-type="<?php echo esc_attr( $post_type->name ); ?>"><?php echo esc_html( $post_type->labels->singular_name ); ?></span>

				<?php
				break;
		}
	}
// Add quick edit button for bulk-editing post type
   public function quick_edit( $column_name = '' ) {

		// Bail to prevent multiple dropdowns in each column
		if ( 'post_type' !== $column_name ) {
			return;
		} ?>

		<div id="pts_quick_edit" class="inline-edit-group wp-clearfix">
			<label class="alignleft">
				<span class="title"><?php esc_html_e( ' Catch Post Type', 'catch-duplicate-switcher' ); ?></span><?php

				wp_nonce_field( 'post-type-selector', 'pts-nonce-select' );

				$this->select_box();

			?></label>
		</div>

	<?php
	}
	public function quick_edit_script( $hook = '' ) {

		// Bail if not edit.php admin page
		if ( 'edit.php' !== $hook ) {
			return;
			wp_enqueue_script( 'pts_quickedit', plugin_dir_url( __FILE__ ) . 'js/catch-switcher.js', array( 'jquery' ), $this->version, true );

		}
	}

	public function select_box( $bulk = false ) {

		// Get post type specific data
		$args       = $this->get_post_type_args();
		$post_types = get_post_types( $args, 'objects' );
		$post_type  = get_post_type();
		$selected   = '';

		// Unset attachment types, since support seems to be broken
		if ( isset( $post_types['attachment'] ) ) {
			unset( $post_types['attachment'] );
		}

		// Start an output buffer
		ob_start();

		// Output
		?>
		   <select name="pts_post_type" id="pts_post_type"><?php

			// Maybe include "No Change" option for bulk
			if ( true === $bulk ) :
				?><option value="-1"><?php esc_html_e( '&mdash; No Change &mdash;', 'catch-duplicate-switcher' ); ?></option><?php
			endif;

			// Loop through post types
			foreach ( $post_types as $_post_type => $pt ) :

				// Skip if user cannot publish this type of post
				if ( ! current_user_can( $pt->cap->publish_posts ) ) :
					continue;
				endif;

				// Only select if not bulk
				if ( false === $bulk ) :
					$selected = selected( $post_type, $_post_type );
				endif;

				// Output option
				?><option value="<?php echo esc_attr( $pt->name ); ?>" <?php echo $selected; // Do not escape ?>><?php echo esc_html( $pt->labels->singular_name ); ?></option><?php

			endforeach;

		?></select><?php

		// Output the current buffer
		echo ob_get_clean();
	}
	public function override_type( $data = array(), $postarr = array() ) {
		// Bail if form field is missing
		if ( empty( $_REQUEST['pts_post_type'] ) || empty( $_REQUEST['pts-nonce-select'] ) ) {
			return $data;
		}

		// Bail if no specific post ID is being saved
		if ( empty( $postarr['post_ID'] ) ) {
			return $data;
		}


		// Post type information
		$post_id          = absint( $postarr['post_ID'] );
		$post_type        = sanitize_key( $_REQUEST['pts_post_type'] );
		$post_type_object = get_post_type_object( $post_type );

		// Bail if empty post type
		if ( empty( $post_id ) || empty( $post_type ) || empty( $post_type_object ) ) {
			return $data;
		}
		// Bail if no change
		if ( $post_type === $data['post_type'] ) {
			return $data;
		}
		
		if ( $post_id !== $postarr['ID'] ) {
			return $data;
		}
		// Bail if user cannot 'edit_post' on the current post ID
		if ( ! current_user_can( 'edit_post', $postarr['ID'] ) ) {
			return $data;
		}

		// Bail if user cannot 'publish_posts' on the new type
		if ( ! current_user_can( $post_type_object->cap->publish_posts ) ) {
			return $data;
		}
		// Bail if nonce is invalid
		if ( ! wp_verify_nonce( $_REQUEST['pts-nonce-select'], 'post-type-selector' ) ) {
			return $data;
		}

		//die($post_type);
		// Bail if autosave
		if ( wp_is_post_autosave( $postarr['ID'] ) ) {
			return $data;
		}

		// Bail if revision
		if ( wp_is_post_revision( $postarr['ID'] ) ) {
			return $data;
		}

		// Bail if it's a revision
		if ( in_array( $postarr['post_type'], array( $post_type, 'revision' ), true ) ) {
			return $data;
		}

		// Update post type
		$data['post_type'] = $post_type;

		// Return modified post data
		return $data;
	}

	private static function is_allowed_page() {

		// Only for admin area
		if ( is_blog_admin() || ( defined( 'DOING_AJAX' ) && DOING_AJAX && ( ! empty( $_REQUEST['action'] ) && ( 'inline-save' === $_REQUEST['action'] ) ) ) ) {

			// Allowed admin pages
			$pages = apply_filters( 'pts_allowed_pages', array(
				'post.php',
				'edit.php',
				'admin-ajax.php'
			) );

			// Only show switcher when editing
			return (bool) in_array( $GLOBALS['pagenow'], $pages, true );
		}

		// Default to false
		return false;
	}
	private function get_post_type_args() {
		return (array) apply_filters( 'pts_post_type_filter', array(
			'public'  => true,
			'show_ui' => true
		) );
	}
}

