<?php //全体設定に必要な定数や関数

//サイトキーカラー
define('OP_SITE_KEY_COLOR', 'site_key_color');
if ( !function_exists( 'get_site_key_color' ) ):
function get_site_key_color(){
  return get_theme_option(OP_SITE_KEY_COLOR);
}
endif;

//サイトキーテキストカラー
define('OP_SITE_KEY_TEXT_COLOR', 'site_key_text_color');
if ( !function_exists( 'get_site_key_text_color' ) ):
function get_site_key_text_color(){
  return get_theme_option(OP_SITE_KEY_TEXT_COLOR);
}
endif;

//フォント
define('OP_SITE_FONT_FAMILY', 'site_font_family');
if ( !function_exists( 'get_site_font_family' ) ):
function get_site_font_family(){
  return get_theme_option(OP_SITE_FONT_FAMILY, 'yu_gothic');
}
endif;
if ( !function_exists( 'is_site_font_family_local' ) ):
function is_site_font_family_local(){
  switch (get_site_font_family()) {
    case 'yu_gothic':
    case 'meiryo':
    case 'ms_pgothic':
      return true;
      break;
  }
}
endif;

//フォントサイズ
define('OP_SITE_FONT_SIZE', 'site_font_size');
if ( !function_exists( 'get_site_font_size' ) ):
function get_site_font_size(){
  return get_theme_option(OP_SITE_FONT_SIZE, '18px');
}
endif;

//フォントサイズ
define('OP_MOBILE_SITE_FONT_SIZE', 'mobile_site_font_size');
if ( !function_exists( 'get_mobile_site_font_size' ) ):
function get_mobile_site_font_size(){
  return get_theme_option(OP_MOBILE_SITE_FONT_SIZE, '16px');
}
endif;

//サイト背景色
define('OP_SITE_BACKGROUND_COLOR', 'site_background_color');
if ( !function_exists( 'get_site_background_color' ) ):
function get_site_background_color(){
  return get_theme_option(OP_SITE_BACKGROUND_COLOR);
}
endif;

//サイト背景画像
define('OP_SITE_BACKGROUND_IMAGE_URL', 'site_background_image_url');
if ( !function_exists( 'get_site_background_image_url' ) ):
function get_site_background_image_url(){
  return get_theme_option(OP_SITE_BACKGROUND_IMAGE_URL);
}
endif;

//サイトリンク色
define('OP_SITE_LINK_COLOR', 'site_link_color');
if ( !function_exists( 'get_site_link_color' ) ):
function get_site_link_color(){
  return get_theme_option(OP_SITE_LINK_COLOR);
}
endif;

//サイト幅を揃える
define('OP_ALIGN_SITE_WIDTH', 'align_site_width');
if ( !function_exists( 'is_align_site_width' ) ):
function is_align_site_width(){
  return get_theme_option(OP_ALIGN_SITE_WIDTH);
}
endif;

//サイドバーの表示タイプ
define('OP_SIDEBAR_POSITION', 'sidebar_position');
if ( !function_exists( 'get_sidebar_position' ) ):
function get_sidebar_position(){
  return get_theme_option(OP_SIDEBAR_POSITION, 'sidebar_right');
}
endif;

//サイドバーの表示状態の設定
define('OP_SIDEBAR_DISPLAY_TYPE', 'sidebar_display_type');
if ( !function_exists( 'get_sidebar_display_type' ) ):
function get_sidebar_display_type(){
  return get_theme_option(OP_SIDEBAR_DISPLAY_TYPE, 'display_all');
}
endif;

//サイトアイコン
define('OP_SITE_ICON_URL', 'site_icon_url');
//Wordpressデフォルトのget_site_icon_url関数とかぶるため名前変更
if ( !function_exists( 'get_site_icon_url2' ) ):
function get_site_icon_url2(){
  //return get_theme_option(OP_SITE_ICON_URL, get_default_site_icon_url());
  return ;
}
endif;

if ( !function_exists( 'get_default_site_icon_url' ) ):
function get_default_site_icon_url(){
  return get_template_directory_uri().'/images/site-icon.png';
}
endif;

//デフォルトサイトアイコンの設定
if (!get_site_icon_url()) {//カスタマイザーでサイトアイコンが設定されてないとき
  add_action( 'wp_head', 'add_default_site_icon_tag' );
  add_action( 'admin_print_styles', 'add_default_site_icon_tag' );
}
if ( !function_exists( 'add_default_site_icon_tag' ) ):
function add_default_site_icon_tag(){
  $tag = '<!-- '.THEME_NAME_CAMEL.' site icon -->'.PHP_EOL;
  $tag .= '<link rel="icon" href="'.get_template_directory_uri().'/images/site-icon32x32.png'.'" sizes="32x32" />'.PHP_EOL;
  $tag .= '<link rel="icon" href="'.get_template_directory_uri().'/images/site-icon192x192.png'.'" sizes="192x192" />'.PHP_EOL;
  $tag .= '<link rel="apple-touch-icon" href="'.get_template_directory_uri().'/images/site-icon180x180.png'.'" />'.PHP_EOL;
  $tag .= '<meta name="msapplication-TileImage" content="'.get_template_directory_uri().'/images/site-icon270x270.png'.'" />'.PHP_EOL;
  echo $tag;
}
endif;

// //サイトアイコンの設定
// // add_action( 'wp_head', 'the_site_icon_tag' );
// // add_action( 'admin_print_styles', 'the_site_icon_tag' );
// if ( !function_exists( 'the_site_icon_tag' ) ):
// function the_site_icon_tag(){
//   if (get_site_icon_url2()) {
//     $url = get_site_icon_url2();
//   } else {
//     $url = get_default_site_icon_url();
//   }
//   if ($url) {
//     $tag = '<!-- '.THEME_NAME_CAMEL.' site icon -->'.PHP_EOL;
//     $tag .= '<link rel="icon" href="'.$url.'">'.PHP_EOL;
//     $tag .= '<link rel="apple-touch-icon" href="'.$url.'">'.PHP_EOL;
//     $tag .= '<meta name="msapplication-TileImage" content="'.$url.'">'.PHP_EOL;
//     echo $tag;
//   }
// }
// endif;

// //サイトアイコン出力の変更
// add_filter('site_icon_meta_tags', 'filter_site_icon_meta_tags');
// function filter_site_icon_meta_tags($meta_tags) {
//   //_v(empty($meta_tags));
//   if (empty($meta_tags)) {
//     $url = get_default_site_icon_url();
//     $meta_tags = array(
//       '<link rel="icon" href="'.$url.'">',
//       '<link rel="apple-touch-icon" href="'.$url.'">',
//       '<meta name="msapplication-TileImage" content="'.$url.'">',
//     );
//    //_v($meta_tags);
//   }
//   return $meta_tags;
// }