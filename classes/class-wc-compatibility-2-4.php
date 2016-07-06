<?php
if ( !defined( 'ABSPATH' ) ) exit;

if ( !class_exists( 'Smart_Coupons_WC_Compatibility_2_4' ) ) {
	
	/**
	 * Class to check for WooCommerce version & return variables accordingly
	 *
	 */
	class Smart_Coupons_WC_Compatibility_2_4 extends Smart_Coupons_WC_Compatibility_2_3 {

		/**
		 * Is WooCommerce Greater Than And Equal To 2.4
		 * 
		 * @return boolean 
		 */
		public static function is_wc_gte_24() {
			return self::is_wc_greater_than( '2.3.13' );
		}

	}

}