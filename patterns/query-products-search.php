<?php
/**
 * Title: Query (Products: Search)
 * Slug: wecodeart/query-products-search
 * Categories: wecodeart, query
 * Block Types: core/query,
 * Inserter: false
 */
?>
<!-- wp:query {"className":"wc-block-grid has-multiple-rows has-aligned-buttons","query":{"perPage":"12","pages":0,"offset":0,"postType":"product","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":true,"__woocommerceStockStatus":["instock","outofstock","onbackorder"]},"displayLayout":{"type":"flex","columns":4},"namespace":"woocommerce/product-query","layout":{"type":"default"}} -->
<div class="wp-block-query wc-block-grid has-multiple-rows has-aligned-buttons">
    <!-- wp:post-template {"className":"wc-block-grid__listing","__woocommerceNamespace":"woocommerce/product-query/product-template"} -->
    <!-- wp:pattern {"slug":"wecodeart/el-product-loop"} /-->
    <!-- /wp:post-template -->
    <!-- wp:query-pagination {"layout":{"type":"flex","justifyContent":"center"}} -->
    <!-- wp:query-pagination-previous /-->
    <!-- wp:query-pagination-numbers /-->
    <!-- wp:query-pagination-next /-->
    <!-- /wp:query-pagination -->
    <!-- wp:query-no-results -->
    <!-- wp:pattern {"slug":"woocommerce/no-products-found"} /-->
    <!-- wp:pattern {"slug":"woocommerce/product-search-form"} /-->
    <!-- /wp:query-no-results -->
</div>
<!-- /wp:query -->