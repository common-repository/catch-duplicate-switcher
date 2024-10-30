<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       www.catchplugins.com
 * @since      1.0.0
 *
 * @package    Catch_Duplicate_Switcher
 * @subpackage Catch_Duplicate_Switcher/admin/partials
 */
?>


<div class="wrap">
	<h1 class="wp-heading-inline"><?php esc_html_e( 'Catch Duplicate/Switcher', 'catch-duplicate-switcher' ); ?></h1>
	<div id="plugin-description">
		<p><?php esc_html_e( 'Let you duplicate and switch page /post effortlessly.', 'catch-duplicate-switcher' ); ?></p>
	</div>
	<div class="catchp-content-wrapper">
		<div class="catchp_widget_settings">
			 <?php if ( isset( $_GET['settings-updated'] ) ) { ?>
				<div id="message" class="notice updated fade">
					<p><strong><?php esc_html_e( 'Plugin Options Saved.', 'catch-duplicate-switcher' ); ?></strong></p>
				</div>
			<?php } ?>

			<form id="duplicate-page" method="post" action="options.php">
				<?php settings_fields( 'catch-duplicate-switcher-group' ); ?>
				   <?php wp_nonce_field( basename( __FILE__ ), 'catch_duplicate_page_nounce' ); ?>

					<h2 class="nav-tab-wrapper">
					<a class="nav-tab nav-tab-active" id="dashboard-tab" href="#dashboard"><?php esc_html_e( 'Dashboard', 'catch-duplicate-switcher' ); ?></a>
					<a class="nav-tab" id="switcher-tab" href="#switcher"><?php esc_html_e( 'Switcher Settings', 'catch-duplicate-switcher' ); ?></a>
					<a class="nav-tab" id="features-tab" href="#features"><?php esc_html_e( 'Features', 'catch-duplicate-switcher' ); ?></a>

				</h2>
				</h2>
				<div id="dashboard" class="wpcatchtab nosave active">
					<?php require_once plugin_dir_path( dirname( __FILE__ ) ) . 'partials/dashboard-display.php'; ?>
					 <div id="ctp-switch" class="content-wrapper col-3 catch-duplicate-switcher-main">
						<div class="header">
							<h2><?php esc_html_e( 'Catch Themes & Catch Plugins Tabs', 'catch-duplicate-switcher' ); ?></h2>
						</div> <!-- .Header -->

						<div class="content">

							<p><?php echo esc_html__( 'If you want to turn off Catch Themes & Catch Plugins tabs option in Add Themes and Add Plugins page, please uncheck the following option.', 'catch-duplicate-switcher' ); ?>
							</p>
							<table>
								<tr>
									<td>
										<?php echo esc_html__( 'Turn On Catch Themes & Catch Plugin tabs', 'catch-duplicate-switcher' ); ?>
									</td>
									<td>
										<?php $ctp_options = ctp_get_options(); ?>
										<div class="module-header <?php echo $ctp_options['theme_plugin_tabs'] ? 'active' : 'inactive'; ?>">
											<div class="switch">
												<input type="hidden" name="ctp_tabs_nonce" id="ctp_tabs_nonce" value="<?php echo esc_attr( wp_create_nonce( 'ctp_tabs_nonce' ) ); ?>" />
												<input type="checkbox" id="ctp_options[theme_plugin_tabs]" class="ctp-switch" rel="theme_plugin_tabs" <?php checked( true, $ctp_options['theme_plugin_tabs'] ); ?> >
												<label for="ctp_options[theme_plugin_tabs]"></label>
											</div>
											<div class="loader"></div>
										</div>
									</td>
								</tr>
							</table>

						</div>
					</div><!-- #ctp-switch -->
				</div><!---dashboard---->

				<div id="switcher" class="wpcatchtab save">
					<?php require_once plugin_dir_path( dirname( __FILE__ ) ) . 'partials/switcher.php'; ?>

					</div><!---switcher---->


				<div id="features" class="wpcatchtab save">
					<div class="content-wrapper col-3">
						<div class="header">
							<h3><?php esc_html_e( 'Features', 'catch-duplicate-switcher' ); ?></h3>
						</div><!-- .header -->
						<div class="content">
							<ul class="catchp-lists">
							   <li>
									<strong><?php esc_html_e( 'Duplicate Page/Post Status', 'catch-duplicate-switcher' ); ?></strong>
									<p><?php esc_html_e( 'Our new WordPress plugin for creating duplicate page/post and switching between them lets you choose the status of your duplicate page/post created.', 'catch-duplicate-switcher' ); ?></p>
								</li>
								<li>
									<strong><?php esc_html_e( 'Duplicate Suffix Name', 'catch-duplicate-switcher' ); ?></strong>
									<p><?php esc_html_e( 'Catch Duplicate/Switcher provides Duplicate Suffix Name option. In the Duplicate Suffix Name section, you can enter a name for your duplicate copies of posts and pages. This helps you in identifying your duplicate pages and posts.  ', 'catch-duplicate-switcher' ); ?></p>
								</li>
								<li>
									<strong><?php esc_html_e( 'Duplicate Page/Post Redirect', 'catch-duplicate-switcher' ); ?></strong>
									<p><?php esc_html_e( 'Duplicate Page/Post Redirect options lets you choose whether you want to redirect to the duplicate page/post created or want the created duplicate post/page to be displayed in the list with the original ones. Select the redirect option ‘to list’ if you want your duplicate pages/posts to be shown in a list with the original ones. And if you want to directly head over to the created duplicate page/post, select the redirect option ‘To Page’.', 'catch-duplicate-switcher' ); ?></p>
								</li>
								<li>
									<strong><?php esc_html_e( 'Switcher Option', 'catch-duplicate-switcher' ); ?></strong>
									<p><?php esc_html_e( 'The Switcher Option can be found in the second tab named ‘Switcher Settings’ in the plugin’s setting page. You have the option to enable the Switcher for page/post. Enabling this switcher will add a new switcher section in the Metabox each time to go to a post or a page. It allows you to switch between the content type—post or page. Switch your post to page or page to post as per your needs and requirements.', 'catch-duplicate-switcher' ); ?></p>
								</li>
								<li>
									<strong><?php esc_html_e( 'Compatible with all WordPress themes', 'catch-duplicate-switcher' ); ?></strong>
									<p><?php esc_html_e( 'Gutenberg Compatibility is one of the major concerns nowadays for every plugin developer. Our new Catch Duplicate/Switcher plugin has been crafted in a way that supports all the WordPress themes. The plugin functions smoothly on any WordPress theme', 'catch-duplicate-switcher', 'catch-duplicate-switcher' ); ?></p>
								</li>
								<li>
									<strong><?php esc_html_e( 'Light Weight', 'catch-duplicate-switcher' ); ?></strong>
									<p><?php esc_html_e( 'Catch Duplicate/Switcher, a simple WordPress plugin to clone pages and posts is extremely lightweight. It means you will not have to worry about your website getting slower because of the plugin.', 'catch-duplicate-switcher' ); ?></p>
								</li>
								<li>
									<strong><?php esc_html_e( 'Responsive Design', 'catch-duplicate-switcher' ); ?></strong>
									<p><?php esc_html_e( 'Our new WordPress plugin comes with a responsive design, therefore, there is no need to strain about the plugin breaking your website.', 'catch-duplicate-switcher' ); ?></p>
								</li>

								<li>
									<strong><?php esc_html_e( 'Incredible Support', 'catch-duplicate-switcher' ); ?></strong>
									<p><?php esc_html_e( 'Catch Duplicate/Switcher comes with Incredible Support. For creating duplicate posts/pages and switching between content types, our plugin documentation answers most questions about using the plugin.  If you’re still having difficulties, you can post it in our Support Forum. All in all, Catch Duplicate/Switcher is a simple yet feature-rich two-in-one plugin that empowers you to clone posts/pages and switch between them. The plugin is extremely easy to use and provides everything you expect from a decent cloning posts/pages WordPress plugin.', 'catch-duplicate-switcher' ); ?></p>
								</li>
							</ul>
						</div><!-- .content -->
					</div><!-- content-wrapper -->
				</div> <!-- Featured -->
			</form><!-- duplicate-page -->
		</div><!-- .catchp_widget_settings -->
		<?php require_once plugin_dir_path( dirname( __FILE__ ) ) . '/partials/sidebar.php'; ?>
	</div><!---catch-content-wrapper---->
<?php require_once plugin_dir_path( dirname( __FILE__ ) ) . '/partials/footer.php'; ?>
</div><!-- .wrap -->
