<?php
/**
 * Admin View: Notice - Currency not supported.
 *
 * @package WC_BB_Comercio_Eletronico/Admin/Notices
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<div class="error inline">
	<p><strong><?php _e( 'Gateway Disabled', 'wc-bb-comercio-eletronico' ); ?></strong>: <?php printf( __( 'Currency <code>%s</code> is not supported. Works only with Brazilian Real.', 'wc-bb-comercio-eletronico' ), get_woocommerce_currency() ); ?>
	</p>
</div>
