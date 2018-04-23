<?php //キャッシュ系の処理


//テーマを変更時にテーマのリソースキャッシュを削除
add_action('switch_theme', 'delete_theme_resource_caches');
if ( !function_exists( 'delete_theme_resource_caches' ) ):
function delete_theme_resource_caches() {
  //ブログカードキャッシュの削除
  delete_blogcard_cache_transients();
  //シェア・フォローカウントキャッシュの削除
  delete_sns_cache_transients();
  //キャッシュ用リソースフォルダの削除
  remove_all_directory(get_theme_resources_dir());
}
endif;

//transientSNSキャッシュの削除
if ( !function_exists( 'delete_blogcard_cache_transients' ) ):
function delete_blogcard_cache_transients(){
  global $wpdb;
  //ブログカードキャッシュの削除（bcc = Blog Card Cache)
  $wpdb->query("DELETE FROM $wpdb->options WHERE (`option_name` LIKE '%_transient_bcc_%') OR (`option_name` LIKE '%_transient_timeout_bcc_%')");
}
endif;
//delete_blogcard_cache_transients();

//transientSNSキャッシュの削除
if ( !function_exists( 'delete_sns_cache_transients' ) ):
function delete_sns_cache_transients(){
  global $wpdb;
  //シェアカウントキャッシュの削除
  $wpdb->query("DELETE FROM $wpdb->options WHERE (`option_name` LIKE '%_transient_".TRANSIENT_SHARE_PREFIX."%') OR (`option_name` LIKE '%_transient_timeout_".TRANSIENT_SHARE_PREFIX."%')");
  //フォローカントキャッシュの削除
  $wpdb->query("DELETE FROM $wpdb->options WHERE (`option_name` LIKE '%_transient_".TRANSIENT_FOLLOW_PREFIX."%') OR (`option_name` LIKE '%_transient_timeout_".TRANSIENT_FOLLOW_PREFIX."%')");
}
endif;
//delete_sns_cache_transients();