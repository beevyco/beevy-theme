<?php
/**
 * Registration Form
 *
 * This template is used to display the registration form with [register_form] If the `id` attribute
 * is passed into the shortcode then register-single.php is used instead.
 * @link http://docs.restrictcontentpro.com/article/1597-registerform
 *
 * For modifying this template, please see: http://docs.restrictcontentpro.com/article/1738-template-files
 *
 * @package     Restrict Content Pro
 * @subpackage  Templates/Register
 * @copyright   Copyright (c) 2017, Restrict Content Pro
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

global $rcp_options, $post, $rcp_levels_db;
$discount = ! empty( $_REQUEST['discount'] ) ? sanitize_text_field( $_REQUEST['discount'] ) : '';
?>

<?php if( ! is_user_logged_in() ) { ?>
	<h3 class="rcp_header">
		<?php echo apply_filters( 'rcp_registration_header_logged_out', __( 'Register New Account', 'rcp' ) ); ?>
	</h3>
<?php } else { ?>
	<h3 class="rcp_header">
		<?php echo apply_filters( 'rcp_registration_header_logged_in', __( 'Upgrade Your Subscription', 'rcp' ) ); ?>
	</h3>
<?php }

// show any error messages after form submission
rcp_show_error_messages( 'register' ); ?>
<script>
	jQuery(document).ready(function($) {
		$('.rcp_level').on( 'change', function() {
			$('.rcp_subscription_level').removeClass( 'selected' );
			$(this).parent().addClass( 'selected' );
		});
	});
</script>
<form id="rcp_registration_form" class="rcp_form" method="POST" action="<?php echo esc_url( rcp_get_current_url() ); ?>">

	<?php if( ! is_user_logged_in() ) { ?>

	<div class="rcp_login_link">
		<p><?php printf( __( '<a href="%s">Log in</a> if you wish to renew an existing subscription.', 'rcp' ), rcp_get_login_url( rcp_get_current_url() ) ); ?></p>
	</div>

	<?php do_action( 'rcp_before_register_form_fields' ); ?>

	<fieldset class="rcp_user_fieldset">
		<legend>Account Information</legend>
		<p id="rcp_user_name_wrap">
			<input placeholder="First Name" name="rcp_user_first" id="rcp_user_first" type="text" <?php if( isset( $_POST['rcp_user_first'] ) ) { echo 'value="' . esc_attr( $_POST['rcp_user_first'] ) . '"'; } ?>/>
			<input placeholder="Last Name" name="rcp_user_last" id="rcp_user_last" type="text" <?php if( isset( $_POST['rcp_user_last'] ) ) { echo 'value="' . esc_attr( $_POST['rcp_user_last'] ) . '"'; } ?>/>
		</p>
		<p id="rcp_user_login_wrap">
			<input placeholder="Username" name="rcp_user_login" id="rcp_user_login" class="required" type="text" <?php if( isset( $_POST['rcp_user_login'] ) ) { echo 'value="' . esc_attr( $_POST['rcp_user_login'] ) . '"'; } ?>/>
		</p>
		<p id="rcp_user_email_wrap">
			<input placeholder="Email Address" name="rcp_user_email" id="rcp_user_email" class="required" type="text" <?php if( isset( $_POST['rcp_user_email'] ) ) { echo 'value="' . esc_attr( $_POST['rcp_user_email'] ) . '"'; } ?>/>
		</p>
		<p id="rcp_password_wrap">
			<input placeholder="Password" name="rcp_user_pass" id="rcp_password" class="required" type="password"/>
		</p>
		<p id="rcp_password_again_wrap">
			<input placeholder="Confirm Password" name="rcp_user_pass_confirm" id="rcp_password_again" class="required" type="password"/>
		</p>

		<?php do_action( 'rcp_after_password_registration_field' ); ?>

	</fieldset>
	<?php } ?>

	<?php do_action( 'rcp_before_subscription_form_fields' ); ?>

	<fieldset class="rcp_subscription_fieldset">
	<?php $levels = rcp_get_subscription_levels( 'active' );
	if( $levels ) : ?>
		<p class="rcp_subscription_message"><?php echo apply_filters ( 'rcp_registration_choose_subscription', __( 'Choose your subscription level', 'rcp' ) ); ?></p>
		<ul id="rcp_subscription_levels">
			<?php foreach( $levels as $key => $level ) : ?>
				<?php if( rcp_show_subscription_level( $level->id ) ) :
					$has_trial = $rcp_levels_db->has_trial( $level->id );
				?>
					<?php $checked = ( ( ! isset( $_GET['level'] ) && $key == 0 ) || ( isset( $_GET['level'] ) && $_GET['level'] == $level->id ) ) ? ' checked="checked"' : ''; ?>
					<li class="rcp_subscription_level rcp_subscription_level_<?php echo $level->id; ?> <?php echo ! empty( $checked ) ? ' selected' : ''; ?>">
					<input type="radio" id="rcp_subscription_level_<?php echo $level->id; ?>" class="required rcp_level"<?php echo $checked; ?> name="rcp_level" rel="<?php echo esc_attr( $level->price ); ?>" value="<?php echo esc_attr( absint( $level->id ) ); ?>" <?php if( $level->duration == 0 ) { echo 'data-duration="forever"'; } if ( ! empty( $has_trial ) ) { echo 'data-has-trial="true"'; } ?>/>
					<label for="rcp_subscription_level_<?php echo $level->id; ?>">
						<span class="rcp_price" rel="<?php echo esc_attr( $level->price ); ?>"><?php echo $level->price > 0 ? rcp_currency_filter( $level->price ) : __( 'free', 'rcp' ); ?></span>
						<span class="rcp_price_sep">/</span>
						<span class="rcp_level_duration_unit"><?php echo rcp_filter_duration_unit( $level->duration_unit, $level->duration ); ?></span>
						<div class="rcp_level_description"> <?php echo rcp_get_subscription_description( $level->id ); ?></div>
					</label>

				</li>
				<?php endif; ?>
			<?php endforeach; ?>
		</ul>
	<?php else : ?>
		<p><strong><?php _e( 'You have not created any subscription levels yet', 'rcp' ); ?></strong></p>
	<?php endif; ?>
	</fieldset>

	<?php if( rcp_has_discounts() ) : ?>
	<fieldset class="rcp_discounts_fieldset">
		<p id="rcp_discount_code_wrap">
			<label for="rcp_discount_code">
				<?php _e( 'Discount Code', 'rcp' ); ?>
				<span class="rcp_discount_valid" style="display: none;"> - <?php _e( 'Valid', 'rcp' ); ?></span>
				<span class="rcp_discount_invalid" style="display: none;"> - <?php _e( 'Invalid', 'rcp' ); ?></span>
			</label>
			<input type="text" id="rcp_discount_code" name="rcp_discount" class="rcp_discount_code" value="<?php echo esc_attr( $discount ); ?>"/>
			<button class="rcp_button" id="rcp_apply_discount"><?php _e( 'Apply', 'rcp' ); ?></button>
		</p>
	</fieldset>
	<?php endif; ?>

	<?php do_action( 'rcp_after_register_form_fields', $levels ); ?>

	<div class="rcp_gateway_fields">
		<?php
		$gateways = rcp_get_enabled_payment_gateways();
		if( count( $gateways ) > 1 ) :
			$display = rcp_has_paid_levels() ? '' : ' style="display: none;"';
			$i = 1;
			?>
			<fieldset class="rcp_gateways_fieldset">
				<legend><?php _e( 'Choose Your Payment Method', 'rcp' ); ?></legend>
				<p id="rcp_payment_gateways"<?php echo $display; ?>>
					<?php foreach( $gateways as $key => $gateway ) :
						$recurring = rcp_gateway_supports( $key, 'recurring' ) ? 'yes' : 'no';
						$trial    = rcp_gateway_supports( $key, 'trial' ) ? 'yes' : 'no'; ?>
						<label for="rcp_gateway_<?php echo esc_attr( $key ); ?>" class="rcp_gateway_option_label">
							<input id="rcp_gateway_<?php echo esc_attr( $key );?>" name="rcp_gateway" type="radio" class="rcp_gateway_option_input" value="<?php echo esc_attr( $key ); ?>" data-supports-recurring="<?php echo esc_attr( $recurring ); ?>" data-supports-trial="<?php echo esc_attr( $trial ); ?>" <?php checked( $i, 1 ); ?>>
							<?php echo esc_html( $gateway ); ?>
						</label>
					<?php
					$i++;
					endforeach; ?>
				</p>
			</fieldset>
		<?php else: ?>
			<?php foreach( $gateways as $key => $gateway ) :
				$recurring = rcp_gateway_supports( $key, 'recurring' ) ? 'yes' : 'no';
				$trial = rcp_gateway_supports( $key, 'trial' ) ? 'yes' : 'no';
				?>
				<input type="hidden" name="rcp_gateway" value="<?php echo esc_attr( $key ); ?>" data-supports-recurring="<?php echo esc_attr( $recurring ); ?>" data-supports-trial="<?php echo esc_attr( $trial ); ?>"/>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>

	<?php do_action( 'rcp_before_registration_submit_field', $levels ); ?>

	<p id="rcp_submit_wrap">
		<input type="hidden" name="rcp_register_nonce" value="<?php echo wp_create_nonce('rcp-register-nonce' ); ?>"/>
		<input type="submit" name="rcp_submit_registration" id="rcp_submit" value="<?php esc_attr_e( apply_filters ( 'rcp_registration_register_button', __( 'Register', 'rcp' ) ) ); ?>"/>
	</p>
</form>
