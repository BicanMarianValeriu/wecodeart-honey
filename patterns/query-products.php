<?php
/**
 * Title: Query (Products)
 * Slug: wecodeart/query-products
 * Categories: wecodeart, query
 * Block Types: core/query,
 * Inserter: false
 */
?>
<!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
<div class="wp-block-group">
    <!-- wp:woocommerce/product-results-count /-->
    <!-- wp:woocommerce/catalog-sorting {"fontSize":""} /-->
</div>
<!-- /wp:group -->
<!-- wp:query {"query":{"perPage":9,"pages":0,"offset":0,"postType":"product","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":true,"__woocommerceAttributes":[],"__woocommerceStockStatus":["outofstock","onbackorder","instock"],"__woocommerceOnSale":false,"parents":[],"taxQuery":null},"displayLayout":{"type":"flex","columns":3},"namespace":"woocommerce/product-query"} -->
<div class="wp-block-query">
    <!-- wp:post-template {"__woocommerceNamespace":"woocommerce/product-query/product-template"} -->
    <!-- wp:pattern {"slug":"wecodeart/el-product-loop"} /-->
    <!-- /wp:post-template -->
    
    <!-- wp:query-pagination {"layout":{"type":"flex","justifyContent":"center"}} -->
    <!-- wp:query-pagination-previous /-->
    <!-- wp:query-pagination-numbers /-->
    <!-- wp:query-pagination-next /-->
    <!-- /wp:query-pagination -->

    <!-- wp:query-no-results -->
    <!-- wp:pattern {"slug":"woocommerce/no-products-found"} /-->
    <!-- /wp:query-no-results -->
</div>
<!-- /wp:query -->