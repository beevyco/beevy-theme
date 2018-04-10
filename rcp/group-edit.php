<?php
global $rcp_options;
$group_id = rcpga_group_accounts()->members->get_group_id();

if ( ! did_action( 'rcpga_dashboard_notifications' ) ) {
	do_action( 'rcpga_dashboard_notifications' );
}
?>

<h4 class="rcp-header"><?php _e( 'Group Settings', 'rcp-group-accounts' ); ?></h4>

<form method="post" id="rcpga-group-edit-form" class="rcp_form">

	<fieldset>
		<p id="rcpga-group-name-wrap">
			<label for="rcpga-group-name"><?php _e( 'Group Name', 'rcp-group-accounts' ); ?></label>
			<input type="text" name="rcpga-group-name" id="rcpga-group-name" placeholder="<?php _e( 'Group Name', 'rcp-group-accounts' ); ?>" value="<?php echo esc_attr( rcpga_group_accounts()->groups->get_name( $group_id ) ); ?>" autocomplete="off" />
		</p>

		<p class="rcp_submit_wrap">
			<input type="hidden" name="rcpga-group" value="<?php echo absint( $group_id ); ?>" />
			<input type="hidden" name="rcpga-action" value="edit-group" />
			<input type="submit" value="<?php _e( 'Update Group', 'rcp-group-accounts' ); ?>" />
		</p>
	</fieldset>

</form>