<?php
/**
 * Plugin Name: Banco do Brasil Comércio Eletrônico for WooCommerce
 * Plugin URI:  https://github.com/claudiosanches/wc-bb-comercio-eletronico
 * Description: Adds Banco do Brasil Comércio Eletrônico payment methods to your WooCommerce store.
 * Author:      Claudio Sanches
 * Author URI:  https://claudiosmweb.com
 * Version:     0.0.1
 * License:     GPLv2 or later
 * Text Domain: wc-bb-comercio-eletronico
 * Domain Path: /languages
 *
 * Banco do Brasil Comércio Eletrônico for WooCommerce is free software:
 * you can redistribute it and/or modify it under the terms of
 * the GNU General Public License as published by the Free Software Foundation,
 * either version 2 of the License, or any later version.
 *
 * Banco do Brasil Comércio Eletrônico for WooCommerce is distributed
 * in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even
 * the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Banco do Brasil Comércio Eletrônico for WooCommerce. If not, see
 * <https://www.gnu.org/licenses/gpl-2.0.txt>.
 *
 * @package WC_BB_Comercio_Eletronico
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WC_BB_Comercio_Eletronico' ) ) :

	/**
	 * Banco do Brasil Comércio Eletrônico for WooCommerce main class.
	 */
	class WC_BB_Comercio_Eletronico {

		/**
		 * Plugin version.
		 *
		 * @var string
		 */
		const VERSION = '0.0.1';

		/**
		 * Instance of this class.
		 *
		 * @var object
		 */
		protected static $instance = null;

		/**
		 * Initialize the plugin actions.
		 */
		public function __construct() {
			// Load plugin text domain.
			add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

			// Checks with WooCommerce and WooCommerce is installed.
			if ( class_exists( 'WC_Payment_Gateway' ) && class_exists( 'Extra_Checkout_Fields_For_Brazil' ) && defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '2.6', '>=' ) ) {
				$this->includes();

				add_filter( 'woocommerce_payment_gateways', array( $this, 'add_gateway' ) );
				add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'plugin_action_links' ) );
			} else {
				add_action( 'admin_notices', array( $this, 'dependencies_notices' ) );
			}
		}

		/**
		 * Return an instance of this class.
		 *
		 * @return object A single instance of this class.
		 */
		public static function get_instance() {
			// If the single instance hasn't been set, set it now.
			if ( null === self::$instance ) {
				self::$instance = new self;
			}

			return self::$instance;
		}

		/**
		 * Load the plugin text domain for translation.
		 */
		public function load_plugin_textdomain() {
			load_plugin_textdomain( 'wc-bb-comercio-eletronico', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
		}

		/**
		 * Includes.
		 */
		private function includes() {
			include_once dirname( __FILE__ ) . '/includes/wc-bb-functions.php';
			include_once dirname( __FILE__ ) . '/includes/wc-class-bb-api.php';
			include_once dirname( __FILE__ ) . '/includes/wc-class-bb-bank-slip-gateway.php';
			include_once dirname( __FILE__ ) . '/includes/wc-class-bb-my-account.php';
		}

		/**
		 * Get templates path.
		 *
		 * @return string
		 */
		public static function get_templates_path() {
			return plugin_dir_path( __FILE__ ) . 'templates/';
		}

		/**
		 * Add the gateway to WooCommerce.
		 *
		 * @param  array $methods Payment methods list.
		 *
		 * @return array          New payment methods.
		 */
		public function add_gateway( $methods ) {
			$methods[] = 'WC_BB_Bank_Slip_Gateway';

			return $methods;
		}

		/**
		 * Dependencies notices.
		 */
		public function dependencies_notices() {
			if ( ! defined( 'WC_VERSION' ) || defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '2.6', '<=' ) ) {
				include_once dirname( __FILE__ ) . '/includes/admin/views/html-notice-woocommerce-missing.php';
			}

			if ( ! class_exists( 'Extra_Checkout_Fields_For_Brazil' ) ) {
				include_once dirname( __FILE__ ) . '/includes/admin/views/html-notice-missing-ecfb.php';
			}
		}

		/**
		 * Action links.
		 *
		 * @param  array $links Plugin links.
		 *
		 * @return array
		 */
		public function plugin_action_links( $links ) {
			$plugin_links   = array();
			$plugin_links[] = '<a href="' . esc_url( admin_url( 'admin.php?page=wc-settings&tab=checkout&section=bb-bank-slip' ) ) . '">' . __( 'Bank Slip Settings', 'wc-bb-comercio-eletronico' ) . '</a>';

			return array_merge( $plugin_links, $links );
		}
	}

	add_action( 'plugins_loaded', array( 'WC_BB_Comercio_Eletronico', 'get_instance' ) );

endif;
