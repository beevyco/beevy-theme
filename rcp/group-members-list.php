<?php
global $rcp_options;
$group_id = rcpga_group_accounts()->members->get_group_id();

$args     = array(
	'number' => -1,
	'offset' => 0
);

$members  = $member_list = rcpga_group_accounts()->members->get_members( $group_id, $args );

// sort members by role
if ( ! empty( $sort_order ) ) {
	$member_list = array();

	foreach( $sort_order as $role ) {
		foreach( $members as $member ) {
			if ( $role == $member->role ) {
				$member_list[] = $member;
			}
		}
	}

}

if ( ! did_action( 'rcpga_dashboard_notifications' ) ) {
	do_action( 'rcpga_dashboard_notifications' );
}
?>

<h4 class="rcp-header"><?php _e( 'Group Members', 'rcp-group-accounts' ); ?></h4>

<table class="rcp-table" id="rcpga-group-members-list">

	<thead>
	<tr>
		<th><?php _e( 'Name', 'rcp-group-accounts' ); ?></th>
		<th><?php _e( 'Role', 'rcp-group-accounts' ); ?></th>
		<th><?php _e( 'Actions', 'rcp-group-accounts' ); ?></th>
	</tr>
	</thead>

	<tbody>
	<?php if ( empty( $search ) || ( ! empty( $search ) && ! empty( $args['user_id'] ) ) ) : ?>
		<?php foreach ( $member_list as $member ) : ?>

			<?php
			if ( ! $user_data = get_userdata( $member->user_id ) ) {
				continue;
			}
			?>

			<tr>
				<?php do_action( 'rcpga_before_member_data', $user_data ); ?>
				<td class="member-name" data-th="<?php esc_attr_e( 'Name', 'rcp-group-accounts' ); ?>">
					<?php echo $user_data->display_name; ?>
					<?php if ( $user_data->ID === get_current_user_id() ) : ?>
						<em><small>( This is You )</small></em>
					<?php endif; ?>
				</td>
				<td class="member-roll" data-th="<?php esc_attr_e( 'Role', 'rcp-group-accounts' ); ?>"><?php echo esc_html( rcpga_get_member_role_label( $member->role ) ); ?></td>
				<td class="member-actions" data-th="<?php esc_attr_e( 'Actions', 'rcp-group-accounts' ); ?>">
					<?php if ( 'owner' !== $member->role ) : ?>
						<a href="<?php echo esc_url( wp_nonce_url( add_query_arg( array( 'rcpga-action' => 'remove-member', 'rcpga-member' => absint( $member->user_id ) ), $current_page ), 'rcpga_remove_from_group' ) ); ?>"><?php _e( 'Remove from Group', 'rcp-group-accounts' ); ?></a><br />
						<?php if( 'admin' == $member->role ) : ?>
							<a href="<?php echo esc_url( wp_nonce_url( add_query_arg( array( 'rcpga-action' => 'make-member', 'rcpga-member' => absint( $member->user_id ) ), $current_page ), 'rcpga_make_member' ) ); ?>"><?php _e( 'Set as Member', 'rcp-group-accounts' ); ?></a>
						<?php elseif ( 'member' == $member->role ) : ?>
							<a href="<?php echo esc_url( wp_nonce_url( add_query_arg( array( 'rcpga-action' => 'make-admin', 'rcpga-member' => absint( $member->user_id ) ), $current_page ), 'rcpga_make_admin' ) ); ?>"><?php _e( 'Set as Admin', 'rcp-group-accounts' ); ?></a>
						<?php elseif ( 'invited' == $member->role ) : ?>
							<a href="<?php echo esc_url( wp_nonce_url( add_query_arg( array( 'rcpga-action' => 'make-member', 'rcpga-member' => absint( $member->user_id ) ), $current_page ), 'rcpga_make_member' ) ); ?>"><?php _e( 'Set as Member', 'rcp-group-accounts' ); ?></a> | 
							<a href="<?php echo esc_url( wp_nonce_url( add_query_arg( array( 'rcpga-action' => 'resend-invite', 'rcpga-member' => absint( $member->user_id ) ), $current_page ), 'rcpga_resend_invite' ) ); ?>"><?php _e( 'Resend Invite', 'rcp-group-accounts' ); ?></a>
						<?php endif; ?>
					<?php endif; ?>
				</td>
				<?php do_action( 'rcpga_after_member_data', $user_data ); ?>
			</tr>
		<?php endforeach; ?>
	<?php else : ?>
		<tr>
			<td colspan="3"><?php printf( __( 'Member &#8220;%s&#8221; not found. <a href="%s">Clear search.</a>', 'rcp-group-accounts' ), esc_html( $search ), esc_url( remove_query_arg( 'rcpga-search' ) ) ); ?></td>
		</tr>
	<?php endif; ?>
	</tbody>
</table>
<?php