<?php //OGP関係の関数

//Facebook OGPタグを出力
if ( is_facebook_ogp_enable() && !is_wpforo_plugin_page() ) {
  add_action( 'wp_head', 'the_facebook_ogp_tag' );
}
if ( !function_exists( 'the_facebook_ogp_tag' ) ):
function the_facebook_ogp_tag() {
  get_template_part('tmp/header-ogp');
}
endif;

//Twitterカードタグを出力
if ( is_twitter_card_enable() && !is_wpforo_plugin_page() ) {
  add_action( 'wp_head', 'the_twitter_card_tag' );
}
if ( !function_exists( 'the_twitter_card_tag' ) ):
function the_twitter_card_tag() {
  get_template_part('tmp/header-twitter-card');
}
endif;
