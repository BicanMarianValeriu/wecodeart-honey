<?php
/**
 * WeCodeArt Docs.
 *
 * @package 	WeCodeArt Docs
 * @subpackage 	Global/Stats
 * @copyright   Copyright (c) 2021, WeCodeArt Docs
 * @since 		1.0.0
 * @version		1.0.0
 */

defined( 'ABSPATH' ) || exit();

wecodeart( 'styles' )->Utilities->load( [
	'border-3',
    'rounded-pill',
    'fw-700',
    'mb-3',
    'mb-sm-0',
	'd-block',
	'd-sm-inline-block'
] );

/**
 * @param   array  $button		Button
 * @param   array  $link		Link
 * ....
 */

?>
<div class="wecodeart-stats">
	<a class="btn btn-outline-light btn-lg border-3 rounded-pill fw-700 mb-3 mb-sm-0"
		<?php if( trim( $button['tooltip'] ) !== '' ) : ?>
		data-bs-toggle="tooltip"
		data-bs-placement="top"
		data-bs-html="true"
		title="<?php echo esc_attr( $button['tooltip'] ); ?>"
		<?php endif; ?>
		target="_blank"
		href="<?php echo esc_url( $button['link'] ); ?>">
		<i class="fas fa-download"></i>
		<span><?php echo wp_kses_post( $button['label'] ); ?></span>
	</a>
	<?php if( is_array( $link ) ) : ?>
	<span class="d-block d-sm-inline-block has-white-color"> 
		<span class="mx-1"><?php esc_html_e( 'or', 'wecodeart-docs' ); ?></span> 
		<a class="has-white-color" href="<?php echo esc_url( $link['link'] ); ?>">
			<strong><?php echo esc_html( $link['label'] ); ?></strong>
		</a>
	</span>
	<?php endif; ?>
</div>