<?php
/**
 * Title: Latest Products
 * Slug: wecodeart/latest-products
 * Categories: wecodeart-honey, wecodeart-query
 */
?>
<!-- wp:group {"className":"py-5","layout":{"inherit":true}} -->
<div class="wp-block-group py-5">
    <!-- wp:heading {"textAlign":"center","level":4,"textColor":"primary","className":"mb-0"} -->
    <h4 class="has-text-align-center mb-0 has-primary-color has-text-color" id="our-shop"><?php esc_html_e( 'Latest', 'wecodeart-honey' ); ?></h4>
    <!-- /wp:heading -->
    <!-- wp:heading {"textAlign":"center","style":{"spacing":{"margin":{"top":"0"}}},"textColor":"dark","className":"h1"} -->
    <h2 class="wp-block-heading has-text-align-center h1 has-dark-color has-text-color" id="latest-products" style="margin-top:0"><?php esc_html_e( 'Sweets', 'wecodeart-honey' ); ?></h2>
    <!-- /wp:heading -->
    <!-- wp:separator {"backgroundColor":"primary","className":"is-style-dots"} -->
    <hr class="wp-block-separator has-text-color has-primary-color has-alpha-channel-opacity has-primary-background-color has-background is-style-dots" />
    <!-- /wp:separator -->
    <!-- wp:woocommerce/product-collection {"queryId":1,"query":{"woocommerceAttributes":[],"woocommerceStockStatus":["instock","outofstock","onbackorder"],"taxQuery":{},"isProductCollectionBlock":true,"perPage":"4","pages":"0","offset":0,"postType":"product","order":"desc","orderBy":"popularity","author":"","search":"","exclude":[],"sticky":"","inherit":false},"tagName":"div","displayLayout":{"type":"flex","columns":4},"layout":{"type":"default"}} -->
    <div class="wp-block-woocommerce-product-collection">
        <!-- wp:woocommerce/product-template {"style":{"spacing":{"blockGap":"var:preset|spacing|lg"}}} -->
        <!-- wp:pattern {"slug":"wecodeart/el-product-loop"} /-->
        <!-- /wp:woocommerce/product-template -->
    </div>
    <!-- /wp:woocommerce/product-collection -->
    <!-- wp:buttons {"className":"","layout":{"type":"flex","justifyContent":"center"}} -->
    <div class="wp-block-buttons">
        <!-- wp:button {"backgroundColor":"primary","className":"is-style-fill"} -->
        <div class="wp-block-button is-style-fill">
            <a class="wp-block-button__link has-primary-background-color has-background" href="#"><?php esc_html_e( 'See More', 'wecodeart-honey' ); ?></a>
        </div>
        <!-- /wp:button -->
    </div>
    <!-- /wp:buttons -->
</div>
<!-- /wp:group -->