<?php
/**
 * Offline e-wallet gateway (Vodafone Cash / InstaPay / other).
 * Customer sends the amount to the configured wallet number; order is placed "on hold"
 * until the shop owner confirms the transfer.
 *
 * @package hala
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'WC_Payment_Gateway' ) ) {
	return;
}

class WC_Gateway_Hala_Ewallet extends WC_Payment_Gateway {

	public function __construct() {
		$this->id                 = 'hala_ewallet';
		$this->icon               = '';
		$this->has_fields         = false;
		$this->method_title       = 'E-wallet (Vodafone Cash / InstaPay)';
		$this->method_description = 'Customers transfer the total to your wallet number and you confirm the order manually. Order status: On hold.';
		$this->supports           = array( 'products' );

		$this->init_form_fields();
		$this->init_settings();

		$this->enabled = $this->get_option( 'enabled' );
		$this->title   = $this->get_option( 'title' );

		add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );
		add_action( 'woocommerce_thankyou_' . $this->id, array( $this, 'thankyou_page' ) );
		add_action( 'woocommerce_email_before_order_table', array( $this, 'email_instructions' ), 10, 3 );
	}

	public function init_form_fields() {
		$this->form_fields = array(
			'enabled'       => array( 'title' => 'Enable', 'type' => 'checkbox', 'label' => 'Enable e-wallet payments', 'default' => 'yes' ),
			'title'         => array( 'title' => 'Title (leave empty for the built-in bilingual title)', 'type' => 'text', 'default' => '' ),
			'wallet_number' => array( 'title' => 'Wallet number', 'type' => 'text', 'default' => '', 'description' => 'Shown to the customer at checkout and on the thank-you page.' ),
			'providers'     => array( 'title' => 'Wallet / app names', 'type' => 'text', 'default' => 'Vodafone Cash / InstaPay' ),
			'instructions'  => array( 'title' => 'Instructions (leave empty for the built-in bilingual text)', 'type' => 'textarea', 'default' => '', 'description' => 'Shown at checkout, on the thank-you page and in the order email.' ),
		);
	}

	public function get_title() {
		$t = $this->get_option( 'title' );
		$t = $t ? $t : hala_s( 'Pay with an e-wallet (Vodafone Cash / InstaPay)' );
		return apply_filters( 'woocommerce_gateway_title', $t, $this->id );
	}

	public function get_description() {
		return $this->instructions_text();
	}

	/** Instruction text including the wallet number. */
	private function instructions_text(): string {
		$custom = trim( (string) $this->get_option( 'instructions' ) );
		$number = trim( (string) $this->get_option( 'wallet_number' ) );
		$prov   = trim( (string) $this->get_option( 'providers' ) );
		$text   = $custom ? $custom : hala_s( 'Transfer the order total to the wallet number below, then keep the transfer receipt. We will confirm your order once the payment is received.' );
		if ( $number ) {
			$text .= "\n" . ( $prov ? $prov . ': ' : '' ) . $number;
		}
		return $text;
	}

	public function payment_fields() {
		echo wp_kses_post( wpautop( wptexturize( $this->instructions_text() ) ) );
	}

	public function process_payment( $order_id ) {
		$order = wc_get_order( $order_id );
		$order->update_status( 'on-hold', hala_s( 'Awaiting e-wallet transfer.' ) );
		wc_reduce_stock_levels( $order_id );
		WC()->cart->empty_cart();
		return array( 'result' => 'success', 'redirect' => $this->get_return_url( $order ) );
	}

	public function thankyou_page() {
		echo '<div class="notice woocommerce-info">' . wp_kses_post( wpautop( wptexturize( $this->instructions_text() ) ) ) . '</div>';
	}

	public function email_instructions( $order, $sent_to_admin, $plain_text = false ) {
		if ( $sent_to_admin || ! $order->has_status( 'on-hold' ) || $this->id !== $order->get_payment_method() ) {
			return;
		}
		echo wp_kses_post( wpautop( wptexturize( $this->instructions_text() ) ) ) . PHP_EOL;
	}
}
