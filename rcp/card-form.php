<?php
/**
 * Card Form
 *
 * This template is for displaying credit card form details. It's shown on the registration
 * form when selecting a gateway that supports taking credit/debit card details directly.
 *
 * For modifying this template, please see: http://docs.restrictcontentpro.com/article/1738-template-files
 *
 * @package     Restrict Content Pro
 * @subpackage  Templates/Card Form
 * @copyright   Copyright (c) 2017, Restrict Content Pro
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */
?>

<fieldset class="rcp_card_fieldset">
	<legend>Payment Details</legend>
	<p id="rcp_card_number_wrap">
		<p>
			<input placeholder="Card Number" type="text" size="20" maxlength="20" name="rcp_card_number" class="rcp_card_number card-number" />
		</p>

		<p>
			<input placeholder="Name on Card" type="text" size="20" name="rcp_card_name" class="rcp_card_name card-name" />
		</p>

		<p>
			<input placeholder="CVC" type="text" size="4" maxlength="4" name="rcp_card_cvc" class="rcp_card_cvc card-cvc" />
			<input placeholder="Postal Code" type="text" size="4" name="rcp_card_zip" class="rcp_card_zip card-zip" />
		</p>

		<p>
			<select name="rcp_card_exp_month" class="rcp_card_exp_month card-expiry-month">
				<?php for( $i = 1; $i <= 12; $i++ ) : ?>
					<option value="<?php echo $i; ?>"><?php echo $i . ' - ' . rcp_get_month_name( $i ); ?></option>
				<?php endfor; ?>
			</select>
			<span class="rcp_expiry_separator"> / </span>
			<select name="rcp_card_exp_year" class="rcp_card_exp_year card-expiry-year">
				<?php
				$year = date( 'Y' );
				for( $i = $year; $i <= $year + 10; $i++ ) : ?>
					<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
				<?php endfor; ?>
			</select>
		</p>
	</p>
</fieldset>