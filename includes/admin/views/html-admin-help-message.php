<?php
/**
 * Admin help message.
 *
 * @package WC_BB_Comercio_Eletronico/Admin/Settings
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( apply_filters( 'wc_bb_help_message', true ) ) : ?>
	<div class="updated inline woocommerce-message">
		<p><?php echo esc_html( sprintf( __( 'Help us keep the %s plugin free making a donation or rate %s on WordPress.org. Thank you in advance!', 'wc-bb-comercio-eletronico' ), __( 'Banco do Brasil Com&eacute;rcio Eletr&ocirc;nico for WooCommerce', 'wc-bb-comercio-eletronico' ), '&#9733;&#9733;&#9733;&#9733;&#9733;' ) ); ?></p>
		<p><a href="https://claudiosmweb.com/doacoes/" target="_blank" class="button button-primary"><?php esc_html_e( 'Make a donation', 'wc-bb-comercio-eletronico' ); ?></a> <a href="https://wordpress.org/support/view/plugin-reviews/wc-bb-comercio-eletronico?filter=5#postform" target="_blank" class="button button-secondary"><?php esc_html_e( 'Make a review', 'wc-bb-comercio-eletronico' ); ?></a></p>
	</div>
<?php endif;
