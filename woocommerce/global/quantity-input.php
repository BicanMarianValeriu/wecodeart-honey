<?php
/**
 * Product quantity inputs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/quantity-input.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.0.0
 */

defined( 'ABSPATH' ) || exit;

wecodeart( 'styles' )->Utilities->load( [ 'd-none' ] );

if ( $max_value && $min_value === $max_value ) {
	?>
	<div class="quantity hidden d-none">
		<input type="hidden" id="<?php echo esc_attr( $input_id ); ?>" class="qty" name="<?php echo esc_attr( $input_name ); ?>" value="<?php echo esc_attr( $min_value ); ?>" />
	</div>
	<?php
} else {
	/* translators: %s: Quantity. */
	$label = ! empty( $args['product_name'] ) ? sprintf( esc_html__( '%s quantity', 'woocommerce' ), wp_strip_all_tags( $args['product_name'] ) ) : esc_html__( 'Quantity', 'woocommerce' );
	?>
	<div class="quantity">
		<?php do_action( 'woocommerce_before_quantity_input_field' ); ?>
		<label class="screen-reader-text" for="<?php echo esc_attr( $input_id ); ?>"><?php echo esc_attr( $label ); ?></label>
		<?php
		
		$classes[] = 'form-control';
		$classes[] = 'quantity__qty';

		wecodeart_input( 'button', [
			'label' => '-',
            'attrs' => [
				'type'		=> 'button',
                'value'     => '-',
                'class'     => 'quantity__minus',
            ]
		] );
		
		wecodeart_input( 'number', [
            'attrs' => [
                'id'        => $input_id,
                'name'      => $input_name,
                'value'     => $input_value,
                'class'     => join( ' ', (array) $classes ),
				'size'		=> 4,
				'step'		=> $step,
				'min'		=> $min_value,
				'max'		=> 0 < $max_value ? $max_value : '',
				'placeholder' 	=> $placeholder,
				'inputmode'		=> $inputmode,
				'autocomplete'	=> isset( $autocomplete ) ? $autocomplete : 'on'
            ]
		] );

		wecodeart_input( 'button', [
			'label' => '+',
            'attrs' => [
				'type'		=> 'button',
                'value'     => '+',
                'class'     => 'quantity__plus',
            ]
		] );
		
		?>
		<?php do_action( 'woocommerce_after_quantity_input_field' ); ?>
	</div>
	<?php
}