<?php //CSS縮小化用


///////////////////////////////////////
// CSSファイルとインラインCSSの縮小化
///////////////////////////////////////
if ( !function_exists( 'tag_code_to_minify_css' ) ):
function tag_code_to_minify_css($buffer) {

  if (is_css_minify_enable()) {
    //最終出力縮小化CSSコード
    $last_minfified_css = null;

    //CSSファイル
    $link_pattern = '<link[^>]+?stylesheet[^>]+?href=[\'"]([^\'"]+?)[\'"][^>]*?>';
    $style_pattern = '<style[^>]*?>(.*?)</style>';
    $pattern = '{'.$link_pattern.'|'.$style_pattern.'}is';

    $subject = $buffer;
    $res = preg_match_all($pattern, $subject, $m);
    $all = 0;
    $file = 1;
    $code = 2;
    if ($res && isset($m[$all], $m[$file], $m[$code])) {
      //_v($m);
      $i = 0;

      //return $buffer;
      foreach ($m[$all] as $match) {
        //CSS用のタグ
        $tag = $match;
        //CSSファイルURL
        $url = $m[$file][$i];
        //?var=4.9のようなURLクエリを除去(remove_query_arg( 'ver', $url ))
        $url = preg_replace('/\?.*$/m', '', $url);
        //_v($url);
        //CSSコード
        $css_inline_code = $m[$code][$i];
        //_v($css_inline_code);

        ++$i;

        ////////////////////////////////
        //ファイルタイプのCSSのとき
        ////////////////////////////////
        if ($url) {
          //サイトのURLが含まれているものだけ処理
          if (strpos($url, site_url()) !== false) {
            if (
              //アドミンバースタイルは除外
              (strpos($url, 'admin-bar.min.css') !== false)
              //ダッシュアイコンは除外
              || (strpos($url, 'dashicons.min.css') !== false)
            ) {
              continue;
            }

            //除外リストにマッチするCSS URLは縮小化しない
            if (is_url_matche_list($url, get_css_minify_exclude_list())) {
              continue;
            }

            //_v($url);//CSSコード変換するURL

            //CSS URLからCSSコードの取得
            $css = css_url_to_css_minify_code( $url );
            //縮小化可能ななCSSだと時
            if ($css !== false) {
              //_v($css);//変換したCSSコード

              //CSSを縮小化したCSSファイルURL linkタグを削除する
              $buffer = str_replace($tag, '', $buffer);


              $last_minfified_css .= $css;
            }

          } else {//strpos($url, site_url()) !== false
            //外部ファイル名の場合
            //_v($url);
            if (!is_amp() && strpos($url, FONT_AWESOME_CDN_URL) !== false) {
              $css = get_file_contents(get_template_directory().'/css/fontawesome.min.css');
              if ($css !== false) {
                //ヘッダー出力コードからstyleタグを削除
                $buffer = str_replace($tag, '', $buffer);
                $last_minfified_css .= $css;
              }
            }
          }//外部URLの場合終了
        }//$url

        ////////////////////////////////
        //CSSがソースコードのとき
        ////////////////////////////////
        if ($css_inline_code) {
          //除外インラインCSSコード（プリント用のスタイルは除外）
          if (preg_match('{media=[\'"].*?print.*?[\'"]}i', $tag)) {
            continue;
          }

          //空の場合は除外
          if (empty($css_inline_code)) {
            continue;
          }
          //最終出力縮小化CSSコードに縮小化したCSSコードを加える
          $last_minfified_css .= minify_css($css_inline_code);
          //ヘッダー出力コードからstyleタグを削除
          $buffer = str_replace($tag, '', $buffer);
          //_v($match);
        }//$css


      }//foreach
    }

    //縮小化したCSSをデータの最後に付け加える
    if ($last_minfified_css) {
      $buffer = $buffer.PHP_EOL.'<style>'.$last_minfified_css.'</style>';

     //$buffer = '<style>'.$last_minfified_css.'</style>'.PHP_EOL.$buffer;

      // $title_end = '</title>';
      // $all_style_tag = '<style>'.$last_minfified_css.'</style>';
      // $buffer = str_replace($title_end, $title_end.PHP_EOL.$all_style_tag, $buffer);
    }

    ///////////////////////////////////////
    // CSSエラー除外
    ///////////////////////////////////////
    //bbPressのCSSエラー
    if (is_bbpress_exist()) {
      $buffer = str_replace('@media screen and (max-device-width:480px),screen and (-webkit-min-device-pixel-ratio:2){-webkit-text-size-adjust:none}', '', $buffer);
    }
    //BuddyPressのCSSエラー
    if (is_buddypress_exist()) {
      $buffer = str_replace('.1s ease-in 0;', '.1s ease-in;', $buffer);
      $buffer = str_replace('#wpadminbar*', '#wpadminbar *', $buffer);
      $buffer = str_replace('*html #wpadminbar', '* html #wpadminbar', $buffer);
      $buffer = str_replace('*html body{', '* html body{', $buffer);
    }


    // $buffer = str_replace('#bbpress-forums div.bbp-reply-author img.avatar{width:40px;height:auto}}', '#bbpress-forums div.bbp-reply-author img.avatar{width:40px;height:auto}', $buffer);

  }//is_css_minify_enable()


  //_v($buffer);
  return $buffer;
}
endif;

//CSS URLからコードを取り出して縮小化コードを返す
if ( !function_exists( 'css_url_to_css_minify_code' ) ):
function css_url_to_css_minify_code( $url ) {
  $css = false;
  //URLファイルをローカルファイルパスに変更
  $local_file = url_to_local($url);
  // $local_file = str_replace(site_url(), ABSPATH, $url);
  // $local_file = str_replace('//', '/', $local_file);
  // $local_file = str_replace('\\', '/', $local_file);
  //_v($local_file);

  if ( WP_Filesystem() && file_exists($local_file) ) {//WP_Filesystemの初期化
    global $wp_filesystem;//$wp_filesystemオブジェクトの呼び出し
    $css = $wp_filesystem->get_contents($local_file);

    //文字セットの除去
    $css = preg_replace('{@charset[^;]+?;}i', '', $css);
    //コメントの除去
    $css = preg_replace('{/\*.+?\*/}is', '', $css);
    //@importを利用している場合は変換しない
    if (strpos($css, '@import') !== false) {
      return false;
    }

    //CSSファイルの置いてあるパス取得
    $dir_url = str_replace(basename($url), '', $url);
    //_v($dir_url);

    //CSS内容を縮小化して書式を統一化する
    $css = minify_css($css);

    //url(./xxxxxx)をurl(xxxxxx)に統一化
    $css = str_replace('url(./', 'url(', $css);
    $css = str_replace('url(/', 'url(', $css);

    $pattern = '{url\((.+?)\)}i';
    $subject = $css;
    $res = preg_match_all($pattern, $subject, $m);
    if ($res && $m[0] ) {
      foreach ($m[0] as $match) {
        if (
          //url()中にURLが指定されていない
          //url(http://xxxxx)形式でない
          !preg_match('{https?://}i', $match) &&
          //URIスキームの指定ではない
          //url(data:XXXXX)形式でない
          !preg_match('{data:}i', $match)
        ) {
          //url(xxxxx)をurl(http://xxxxx)に変更
          $url = str_replace('url(', 'url('.$dir_url, $match);
          //_v($url);
          //縮小化したCSSのurl(xxxxx)を置換
          $css = str_replace($match, $url, $css);
        }
      }//foreach
    }//$res && $m[0]
  }//WP_Filesystem
  return $css;
}
endif;

// //ログインユーザー以外には管理用CSSを表示しない
// if (!is_user_logged_in()) {
//   add_filter( 'style_loader_tag', 'remove_admin_link_tag' );
// }
// if ( !function_exists( 'remove_admin_link_tag' ) ):
// function remove_admin_link_tag( $tag ) {
//   if (strpos($tag, 'admin-bar.min.css') !== false) {
//     $tag = null;
//   }
//   if (strpos($tag, 'dashicons.min.css') !== false) {
//     $tag = null;
//   }
//   return $tag;
// }
// endif;

// //type='text/css'属性を取り除く
// add_filter( 'style_loader_tag', 'remove_type_text_css', 9999 );
// if ( !function_exists( 'remove_type_text_css' ) ):
// function remove_type_text_css( $tag ) {
//   $tag = str_replace(" type='text/css'", '', $tag);
//   $tag = str_replace(' type="text/css"', '', $tag);

//   return $tag;
// }
// endif;

// /*async defer*/
// add_filter( 'script_loader_tag', 'defer_async_scripts', 10, 3 );
// function defer_async_scripts( $tag, $handle, $src ) {

//         return '<script type="text/javascript" src="' . $src . '" async defer></script>' . "\n";

// }

// //レンダリングをブロックしている jQuery, jQuery-migrate をフッタに移動する
// if(!is_admin()){
//   add_action( 'wp_enqueue_scripts', 'queue_cdn_jquery' );
//   function queue_cdn_jquery() {
//     wp_deregister_script('jquery');
//     wp_deregister_script('jquery-core');
//     wp_deregister_script('jquery-migrate');

//     wp_register_script('jquery', false, array('jquery-core', 'jquery-migrate'), '1.12.4', true);
//     wp_enqueue_script('jquery');

//     wp_enqueue_script('jquery-core', '//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js', array(), '1.12.4', true);
//     wp_enqueue_script('jquery-migrate', '//cdnjs.cloudflare.com/ajax/libs/jquery-migrate/1.4.1/jquery-migrate.min.js', array(), '1.4.1', true);
//   }
// }