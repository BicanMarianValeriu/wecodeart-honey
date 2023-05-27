<?php
/**
 * Title: Latest Posts
 * Slug: wecodeart/latest-posts
 * Categories: wecodeart-honey, wecodeart-query
 */
?>
<!-- wp:group {"className":"py-5","layout":{"inherit":true}} -->
<div class="wp-block-group py-5">
    <!-- wp:heading {"textAlign":"center","level":4,"textColor":"primary","className":"mb-0"} -->
    <h4 class="has-text-align-center mb-0 has-primary-color has-text-color" id="blog-ul-nostru">Blog-ul nostru</h4>
    <!-- /wp:heading -->
    <!-- wp:heading {"textAlign":"center","style":{"spacing":{"margin":{"top":"0"}}},"textColor":"dark","className":"h1"} -->
    <h2 class="wp-block-heading has-text-align-center h1 has-dark-color has-text-color" id="ultimele-postari" style="margin-top:0">Ultimele postări</h2>
    <!-- /wp:heading -->
    <!-- wp:separator {"color":"primary","className":"is-style-dots"} -->
    <hr class="wp-block-separator has-text-color has-background has-primary-background-color has-primary-color is-style-dots" />
    <!-- /wp:separator -->
    <!-- wp:query {"queryId":1,"query":{"perPage":3,"pages":0,"offset":0,"postType":"post","categoryIds":[],"tagIds":[],"order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false},"displayLayout":{"type":"flex","columns":3}} -->
    <div class="wp-block-query">
        <!-- wp:post-template {"className":"my-5"} -->
        <!-- wp:group {"backgroundColor":"light","className":"p-3 p-sm-4 rounded-2 h-100"} -->
        <div class="wp-block-group p-3 p-sm-4 rounded-2 h-100 has-light-background-color has-background">
            <!-- wp:post-featured-image {"isLink":true,"className":"rounded-2"} /-->
            <!-- wp:group {"className":"gap-1 mb-3","layout":{"type":"flex","justifyContent":"center"}} -->
            <div class="wp-block-group gap-1 mb-3">
                <!-- wp:pattern {"slug":"wecodeart/el-entry-meta"} /-->
            </div>
            <!-- /wp:group -->
            <!-- wp:post-title {"textAlign":"center","level":3,"isLink":true,"className":"fw-700 mb-1"} /-->
            <!-- wp:post-excerpt {"textAlign":"center","moreText":"Vezi mai mult"} /-->
        </div>
        <!-- /wp:group -->
        <!-- /wp:post-template -->
    </div>
    <!-- /wp:query -->
</div>
<!-- /wp:group -->