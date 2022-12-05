<?php
/**
 * WeCodeArt Honey 
 *
 * @package 	WeCodeArt Honey 
 * @subpackage 	Support
 * @copyright   Copyright (c) 2021, WeCodeArt Docs
 * @since		1.0.0
 */

namespace WeCodeArt\Honey\Support;

defined( 'ABSPATH' ) || exit();

use WeCodeArt\Singleton;
use function WeCodeArt\Functions\get_prop;

/**
 * WooCommerce
 */
class WooCommerce {

	use Singleton;

	/**
	 * Send Construtor
	 */
	public function init() {
		add_filter( 'woocommerce_enqueue_styles',						'__return_empty_array' );
		add_action( 'wp_enqueue_scripts',								[ $this, 'manage_assets' 			] );

		// Title
		add_filter( 'wecodeart/filter/wrappers/wp-block-post-title', 	[ $this, 'title_wrappers' 			] );

		// Columns
		add_filter( 'woocommerce_output_related_products_args', 		[ $this, 'similar_products_args' 	], 20 );
		add_filter( 'woocommerce_upsell_display_args', 					[ $this, 'similar_products_args' 	], 20 );
		add_filter( 'woocommerce_cross_sells_columns', 					[ $this, 'cross_sells_columns' 		], 20 );
		add_filter( 'woocommerce_product_thumbnails_columns', 			[ $this, 'product_thumbnails_columns' ] );
		
		// Breadcrumbs
		remove_action( 'woocommerce_before_main_content', 	'woocommerce_breadcrumb', 20 );
		add_action( 'woocommerce_single_product_summary', 	'woocommerce_breadcrumb', -10 );

		// Custom PRP
		add_action( 'woocommerce_product_options_general_product_data', [ $this, 'product_options_general_product_data' ] );
		add_action( 'woocommerce_process_product_meta', 				[ $this, 'process_product_meta' 		] );
		remove_action( 'woocommerce_single_product_summary', 			'woocommerce_template_single_price', 10 );
		add_action( 'woocommerce_single_product_summary', 				[ $this, 'manufacturer_price_template'	], 10 );
		add_action( 'woocommerce_single_product_summary', 				'woocommerce_template_single_price', 10 );

		add_action( 'woocommerce_variation_options_pricing', 			[ $this, 'variation_options_pricing' 	], 10, 3 );
		add_action( 'woocommerce_save_product_variation', 				[ $this, 'save_product_variation' 		], 10, 2 );
		add_filter( 'woocommerce_available_variation', 					[ $this, 'available_variation' 			] );

		// 1 City/State delivery
		add_filter( 'default_checkout_billing_state', 					[ $this, 'change_default_checkout_state' ] );
		add_filter( 'default_checkout_shipping_state', 					[ $this, 'change_default_checkout_state' ] );
		add_filter( 'woocommerce_checkout_fields',						[ $this, 'custom_checkout_fields' ],	10, 1 );
		add_filter( 'woocommerce_states', 								[ $this, 'custom_woocommerce_state' ], 	10, 1 );

		// Fragment Cache
		if ( apply_filters( 'litespeed_esi_status', false ) ) {
			add_action( 'render_block', function( $content, $data ) {
				if( get_prop( $data, [ 'blockName' ] ) === 'woocommerce/mini-cart' ) {
					return apply_filters( 'litespeed_esi_url', 'woo_mini_cart', 'WOO_ESI_BLOCK', [
						'content' 	=> $content,
						'data'		=> $data
					] );
				}

				return $content;
			}, 10, 2 );

			add_action( 'litespeed_esi_load-woo_mini_cart', [ __CLASS__, 'load_mini_cart' ] );
		}
	}

	public static function load_mini_cart() {
		echo 'Hello world: ' . rand(1, 10);
		
		// do_action( 'litespeed_control_set_nocache' );
		do_action( 'litespeed_control_set_private', 'woo mini cart' );
		do_action( 'litespeed_vary_no' );
	}

	/**
	 * 1 City/State delivery
	 *
	 * @since	1.0
	 * @version	1.0
	 *
	 * @return 	void
	 */
	public function custom_woocommerce_state( $states ) {
		return array( 'RO' => array( 'GJ' => 'Gorj' ) );
	}

	public function change_default_checkout_state() {
		return 'GJ';
	}

	public function custom_checkout_fields( $fields ) {
		$fields['billing']['billing_city']['custom_attributes']['readonly'] = 'true';
		$fields['billing']['billing_city']['custom_attributes']['value'] = 'Târgu Jiu';
		$fields['shipping']['shipping_city']['custom_attributes']['readonly'] = 'true';
		$fields['shipping']['shipping_city']['custom_attributes']['value'] = 'Târgu Jiu';

		return $fields;
	}

	/**
	 * Variation Data 
	 *
	 * @since	1.0
	 * @version	1.0
	 *
	 * @return 	void
	 */
	public function manufacturer_price_template() { 
		wc_get_template( 'single-product/price-manufacturer.php' );
	}

	/**
	 * Variation Data 
	 *
	 * @since	1.0
	 * @version	1.0
	 *
	 * @return 	void
	 */
	public function variation_options_pricing( $loop, $variation_data, $variation ) { 
		// Number Field
		woocommerce_wp_text_input( [
			'data_type'		=> 'price',
			'wrapper_class'	=> 'form-row',
			'id' 			=> 'price_manufacturer[' . $loop . ']', 
			'label' 		=> sprintf( __( 'Recommended price (%s)', 'woocommerce' ), get_woocommerce_currency_symbol() ), 
			'value' 		=> get_post_meta( $variation->ID, 'price_manufacturer', true ),
			'placeholder' 	=> '', 
			'description'	=> __( 'Enter the price recomended by manufacturer.', 'woocommerce' ),
			'desc_tip' 		=> true,
		] );
	}

	/**
	 * Process Variation Meta
	 *
	 * @since	1.0
	 * @version	1.0
	 *
	 * @return 	void
	 */
	public function save_product_variation( $variation_id, $i ) {
		$product = wc_get_product( $variation_id );
		$product_prp = isset( $_POST['price_manufacturer'][$i] ) ? $_POST['price_manufacturer'][$i] : '';
		$product->update_meta_data( 'price_manufacturer', sanitize_text_field( $product_prp ) );
		$product->save();
	}

	/**
	 * Variation Data 
	 *
	 * @since	1.0
	 * @version	1.0
	 *
	 * @return 	array
	 */
	public function available_variation( $variations ) {

		ob_start();
		wc_get_template( 'single-product/price-manufacturer.php', [
			'product' => wc_get_product( $variations[ 'variation_id' ] )
		] );

		$variations['price_manufacturer'] = ob_get_clean();
		
		return $variations;
	}

	/**
	 * General Product Data 
	 *
	 * @since	1.0
	 * @version	1.0
	 *
	 * @return 	string
	 */
	public function product_options_general_product_data() { 
		// Number Field
		woocommerce_wp_text_input( [
			'data_type'		=> 'price',
			'id' 			=> 'price_manufacturer', 
			'label' 		=> sprintf( __( 'Recommended price (%s)', 'woocommerce' ), get_woocommerce_currency_symbol() ), 
			'placeholder' 	=> '', 
			'description'	=> __( 'Enter the price recommended by manufacturer.', 'woocommerce' ),
			'desc_tip' 		=> true,
		] );
	}

	/**
	 * Process Product Meta
	 *
	 * @since	1.0
	 * @version	1.0
	 *
	 * @return 	string
	 */
	public function process_product_meta( $post_id ) {
		$product = wc_get_product( $post_id );
		$product_prp = isset( $_POST['price_manufacturer']) ? $_POST['price_manufacturer'] : '';
		$product->update_meta_data( 'price_manufacturer', sanitize_text_field( $product_prp ) );
		$product->save();
	}

	/**
	 * Remove Default Styles
	 *
	 * @since	1.0
	 * @version	1.0
	 *
	 * @return 	string
	 */
	public function manage_assets( $args ) {
		wp_dequeue_style( 'wc-blocks-style' );
		wp_dequeue_style( 'select2' );
	}

	/**
	 * Gallery Classes
	 *
	 * @since	1.0
	 * @version	1.0
	 *
	 * @return 	array
	 */
	public function product_thumbnails_columns( $columns ) {
		$columns = 5;

		return $columns;
	}

	/**
	 * Cross sells Columns Args
	 *
	 * @since	1.0
	 * @version	1.0
	 *
	 * @return 	string
	 */
	public function cross_sells_columns( $args ) {
		return 3;
	}

	/**
	 * Similar Products Args
	 *
	 * @since	1.0
	 * @version	1.0
	 *
	 * @return 	string
	 */
	public function similar_products_args( $args ) {
		return wp_parse_args( [
			'posts_per_page' 	=> 4,
			'columns' 			=> 4,
		], $args );
	}

	/**
	 * Title Wrappers
	 *
	 * @since	1.0
	 * @version	1.0
	 *
	 * @return 	string
	 */
	public function title_wrappers( $wrappers ) {
		wecodeart( 'styles' )->Utilities->load( 'overflow-hidden' );

		if( isset( $wrappers[0] ) && isset( $wrappers[0]['attrs'] ) ) {
			$wrappers[0]['attrs']['class'] .= ' overflow-hidden';
		}

		return $wrappers;
	}
}