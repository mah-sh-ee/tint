<?php //アクセス解析設定に必要な定数や関数

//Google Tag ManagerのトラッキングID
define('OP_GOOGLE_TAG_MANAGER_TRACKING_ID', 'google_tag_manager_tracking_id');
if ( !function_exists( 'get_google_tag_manager_tracking_id' ) ):
function get_google_tag_manager_tracking_id(){
  return get_theme_option(OP_GOOGLE_TAG_MANAGER_TRACKING_ID);
}
endif;

//Google AnalyticsのトラッキングID
define('OP_GOOGLE_ANALYTICS_TRACKING_ID', 'google_analytics_tracking_id');
if ( !function_exists( 'get_google_analytics_tracking_id' ) ):
function get_google_analytics_tracking_id(){
  return get_theme_option(OP_GOOGLE_ANALYTICS_TRACKING_ID);
}
endif;

//Google Search ConsoleのID
define('OP_GOOGLE_SEARCH_CONSOLE_ID', 'google_search_console_id');
if ( !function_exists( 'get_google_search_console_id' ) ):
function get_google_search_console_id(){
  return get_theme_option(OP_GOOGLE_SEARCH_CONSOLE_ID);
}
endif;

//PtengineのID
define('OP_PTENGINE_TRACKING_ID', 'ptengine_tracking_id');
if ( !function_exists( 'get_ptengine_tracking_id' ) ):
function get_ptengine_tracking_id(){
  return get_theme_option(OP_PTENGINE_TRACKING_ID);
}
endif;

//その他のアクセス解析ヘッダータグ
define('OP_OTHER_ANALYTICS_HEADER_TAGS', 'other_analytics_header_tags');
if ( !function_exists( 'get_other_analytics_header_tags' ) ):
function get_other_analytics_header_tags(){
  return stripslashes_deep(get_theme_option(OP_OTHER_ANALYTICS_HEADER_TAGS));
}
endif;

//その他のアクセス解析フッタータグ
define('OP_OTHER_ANALYTICS_FOOTER_TAGS', 'other_analytics_footer_tags');
if ( !function_exists( 'get_other_analytics_footer_tags' ) ):
function get_other_analytics_footer_tags(){
  return stripslashes_deep(get_theme_option(OP_OTHER_ANALYTICS_FOOTER_TAGS));
}
endif;
