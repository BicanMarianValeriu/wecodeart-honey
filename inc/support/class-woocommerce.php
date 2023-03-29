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
		// Assets
		add_filter( 'woocommerce_enqueue_styles',						'__return_empty_array' );
		add_action( 'wp_enqueue_scripts',								[ $this, 'manage_assets' 			] );

		// Breadcrumbs
		remove_action( 'woocommerce_before_main_content', 				'woocommerce_breadcrumb', 20 );
		add_action( 'woocommerce_single_product_summary', 				'woocommerce_breadcrumb', -10 );


		// Columns
		add_filter( 'woocommerce_output_related_products_args', 		[ $this, 'similar_products_args' 	], 20 );
		add_filter( 'woocommerce_upsell_display_args', 					[ $this, 'similar_products_args' 	], 20 );
		add_filter( 'woocommerce_product_thumbnails_columns', 			[ $this, 'product_thumbnails_columns' ] );
		
		// Custom PRP
		add_action( 'woocommerce_product_options_general_product_data', [ $this, 'product_options_general_product_data' ] );
		add_action( 'woocommerce_process_product_meta', 				[ $this, 'process_product_meta' 		] );
		add_action( 'woocommerce_single_product_summary', 				[ $this, 'manufacturer_price_template'	], 10 );
		add_action( 'woocommerce_variation_options_pricing', 			[ $this, 'variation_options_pricing' 	], 10, 3 );
		add_action( 'woocommerce_save_product_variation', 				[ $this, 'save_product_variation' 		], 10, 2 );
		add_filter( 'woocommerce_available_variation', 					[ $this, 'available_variation' 			] );
		remove_action( 'woocommerce_single_product_summary', 			'woocommerce_template_single_price', 10 );
		add_action( 'woocommerce_single_product_summary', 				'woocommerce_template_single_price', 10 );

		// 1 City/State delivery
		add_filter( 'woocommerce_states', 								[ $this, 'custom_woocommerce_state' ], 	10, 1 );
		add_filter( 'default_checkout_billing_state', 					[ $this, 'change_default_checkout_state' ] );
		add_filter( 'default_checkout_shipping_state', 					[ $this, 'change_default_checkout_state' ] );

		// Fragment Cache
		if ( apply_filters( 'litespeed_esi_status', false ) ) {
			add_action( 'render_block', function( $content, $data ) {
				if( get_prop( $data, [ 'blockName' ] ) === 'woocommerce/mini-cart' ) {
					return apply_filters( 'litespeed_esi_url', 'woo-mini-cart', 'WOO_ESI_BLOCK', [
						'content' 	=> $content,
						'data'		=> $data
					] );
				}

				return $content;
			}, 10, 2 );

			add_action( 'litespeed_esi_load-woo-mini-cart', __CLASS__ . '::load_mini_cart' );
		}
	}

	public static function load_mini_cart( $params ) {
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
		return [
			'RO' => [
				'GJ' => 'Gorj'
			]
		];
	}

	public function change_default_checkout_state() {
		return 'GJ';
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
	 * Similar Products Args
	 *
	 * @since	1.0
	 * @version	1.0
	 *
	 * @return 	string
	 */
	public static function render_viewed_products( $args ) {
		$args = [
			'orderby'		=> 'menu_order',
			'columns'		=> 4,
			'products'		=> [ 1056, 464 ],
			'alignButtons'	=> true,
			'contentVisibility' => [
				'image' => true,
				'title' => true,
				'price' => true,
				'rating' => true,
				'button' => true,
			],
		];

		$template .= '<!-- wp:group {"className":"products-viewed","tagName":"section"} -->';
		$template .= '<section class="wp-block-group products-viewed">';
		$template .= '<!-- wp:heading {"textAlign":"center","level":2,"textColor":"dark","className":"mt-5"} -->';
		$template .= '<h2 class="has-text-align-center mt-5 has-dark-color has-text-color">Produse văzute recent</h2>';
		$template .= '<!-- /wp:heading -->';
		$template .= '<!-- wp:separator {"color":"primary","className":"mb-5 is-style-faded"} -->';
		$template .= '<hr class="wp-block-separator has-text-color has-background has-primary-background-color has-primary-color mb-5 is-style-faded" />';
		$template .= '<!-- /wp:separator -->';
		$template .= '<!-- wp:woocommerce/handpicked-products ' . wp_json_encode( $args ) . ' /-->';
		$template .= '</section>';
		$template .= '<!-- /wp:group -->';

		$blocks = new \WP_Block_List( parse_blocks( $template ), $args );

		$content = '';
		foreach( $blocks as $block ) $content .= $block->render( $block );

		echo $content;
	}
}