<?php
/** Duplicate Section */
?>

<div id="catch-duplicate-switcher">
	<div class="content-wrapper">
		<div class="header">
			<h2><?php esc_html_e( 'Settings', 'catch-duplicate-switcher' ); ?></h2>
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
									
								<th scope="row"><?php esc_html_e( 'Duplicate Page/Post Status', 'catch-duplicate-switcher' ); ?></th>

								<td>
									<select id="catch_duplicate_switcher_options[duplicate_status]" name="catch_duplicate_switcher_options[duplicate_status]" class="duplicate_status">
											<option value="draft" <?php selected( $settings['duplicate_status'], 'draft' ); ?>><?php esc_html_e( 'Draft', 'catch-duplicate-switcher'); ?></option>
											<option value="publish" <?php selected( $settings['duplicate_status'], 'publish' ); ?>><?php esc_html_e( 'Publish', 'catch-duplicate-switcher'); ?></option>
											<option value="private" <?php selected( $settings['duplicate_status'], 'private' ); ?>><?php esc_html_e( 'Private', 'catch-duplicate-switcher'); ?></option>
											<option value="pending" <?php selected( $settings['duplicate_status'], 'pending' ); ?>><?php esc_html_e( 'Pending', 'catch-duplicate-switcher'); ?></option>
									 </select>
								</td>
							    </tr>

								<tr>
									<th>
										<label><?php esc_html_e( 'Duplicate Suffix Name', 'catch-duplicate-switcher' ); ?></label>
									</th>
									<td>
										<input type="text" name="catch_duplicate_switcher_options[duplicate_suffix_name]" id="duplicate-suffix-name" class="duplicate-suffix-name"  value="<?php echo esc_attr( $settings['duplicate_suffix_name'] ); ?>"/>
										<span class="dashicons dashicons-info tooltip" title="<?php esc_html_e( 'Enter the duplicate page or post suffix name.', 'catch-duplicate-switcher' ); ?>"></span>
									</td>
								</tr>
								
								<tr>
									
								<th scope="row"><?php esc_html_e( 'Duplicate Page/Post Redirect', 'catch-duplicate-switcher' ); ?></th>

								<td>
									<select id="catch_duplicate_switcher_options[duplicate_page_redirect]" name="catch_duplicate_switcher_options[duplicate_page_redirect]" class="duplicate_page_redirect">
											<option value="to_list" <?php selected( $settings['duplicate_page_redirect'], 'to_list' ); ?>><?php esc_html_e( 'To List', 'catch-duplicate-switcher'); ?></option>
											<option value="to_page" <?php selected( $settings['duplicate_page_redirect'], 'to_page' ); ?>><?php esc_html_e( 'To Page', 'catch-duplicate-switcher'); ?></option>
											
									 </select>
									 <span class="dashicons dashicons-info tooltip" title="<?php esc_html_e( 'duplicate post/page redirect to_page.', 'catch-duplicate-switcher' ); ?>"></span>

								</td>
							    </tr>

								<tr>
                                    <th scope="row"><?php esc_html_e( 'Reset Options', 'catch-duplicate-switcher' ); ?></th>
                                    <td>
                                        <?php
                                            echo '<input name="catch_duplicate_switcher_options[reset]" id="catch_duplicate_switcher_options[reset]" type="checkbox" value="1" class="catch_duplicate_switcher_options[reset]" />' . esc_html__( 'Check to reset', 'catch-duplicate-switcher' );
                                        ?>
                                        <span class="dashicons dashicons-info tooltip" title="<?php esc_html_e( 'Caution: Reset all settings to default.', 'catch-duplicate-switcher' ); ?>"></span>
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
