<?php
//woocommerce tutorial: https://www.businessbloomer.com/
//Single Product Page   photo: https://www.businessbloomer.com/woocommerce-visual-hook-guide-single-product-page
// Before content
add_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
add_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
add_action( 'woocommerce_before_single_product', 'woocommerce_output_all_notices', 10 );
  
// Left column
add_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
add_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
add_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20 );
 
// Right column
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
 
// Right column - add to cart
do_action( 'woocommerce_before_add_to_cart_form' );
do_action( 'woocommerce_before_add_to_cart_button' );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
 
add_action( 'woocommerce_simple_add_to_cart', 'woocommerce_simple_add_to_cart', 30 );
add_action( 'woocommerce_grouped_add_to_cart', 'woocommerce_grouped_add_to_cart', 30 );
add_action( 'woocommerce_variable_add_to_cart', 'woocommerce_variable_add_to_cart', 30 );
add_action( 'woocommerce_external_add_to_cart', 'woocommerce_external_add_to_cart', 30 );
add_action( 'woocommerce_single_variation', 'woocommerce_single_variation', 10 );
add_action( 'woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20 );
do_action( 'woocommerce_before_quantity_input_field' );
do_action( 'woocommerce_after_quantity_input_field' );
do_action( 'woocommerce_after_add_to_cart_button' );
do_action( 'woocommerce_after_add_to_cart_form' );
 
// Right column - meta
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
do_action( 'woocommerce_product_meta_start' );
do_action( 'woocommerce_product_meta_end' );
 
// Right column - sharing
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
do_action( 'woocommerce_share' );
 
// Tabs, upsells and related products
add_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
add_action( 'woocommerce_product_additional_information', 'wc_display_product_attributes', 10 );
do_action( 'woocommerce_product_after_tabs' );
add_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
add_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
 
// Reviews
add_action( 'woocommerce_review_before', 'woocommerce_review_display_gravatar', 10 );
add_action( 'woocommerce_review_before_comment_meta', 'woocommerce_review_display_rating', 10 );
add_action( 'woocommerce_review_meta', 'woocommerce_review_display_meta', 10 );
do_action( 'woocommerce_review_before_comment_text', $comment );
add_action( 'woocommerce_review_comment_text', 'woocommerce_review_display_comment_text', 10 );
do_action( 'woocommerce_review_after_comment_text', $comment );
 
// After content
do_action( 'woocommerce_after_single_product' );
do_action( 'woocommerce_after_main_content' );
// --------------------------------------------------------------------------------------------------------------------------------





//Cart Page   photo: https://www.businessbloomer.com/woocommerce-visual-hook-guide-cart-page/
add_action( 'woocommerce_before_cart', 'woocommerce_output_all_notices', 10 );
 
add_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
add_action( 'woocommerce_cart_collaterals', 'woocommerce_cart_totals', 10 );
 
add_action( 'woocommerce_proceed_to_checkout', 'woocommerce_button_proceed_to_checkout', 20 );
//------------------------------------------------------------------------------------------------------------------------------------





//Archive / Shop / Cat Pages    photo: https://www.businessbloomer.com/woocommerce-visual-hook-guide-archiveshopcat-page/
 
add_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
add_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
 
add_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 );
add_action( 'woocommerce_archive_description', 'woocommerce_product_archive_description', 10 );
 
add_action( 'woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 10 );
add_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
add_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
 
add_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 ); 
 
add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
 
add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
 
add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
 
add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
 
add_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );
 
add_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
//-------------------------------------------------------------------------------------------------------------------------------

update_field( 'my_field', 'my_value', $user_id );

//----------------------------------------------------------------------------------------------------------------------------
add_shortcode('product_id', 'id_product_function');
function id_product_function()
{
    $post_id = get_the_ID();
    return $post_id;
}
add_shortcode('product_title', 'title_product_function');
function title_product_function()
{
    $title = get_the_title(get_the_ID());
  return $title;
}
add_shortcode('product_link', 'link_product_function');
function link_product_function()
{
    $link = the_permalink(get_the_ID());
    return $link;
}
add_shortcode('product_price', 'price_product_function');
function price_product_function()
{
    $price = get_the_price(get_the_ID());
    return $price;
}
add_shortcode('product_image', 'image_product_function');
function image_product_function()
{
    $image = get_the_post_thumbnail(get_the_ID(), 'thumbnail');
    return $image;
}
//----------------------------------------------------------------------------------------------------------------------------
