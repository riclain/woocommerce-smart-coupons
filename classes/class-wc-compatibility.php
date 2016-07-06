<?php
if ( !defined( 'ABSPATH' ) ) exit;

if ( !class_exists( 'Smart_Coupons_WC_Compatibility' ) ) {
	
	/**
	 * Class to check for WooCommerce version & return variables accordingly
	 *
	 */
	class Smart_Coupons_WC_Compatibility {

		/**
		 * Global WooCommerce Instance
		 * 
		 * @return global woocommerce object
		 */
		public static function global_wc() {
			if ( self::is_wc_22() || self::is_wc_21() ) {
				return WC();
			} else {
				global $woocommerce;
				return $woocommerce;
			}
		}

		/**
		 * Get WooCommerce Product Instance
		 * 
		 * @param mixed $the_product
		 * @param array $args
		 * @return WC_Product $product
		 */
		public static function get_product( $the_product = false, $args = array() ) {

			if ( self::is_wc_22() ) {
				return wc_get_product( $the_product, $args );
			} elseif ( self::is_wc_21() ) {
				return get_product( $the_product, $args );
			} else {
				return new WC_Product( $the_product );
			}

		}

		/**
		 * Formatted Product Name
		 * 
		 * @param mixed $the_product
		 * @return string $product_name
		 */
		public static function get_formatted_product_name( $the_product = false ) {

			if ( self::is_wc_22() || self::is_wc_21() ) {
				return $the_product->get_formatted_name();
			} else {
				return woocommerce_get_formatted_product_name( $the_product );
			}

		}

		/**
		 * Get WooCommerce Order Instance
		 * 
		 * @param mixed $the_order
		 * @return WC_Order $order
		 */
		public static function get_order( $the_order = false ) {

			if ( self::is_wc_22() ) {
				return wc_get_order( $the_order );
			} else {

				global $post;

				if ( false === $the_order ) {
					$order_id = $post->ID;
				} elseif ( $the_order instanceof WP_Post ) {
					$order_id = $the_order->ID;
				} elseif ( is_numeric( $the_order ) ) {
					$order_id = $the_order;
				}

				return new WC_Order( $order_id );

			}

		}

		/**
		 * Print JavaScript code
		 * 
		 * @param string $js
		 */
		public static function enqueue_js( $js = false ) {

			if ( self:: is_wc_22() || self::is_wc_21() ) {
				wc_enqueue_js( $js );
			} else {
				global $woocommerce;
				$woocommerce->add_inline_js( $js );
			}

		}

		/**
		 * Is WooCommerce 2.1
		 * 
		 * @return boolean 
		 */
		public static function is_wc_21() {
			return ( self::is_wc_greater_than( '2.0.20' ) && !self::is_wc_22() );
		}

		/**
		 * Is WooCommerce 2.2 
		 * 
		 * @return boolean
		 */
		public static function is_wc_22() {
			return self::is_wc_greater_than( '2.1.12' );
		}

		/**
		 * WooCommerce Price with Currency Symbol
		 * 
		 * @param float $price
		 * @param array $args
		 * @return string $price with currency symbol
		 */
		public static function wc_price( $price, $args = array() ) {
			if ( self::is_wc_greater_than( '2.0.20' ) ) {
				return wc_price( $price, $args );
			} else {
				return woocommerce_price( $price, $args );
			}
		}

		/**
		 * WooCommerce Current WooCommerce Version
		 * 
		 * @return string woocommerce version
		 */
		public static function get_wc_version() {
			if (defined('WC_VERSION') && WC_VERSION)
				return WC_VERSION;
			if (defined('WOOCOMMERCE_VERSION') && WOOCOMMERCE_VERSION)
				return WOOCOMMERCE_VERSION;
			return null;
		}

		/**
		 * Compare passed version with woocommerce current version
		 * 
		 * @param string $version
		 * @return boolean
		 */
		public static function is_wc_greater_than( $version ) {
			return version_compare( self::get_wc_version(), $version, '>' );
		}

	}
}