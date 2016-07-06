<?php
/**
 * Welcome Page Class
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


/**
 * SC_Admin_Welcome class
 */
class SC_Admin_Welcome {

	/**
	 * Hook in tabs.
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menus') );
		add_action( 'admin_head', array( $this, 'admin_head' ) );
		add_action( 'admin_init', array( $this, 'sc_welcome' ) );
	}

	/**
	 * Add admin menus/screens.
	 */
	public function admin_menus() {

		if ( empty( $_GET['page'] ) ) {
			return;
		}

		$welcome_page_name  = __( 'About Smart Coupons', WC_Smart_Coupons::$text_domain );
		$welcome_page_title = __( 'Welcome to Smart Coupons', WC_Smart_Coupons::$text_domain );

		switch ( $_GET['page'] ) {
			case 'sc-about' :
				$page = add_dashboard_page( $welcome_page_title, $welcome_page_name, 'manage_options', 'sc-about', array( $this, 'about_screen' ) );
				break;
			case 'sc-faqs' :
			 	$page = add_dashboard_page( $welcome_page_title, $welcome_page_name, 'manage_options', 'sc-faqs', array( $this, 'faqs_screen' ) );
				break;
		}
	}

	/**
	 * Add styles just for this page, and remove dashboard page links.
	 */
	public function admin_head() {
		remove_submenu_page( 'index.php', 'sc-about' );
		remove_submenu_page( 'index.php', 'sc-faqs' );

		?>
		<style type="text/css">
			/*<![CDATA[*/
			.about-wrap h3 {
				margin-top: 1em;
				margin-right: 0em;
				margin-bottom: 0.1em;
				font-size: 1.25em;
				line-height: 1.3em;
			}
			.about-wrap p {
				margin-top: 0.6em;
				margin-bottom: 0.8em;
				line-height: 1.6em;
				font-size: 14px;
			}
			.about-wrap .feature-section {
				padding-bottom: 5px;
			}
			/*]]>*/
		</style>
		<?php
	}

	/**
	 * Intro text/links shown on all about pages.
	 */
	private function intro() {

		if ( is_callable( 'WC_Smart_Coupons::get_smart_coupons_plugin_data' ) ) {
			$plugin_data = WC_Smart_Coupons::get_smart_coupons_plugin_data();
			$version = $plugin_data['Version'];
		} else {
			$version = '';
		}

		?>
		<h1><?php printf( __( 'Welcome to Smart Coupons %s', WC_Smart_Coupons::$text_domain ), $version ); ?></h1>

		<h3><?php _e("Thanks for installing! We hope you enjoy using Smart Coupons.", WC_Smart_Coupons::$text_domain); ?></h3>

		<div class="feature-section col two-col"><br>
			<div class="col-1">
				<p class="woocommerce-actions">
					<a href="<?php echo admin_url('post-new.php?post_type=shop_coupon'); ?>" class="button button-primary"><?php _e( 'Create coupon!', WC_Smart_Coupons::$text_domain ); ?></a>
					<a href="<?php echo admin_url('admin.php?page=wc-settings'); ?>" class="button button-primary" target="_blank"><?php _e( 'Settings', WC_Smart_Coupons::$text_domain ); ?></a>
					<a href="<?php echo esc_url( apply_filters( 'smart_coupons_docs_url', 'http://docs.woothemes.com/document/smart-coupons/', WC_Smart_Coupons::$text_domain ) ); ?>" class="docs button button-primary" target="_blank"><?php _e( 'Docs', WC_Smart_Coupons::$text_domain ); ?></a>
				</p>
			</div>
		</div>

		<h2 class="nav-tab-wrapper">
			<a class="nav-tab <?php if ( $_GET['page'] == 'sc-about' ) echo 'nav-tab-active'; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'sc-about' ), 'index.php' ) ) ); ?>">
				<?php _e( "Know Smart Coupons", WC_Smart_Coupons::$text_domain ); ?>
			</a>
			<a class="nav-tab <?php if ( $_GET['page'] == 'sc-faqs' ) echo 'nav-tab-active'; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'sc-faqs' ), 'index.php' ) ) ); ?>">
				<?php _e( "FAQ's", WC_Smart_Coupons::$text_domain ); ?>
			</a>
		</h2>
		<?php
	}

	/**
	 * Output the about screen.
	 */
	public function about_screen() {
		?>
		<div class="wrap about-wrap">

		<?php $this->intro(); ?>

			<div>
				<div class="feature-section col three-col">
					<div class="col">
						<h4><?php echo __( 'What is Smart Coupons?', WC_Smart_Coupons::$text_domain ); ?></h4>
						<p>
							<?php echo __( 'Smart Coupons is a WooCommerce extension, which adds one more discount type for WooCommerce Coupons. It\'s called as "Store Credit / Gift Certificate".', WC_Smart_Coupons::$text_domain ); ?>
							<?php echo __( 'In addition to this, it adds many functionality in other discount types also, which enable coupons to become an automatic/interactive system.', WC_Smart_Coupons::$text_domain ); ?>
						</p>
					</div>
					<div class="col">
						<h4><?php echo __( 'What is "Store Credit / Gift Certificate"?', WC_Smart_Coupons::$text_domain ); ?></h4>
						<p>
							<?php echo __( 'This is a new discount type added by this plugin in WooCommerce Coupons. A coupon having this discount type can be called as either Smart Coupon or Store Credit or Gift Certificate. This coupon\'s amount can be called as balance.', WC_Smart_Coupons::$text_domain ); ?>
						</p>
					</div>
					<div class="col last-feature">
						<h4><?php echo __( 'What\'s new?', WC_Smart_Coupons::$text_domain ); ?></h4>
						<p>
							<?php echo __( 'Store Credit is a unique discount type, in which coupon\'s amount keeps reducing per usage. It behaves in same way as a credit, which can be used untill its amount becomes zero. Therefore this coupon\'s amount is also refered as balance.', WC_Smart_Coupons::$text_domain ); ?>
						</p>
						<p>
							<?php echo __( 'Since Store Credit\'s balance keeps reducing per usage, this plugin restricts, all automatically created store credit to one user. Additionally, it provides setting to remove the restriction, but you should be aware of what it can cause.', WC_Smart_Coupons::$text_domain ); ?>
						</p>
					</div>
				</div>
				<center><h3><?php echo __( 'What is possible', WC_Smart_Coupons::$text_domain ); ?></h3></center>
				<div class="feature-section col three-col" >
					<div class="col">
						<h4><?php echo __( 'Sell store credit / gift certificate', WC_Smart_Coupons::$text_domain ); ?></h4>
						<p>
							<?php echo sprintf(__( 'Smart Coupons helps you configure product which can be used to sell store credit / gift certificate. You can sell store credit in 3 ways: %s, %s & %s.', WC_Smart_Coupons::$text_domain ), __( 'fixed amount', WC_Smart_Coupons::$text_domain ), '<a href="http://docs.woothemes.com/document/smart-coupons/#section-13" target="_blank">' . __( 'variable but fixed amount', WC_Smart_Coupons::$text_domain ) . '</a>', '<a href="http://docs.woothemes.com/document/smart-coupons/#section-13" target="_blank">' . __( 'any amount', WC_Smart_Coupons::$text_domain ) . '</a>' ); ?>
						</p>
					</div>
					<div class="col">
						<h4><?php echo __( 'Automatically give discounts to your customer for next purchase', WC_Smart_Coupons::$text_domain ); ?></h4>
						<p>
							<?php echo __( 'You can give a coupon to your customer after every purchase, which can encourage them to purchase again from you.', WC_Smart_Coupons::$text_domain ); ?>
						</p>
					</div>
					<div class="col last-feature">
						<h4><?php echo __( 'Bulk create unique coupons & email them', WC_Smart_Coupons::$text_domain ); ?></h4>
						<p>
							<?php echo sprintf(__( 'If you\'ve a list of email addresses of your customer who haven\'t purchase any product from long time, you can send unique coupon to each of them in bulk. %s.', WC_Smart_Coupons::$text_domain ), '<a href="http://docs.woothemes.com/document/smart-coupons/#section-11" target="_blank">' . __( 'See how', WC_Smart_Coupons::$text_domain ) . '</a>' ); ?>
						</p>
					</div>
				</div>
				<div class="feature-section col three-col" >
					<div class="col">
						<h4><?php echo __( 'Import / export coupons', WC_Smart_Coupons::$text_domain ); ?></h4>
						<p>
							<?php echo __( 'You can import / export coupons. This can be helpful when you are moving your store or when you want to move copuns from other store to new one.', WC_Smart_Coupons::$text_domain ); ?>
						</p>
					</div>
					<div class="col">
						<h4><?php echo __( 'Automatic payment for subscription renewals', WC_Smart_Coupons::$text_domain ); ?></h4>
						<p>
							<?php echo __( 'If your store is using WooCommerce subscription and your customer has purchased a subscription using a Store Credit. If that store credit has balance left in it, store will automatically use it for subscription renewals.', WC_Smart_Coupons::$text_domain ); ?>
						</p>
					</div>
					<div class="col last-feature">
						<h4><?php echo __( 'Make your customer\'s coupon usage, easy & simple', WC_Smart_Coupons::$text_domain ); ?></h4>
						<p>
							<?php echo sprintf(__( 'Smart Coupons makes life of your customer really easy by showing valid coupon for your customer (if logged in) on %s, checkout & My Account page. In addition to that those coupons can be applied with single click on it. So, no need to remeber coupon code, no copy-pasting.', WC_Smart_Coupons::$text_domain ), '<a href="http://docs.woothemes.com/document/smart-coupons/#section-16" target="_blank">' . __( 'cart', WC_Smart_Coupons::$text_domain ) . '</a>' ); ?>
						</p>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Output the FAQ's screen.
	 */
	public function faqs_screen() {
		?>
		<div class="wrap about-wrap">

			<?php $this->intro(); ?>

            <h3><?php echo __("FAQ / Common Problems", WC_Smart_Coupons::$text_domain); ?></h3>

            <?php
            	$faqs = array(
            				array(
            						'que' => __( 'Smart Coupon\'s fields are broken?', WC_Smart_Coupons::$text_domain ),
            						'ans' => __( 'Make sure you are using latest version of Smart Coupons. If still the issue persist, deactivate all plugins except WooCommerce & Smart Coupons. Recheck the issue, if the issue still persists, contact us. If the issue goes away, re-activate other plugins one-by-one & re-checking the fields, to find out which plugin is conflicting. Inform us about this issue.', WC_Smart_Coupons::$text_domain )
            					),
            				array(
            						'que' => __( 'How to translate texts from Smart Coupons?', WC_Smart_Coupons::$text_domain ),
            						'ans' => sprintf(__( 'Simplest method is by installing %s plugin. If you want to keep, translated file outside this plugin, refer %s.', WC_Smart_Coupons::$text_domain ), '<a href="https://wordpress.org/plugins/loco-translate/" target="_blank">' . __( 'Loco Translate', WC_Smart_Coupons::$text_domain ) . '</a>', '<a href="http://docs.woothemes.com/document/smart-coupons/#section-19" target="_blank">' . __( 'this article', WC_Smart_Coupons::$text_domain ) . '</a>' )
            					),
            				array(
            						'que' => __( 'Do not want to tie store credit to be used by only one customer?', WC_Smart_Coupons::$text_domain ),
            						'ans' => __( 'You\'ll need to check "Disable Email Restriction" setting (in main coupon which is entered in "Coupons" field of product edit page) under "Usage Restrictions" tab on edit coupon page.', WC_Smart_Coupons::$text_domain )
            					),
            				array(
            						'que' => __( 'Is there any reference file for creating an import file for coupons?', WC_Smart_Coupons::$text_domain ),
            						'ans' => sprintf(__( 'There is one file which is located inside the plugin. The file name is %s. If you want to import coupon through file, the file should be like %s', WC_Smart_Coupons::$text_domain ), '<code>sample.csv</code>', '<code>sample.csv</code>' )
            					),
            				array(
            						'que' => __( 'When trying to add Smart Coupon, I get "Invalid post type" message.', WC_Smart_Coupons::$text_domain ),
            						'ans' => sprintf(__( 'Make sure use of coupon is enabled in your store. You can find this setting %s.', WC_Smart_Coupons::$text_domain ), '<a href="' . admin_url( 'admin.php?page=wc-settings&tab=checkout' ) . '" target="_blank">' . __( 'here', WC_Smart_Coupons::$text_domain ) . '</a>' )
            					),
            				array(
            						'que' => __( 'Is Smart Coupons, WPML compatible?', WC_Smart_Coupons::$text_domain ),
            						'ans' => sprintf(__( 'All texts used in Smart Coupons are translatable & can be translated using %s & %s file. Secondly, the texts from this plugin remain in plugin, it doesn\'t get saved in database, only values are getting saved in database, which can not be translated.', WC_Smart_Coupons::$text_domain ), '<code>.po</code>', '<code>.mo</code>' )
            					),
            				array(
            						'que' => __( 'I\'m using WPML & WPML provides support for multi-currency, but Smart Coupons only changes currency symbol & the price value remains same.', WC_Smart_Coupons::$text_domain ),
            						'ans' => __( 'Currently Smart Coupon is not compatible with multi-currency plugin. You may find this in some future version.', WC_Smart_Coupons::$text_domain )
            					),
            				array(
            						'que' => __( 'How to change texts of email, sent from Smart Coupons?', WC_Smart_Coupons::$text_domain ),
            						'ans' => sprintf(__( 'You can do this by 2 methods, either by changing the texts directly in email template file or overriding email template. %s.', WC_Smart_Coupons::$text_domain ), '<a href="http://docs.woothemes.com/document/smart-coupons/#section-18" target="_blank">' . __( 'How to override email template', WC_Smart_Coupons::$text_domain ) . '</a>' )
            					),
            				array(
            						'que' => __( 'Available coupons are not visible on Cart, Checkout & My Account page?', WC_Smart_Coupons::$text_domain ),
            						'ans' => __( 'Smart Coupons uses hooks of Cart, Checkout & My Account page to display available coupons. If your theme is not using those hooks in cart, checkout & my-account template, coupons will not be displayed.', WC_Smart_Coupons::$text_domain )
            					),
            				array(
            						'que' => __( 'How can I resend gift card coupon bought by customers?', WC_Smart_Coupons::$text_domain ),
            						'ans' => sprintf(__( 'You can resend them from order admin edit page. %s.', WC_Smart_Coupons::$text_domain ), '<a href="http://docs.woothemes.com/document/smart-coupons/#section-15" target="_blank">' . __( 'See how', WC_Smart_Coupons::$text_domain ) . '</a>' )
            					),
            				array(
            						'que' => __( 'Uncheck "Auto-generate" option in Store Credit is not saving? It is always checked?', WC_Smart_Coupons::$text_domain ),
            						'ans' => __( 'Store Credit\'s default behavior is auto-generate because, when using a store credit, its balance keeps reducing. Therefore it should be uniquely created for every user automatically.', WC_Smart_Coupons::$text_domain )
            					),
            				array(
            						'que' => __( 'Smart Coupons is not sending emails?', WC_Smart_Coupons::$text_domain ),
            						'ans' => __( 'Smart Coupons sends email only after order completion. Make sure all settings of coupons, products are in place. Check if order complete email is sending. Also check by switching your theme.', WC_Smart_Coupons::$text_domain )
            					),
            				array(
            						'que' => __( '"Store Credit Receiver detail" form not appearing on checkout page?', WC_Smart_Coupons::$text_domain ),
            						'ans' => __( 'This form is displayed using hook which is available in My Account template. Make sure your theme\'s my-account template contains all hooks required for that template.', WC_Smart_Coupons::$text_domain )
            					),
            				array(
            						'que' => __( 'Is it compatible with WooCommerce Subscription?', WC_Smart_Coupons::$text_domain ),
            						'ans' => __( 'Yes, it does work with WooCommerce Subscription.', WC_Smart_Coupons::$text_domain )
            					),
            				array(
            						'que' => __( 'Does it allow printing of coupon as Gift Card?', WC_Smart_Coupons::$text_domain ),
            						'ans' => __( 'No, it doesn\'t provide any feature which enables you to take a printout of generated coupon, but if you can take printout from your email, you can use it as alternative.', WC_Smart_Coupons::$text_domain )
            					)

            			);

				$faqs = array_chunk( $faqs, 2 );

				echo '<div>';
            	foreach ( $faqs as $fqs ) {
            		echo '<div class="two-col">';
            		foreach ( $fqs as $index => $faq ) {
            			echo '<div' . ( ( $index == 1 ) ? ' class="col last-feature"' : ' class="col"' ) . '>';
            			echo '<h4>' . $faq['que'] . '</h4>';
            			echo '<p>' . $faq['ans'] . '</p>';
            			echo '</div>';
            		}
            		echo '</div>';
            	}
            	echo '</div>';
            ?>

		</div>

		<?php
	}


	/**
	 * Sends user to the welcome page on first activation.
	 */
	public function sc_welcome() {

       	if ( ! get_transient( '_smart_coupons_activation_redirect' ) ) {
			return;
		}

		// Delete the redirect transient
		delete_transient( '_smart_coupons_activation_redirect' );

		wp_redirect( admin_url( 'index.php?page=sc-about' ) );
		exit;

	}
}

new SC_Admin_Welcome();
