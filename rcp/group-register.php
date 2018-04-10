<?php

// make sure this user does not already own a group
if ( rcpga_group_accounts()->members->is_group_owner() ) {
	return;
}
?>

<div class="rcpga-group-fields"></div>
