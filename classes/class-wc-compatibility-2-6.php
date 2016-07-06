<?php
if ( !defined( 'ABSPATH' ) ) exit;

if ( !class_exists( 'Smart_Coupons_WC_Compatibility_2_6' ) ) {

	/**
	 * Class to check for WooCommerce version & return variables accordingly
	 *
	 */
	class Smart_Coupons_WC_Compatibility_2_6 extends Smart_Coupons_WC_Compatibility_2_5 {

		/**
		 * Is WooCommerce Greater Than And Equal To 2.6
		 * 
		 * @return boolean 
		 */
		public static function is_wc_gte_26() {
			return self::is_wc_greater_than( '2.5.5' );
		}

	}

}