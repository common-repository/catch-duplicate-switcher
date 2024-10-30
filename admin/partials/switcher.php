<?php
/** Switcher Section */
?>

<div id="catch-duplicate-switcher">
	<div class="content-wrapper">
		<div class="header">
			<h2><?php esc_html_e( ' Switcher Settings', 'catch-duplicate-switcher' ); ?></h2>
		</div> <!-- .Header -->
		<div class="content">
			<div id="sticky_main">
				
					<?php settings_fields( 'catch-duplicate-switcher-group' ); ?>
					<?php
					$defaults =catch_duplicate_switcher_default_options();
					$settings = catch_duplicate_switcher_get_options();

					?>
					<div class="option-container">
			  			<table class="form-table" bgcolor="white">
							<tbody>
								<tr>
								<th scope="row"><?php esc_html_e( 'Enable Switcher for page/post', 'catch-duplicate-switcher' ); ?></th>
								<td>
									<input name="catch_duplicate_switcher_options[switcher_status]" id="catch_duplicate_switcher_options[switcher_status]" type="checkbox" value="1" <?php echo checked( $settings['switcher_status'], 1 ); ?>/>
									<span class="dashicons dashicons-info tooltip" title="<?php esc_html_e( 'Enable the Switcher ', 'catch-duplicate-switcher' ); ?>"></span>
								</td>
							</tr>
						</tbody>
						</table>
						<?php submit_button( esc_html__( 'Save Changes', 'catch-duplicate-switcher' ) ); ?>
					</div><!-- .option-container -->
			</div><!-- sticky_main -->
		</div><!-- .content -->
	</div><!-- .content-wrapper -->
</div><!---catch-duplicate-switcher-->
