<?php
/**
 * My Account actions.
 *
 * @package WC_BB_Comercio_Eletronico/Classes/My_Account
 * @since   1.0.0
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WC_BB_My_Account class.
 */
class WC_BB_My_Account {

	/**
	 * Initialize my account actions.
	 */
	public function __construct() {
		add_filter( 'woocommerce_my_account_my_orders_actions', array( $this, 'order_actions' ), 10, 2 );
	}

	/**
	 * Include custom order actions.
	 *
	 * @param array    $actions Actions.
	 * @param WC_Order $order   Order data.
	 *
	 * @return array
	 */
	public function order_actions( $actions, $order ) {
		if ( 'bb-bank-slip' !== _wc_bb_get_order_meta( $order, 'payment_method' ) ) {
			return $actions;
		}

		if ( ! in_array( $order->get_status(), array( 'pending', 'on-hold' ), true ) ) {
			return $actions;
		}

		$actions[] = array(
			'url'  => wc_bb_get_bank_slip_url( _wc_bb_get_order_meta( $order, 'order_key' ) ),
			'name' => __( 'Print bank slip', 'wc-bb-comercio-eletronico' ),
		);

		return $actions;
	}
}

new WC_BB_My_Account();
