<?php

// Move the site creation form fields
remove_action( 'rcp_after_register_form_fields', 'rcp_site_creation_registration_fields', 100 );
function beevy_site_creation_registration_fields() {
	ob_start();

	if( ! is_user_logged_in() || ! rcp_site_creation_get_user_blog( get_current_user_id() ) ) {
		$settings = get_option( 'rcp_site_creation_settings' );
		?>

			<legend>Store Information</legend>
			<p id="rcp_site_creation_url_wrap">
				<label for="rcp_site_creation_url">Store URL</label>
				<input placeholder="yourstore.beevy.co" id="rcp_site_creation_url" name="rcp_site_creation_url" type="text" value="<?php echo ( isset( $_POST['rcp_site_creation_url'] ) ? $_POST['rcp_site_creation_url'] : '' ); ?>" /><br />
				<span class="rcp_site_creation_url_preview_wrap" style="display: none"><span class="rcp_site_creation_url_preview_label"><?php _e( 'Preview:', 'rcp-site-creation' ); ?></span>&nbsp;<code><span class="rcp_site_creation_url_preview_subdomain"></span></code></span>
			</p>

			<p id="rcp_site_creation_name_wrap">
				<label for="rcp_site_creation_name">Store Name</label>
				<input placeholder="My Amazing Store" id="rcp_site_creation_name" name="rcp_site_creation_name" type="text" value="<?php echo ( isset( $_POST['rcp_site_creation_name'] ) ? $_POST['rcp_site_creation_name'] : '' ); ?>" />
			</p>

			<p id="rcp_site_creation_desc_wrap">
				<label for="rcp_site_creation_desc">Store Description</label>
				<input placeholder="Welcome to My Amazing Store" id="rcp_site_creation_desc" name="rcp_site_creation_desc" type="text" value="<?php echo ( isset( $_POST['rcp_site_creation_desc'] ) ? $_POST['rcp_site_creation_desc'] : '' ); ?>" />
			</p>
		<?php
	}

	echo ob_get_clean();
}
add_action( 'rcp_after_password_registration_field', 'beevy_site_creation_registration_fields', 10 );


/**
 * Add the invite code field to the registration form
 *
 * @since       1.0
 * @return      void
 */
remove_action( 'rcp_after_password_registration_field', 'rcp_invite_codes_registration_fields', 100 );
function beevy_invite_codes_registration_fields() {
	global $rcp_options;
	ob_start();

	if( ! empty( $rcp_options['require_invites'] ) ) {
		?>
		<p id="rcp_invite_code_wrap">
			<input placeholder="Invite Code" id="rcp_invite_code" name="rcp_invite_code" type="text" value="<?php echo ( isset( $_REQUEST['invite'] ) ? $_REQUEST['invite'] : '' ); ?>" /><br />
		</p>
		<?php
	}

	echo ob_get_clean();
}
add_action( 'rcp_after_password_registration_field', 'beevy_invite_codes_registration_fields', 1 );

/**
 * Require first and last names during registration
 *
 * @param array $posted Array of information sent to the form.
 *
 * @return void
 */
function beevy_require_first_and_last_names( $posted ) {
	if( is_user_logged_in() ) {
		return;
	}

	if ( empty( $posted['rcp_user_first'] ) ) {
		rcp_errors()->add( 'first_name_required', __( 'Please enter your first name', 'rcp' ), 'register'  );
	}
	if ( empty( $posted['rcp_user_last'] ) ) {
		rcp_errors()->add( 'last_name_required', __( 'Please enter your last name', 'rcp' ), 'register'  );
	}
}
add_action( 'rcp_form_errors', 'beevy_require_first_and_last_names' );

function beevy_setup_woocommerce_defaults( $site_meta, $blog_id, $user_id ) {
	switch_to_blog( $blog_id );

	update_option( 'woocommerce_enable_guest_checkout', 'no' );
	update_option( 'woocommerce_force_ssl_checkout',    'yes' );
	update_option( 'woocommerce_unforce_ssl_checkout',  'no' );
	update_option( 'woocommerce_enable_reviews',        'no' );

	restore_current_blog();
}
add_action( 'rcp_site_creation_site_created', 'beevy_setup_woocommerce_defaults', 10, 3 );