<?php //リダイレクトカスタムフィールドを設置する

///////////////////////////////////////
// カスタムボックスの追加
///////////////////////////////////////
add_action('admin_menu', 'add_redirect_custom_box');
if ( !function_exists( 'add_redirect_custom_box' ) ):
function add_redirect_custom_box(){

  //リダイレクト
  add_meta_box( 'singular_redirect_settings',__( 'リダイレクト', THEME_NAME ), 'redirect_custom_box_view', 'post', 'side' );
  add_meta_box( 'singular_redirect_settings',__( 'リダイレクト', THEME_NAME ), 'redirect_custom_box_view', 'page', 'side' );
  add_meta_box( 'singular_redirect_settings',__( 'リダイレクト', THEME_NAME ), 'redirect_custom_box_view', 'topic', 'side' );
}
endif;

///////////////////////////////////////
// リダイレクト
///////////////////////////////////////
if ( !function_exists( 'redirect_custom_box_view' ) ):
function redirect_custom_box_view(){
  $redirect_url = get_post_meta(get_the_ID(),'redirect_url', true);

  generate_label_tag('redirect_url', __('リダイレクトURL', THEME_NAME) );
  generate_textbox_tag('redirect_url', $redirect_url, __( 'https://', THEME_NAME ));
  echo '<p class="howto">'.__( 'このページに訪れるユーザーを設定したURLに301リダイレクトします。', THEME_NAME ).'</p>';

}
endif;

add_action('save_post', 'redirect_custom_box_save_data');
if ( !function_exists( 'redirect_custom_box_save_data' ) ):
function redirect_custom_box_save_data(){
  $id = get_the_ID();
  //リダイレクトURL
  if ( isset( $_POST['redirect_url'] ) ){
    $redirect_url = $_POST['redirect_url'];
    $redirect_url_key = 'redirect_url';
    add_post_meta($id, $redirect_url_key, $redirect_url, true);
    update_post_meta($id, $redirect_url_key, $redirect_url);
  }
}
endif;

//リダイレクトURLの取得
if ( !function_exists( 'get_singular_redirect_url' ) ):
function get_singular_redirect_url(){
  return trim(get_post_meta(get_the_ID(), 'redirect_url', true));
}
endif;





