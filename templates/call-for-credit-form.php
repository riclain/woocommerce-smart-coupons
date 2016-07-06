<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>

<br /><br />
<div id="call_for_credit">
	<?php
		$currency_symbol = get_woocommerce_currency_symbol();
	?>
	<p style="float: left">
	<?php
		if( ! empty( $currency_symbol ) ) {
			echo __( stripslashes( $smart_coupon_store_gift_page_text ) ) . ' (' . $currency_symbol . ')';
		} else{
			echo __( stripslashes( $smart_coupon_store_gift_page_text ) );			
		}
		echo '</p>';
		echo "<input id='credit_called' step='any' type='number' min='1' name='credit_called' value='' autocomplete='off' autofocus />";	// This line is required in this template
	?>
	<p id="error_message" style="color: red;"></p>
</div><br />