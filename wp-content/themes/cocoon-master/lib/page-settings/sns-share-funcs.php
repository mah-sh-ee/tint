<?php //SNS設定に必要な定数や関数
///////////////////////////////////////
// SNSシェアボタンの設定
///////////////////////////////////////

//トップシェアボタン関数
require_once 'sns-share-funcs-top.php';
//ボトムシェアボタン関数
require_once 'sns-share-funcs-bottom.php';

//ツイートにメンションを含める
define('OP_TWITTER_ID_INCLUDE', 'twitter_id_include');
if ( !function_exists( 'is_twitter_id_include' ) ):
function is_twitter_id_include(){
  return get_theme_option(OP_TWITTER_ID_INCLUDE);
}
endif;

//ツイート後にフォローを促す
define('OP_TWITTER_RELATED_FOLLOW_ENABLE', 'twitter_related_follow_enable');
if ( !function_exists( 'is_twitter_related_follow_enable' ) ):
function is_twitter_related_follow_enable(){
  return get_theme_option(OP_TWITTER_RELATED_FOLLOW_ENABLE, 1);
}
endif;

//ツイートに含めらハッシュタグ
define('OP_TWITTER_HASH_TAG', 'twitter_hash_tag');
if ( !function_exists( 'get_twitter_hash_tag' ) ):
function get_twitter_hash_tag(){
  return get_theme_option(OP_TWITTER_HASH_TAG);
}
endif;

//SNSシェア数キャッシュ有効
define('OP_SNS_SHARE_COUNT_CACHE_ENABLE', 'sns_share_count_cache_enable');
if ( !function_exists( 'is_sns_share_count_cache_enable' ) ):
function is_sns_share_count_cache_enable(){
  return get_theme_option(OP_SNS_SHARE_COUNT_CACHE_ENABLE, 1);
}
endif;

//SNSシェア数キャッシュ取得間隔
define('OP_SNS_SHARE_COUNT_CACHE_INTERVAL', 'sns_share_count_cache_interval');
if ( !function_exists( 'get_sns_share_count_cache_interval' ) ):
function get_sns_share_count_cache_interval(){
  return intval(get_theme_option(OP_SNS_SHARE_COUNT_CACHE_INTERVAL, 6));
}
endif;
