<?php //AMP

//AMP判別関数
if ( !function_exists( 'is_amp' ) ):
function is_amp(){
  //bbPressがインストールされていて、トピックの時は除外
  if (is_plugin_fourm_page()) {
    return false;
  }

  //AMPチェック
  $is_amp = false;
  if ( empty($_GET['amp']) ) {
    return false;
  }

  // ampのパラメーターが1かつ
  // かつsingularページのみ$is_ampをtrueにする
  if(is_amp_enable() && //AMPがカスタマイザーの有効化されているか
     is_singular() &&
     $_GET['amp'] === '1' &&//URLにamp=1パラメータがあるとき
     has_amp_page()//AMPページが存在しているとき
    ){
    $is_amp = true;
  }
  return $is_amp;
}
endif;

//AMPページがある投稿ページか
if ( !function_exists( 'has_amp_page' ) ):
function has_amp_page(){
  $category_ids = get_amp_exclude_category_ids();
  //return 1;
  return is_singular() &&
    is_amp_enable() &&
    is_the_page_amp_enable() &&
    !in_category( $category_ids ) && //除外カテゴリではAMPページを生成しない
    //プラグインが生成するフォーラムページでない場合
    !is_plugin_fourm_page();
}
endif;

//AMP用にコンテンツを変換する
//add_filter('the_content','convert_content_for_amp', 999999999);
if ( !function_exists( 'convert_content_for_amp' ) ):
function convert_content_for_amp($the_content){
  if ( !is_amp() ) {
    return $the_content;
  }




  //iframe用のplaceholderタグ（amp-iframeの呼び出し位置エラー対策）
  $amp_placeholder = '<amp-img layout="fill" src="'.get_template_directory_uri().'/images/transparence.png'.'" placeholder>';


  //noscriptタグの削除
  $the_content = preg_replace('/<noscript>/i', '', $the_content);
  $the_content = preg_replace('/<\/noscript>/i', '', $the_content);

  //fontタグの削除
  $the_content = preg_replace('/<font[^>]*?>/i', '', $the_content);
  $the_content = preg_replace('/<\/font>/i', '', $the_content);

  //Amazon商品リンクのhttp URLをhttpsへ
  $the_content = str_replace('http://rcm-jp.amazon.co.jp/', 'https://rcm-fe.amazon-adsystem.com/', $the_content);
  $the_content = str_replace('"//rcm-fe.amazon-adsystem.com/', '"https://rcm-fe.amazon-adsystem.com/', $the_content);
  $the_content = str_replace("'//rcm-fe.amazon-adsystem.com/", "'https://rcm-fe.amazon-adsystem.com/", $the_content);
  //Amazon商品画像のURLをhttpsへ
  $the_content = str_replace('http://ecx.images-amazon.com', 'https://images-fe.ssl-images-amazon.com', $the_content);
  //楽天商品画像のURLをhttpsへ
  $the_content = str_replace('http://thumbnail.image.rakuten.co.jp', 'https://thumbnail.image.rakuten.co.jp', $the_content);

  //Amazonデフォルトの埋め込みタグを置換する
  /*
  $pattern = '/<iframe([^>]+?)(src="https:\/\/rcm-fe.amazon-adsystem.com\/[^"]+?").*?><\/iframe>/is';
  $append = '<amp-iframe$1$2 width="120" height="240"frameborder="0">'.$amp_placeholder.'</amp-iframe>';
  */
  $pattern = '/<iframe([^>]+?)(src="https?:\/\/rcm-fe.amazon-adsystem.com\/[^"]+?t=([^&"]+)[^"]+?asins=([^&"]+)[^"]*?").*?><\/iframe>/is';
  $amazon_url = 'https://www.amazon.co.jp/exec/obidos/ASIN/$4/$3/ref=nosim/';
  $append = PHP_EOL.'<amp-iframe$1$2 width="120" height="240" frameborder="0">'.$amp_placeholder.'</amp-iframe><br><a href="'.$amazon_url.'" class="aa-link"></a>'.PHP_EOL;

  //YouTube iframeのsrc属性のhttp URLをhttpsへ
  $the_content = str_replace('http://www.youtube.com/', 'https://www.youtube.com/', $the_content);
  //JetpackがYouTubeのURLに余計なクエリを付け加えるのを取り除く
  //$the_content = preg_replace('{(https://www.youtube.com/embed/[^?"\']+)[^"\']*}i', '$1', $the_content);

  //$append = url_to_external_ogp_blog_card_tag($amazon_url);
  //$the_content = preg_replace($pattern, htmlspecialchars($append), $the_content);
  $the_content = preg_replace($pattern, $append, $the_content);
  //Amazon画像をブログカード化
  //$the_content = url_to_external_blog_card($the_content);


  //C2A0文字コード（UTF-8の半角スペース）を通常の半角スペースに置換
  $the_content = str_replace('\xc2\xa0', ' ', $the_content);

  //style属性を取り除く
  $the_content = preg_replace('/ *?style=["][^"]*?["]/i', '', $the_content);
  $the_content = preg_replace('/ *?style=[\'][^\']*?[\']/i', '', $the_content);

  //target属性を取り除く
  $the_content = preg_replace('/ *?target=["][^"]*?["]/i', '', $the_content);
  $the_content = preg_replace('/ *?target=[\'][^\']*?[\']/i', '', $the_content);

  //rel属性を取り除く
  $the_content = preg_replace('/ *?rel=["][^"]*?["]/i', '', $the_content);
  $the_content = preg_replace('/ *?rel=[\'][^\']*?[\']/i', '', $the_content);

  //onclick属性を取り除く
  $the_content = preg_replace('/ *?onclick=["][^"]*?["]/i', '', $the_content);
  $the_content = preg_replace('/ *?onclick=[\'][^\']*?[\']/i', '', $the_content);

  //onload属性を取り除く
  $the_content = preg_replace('/ *?onload=["][^"]*?["]/i', '', $the_content);
  $the_content = preg_replace('/ *?onload=[\'][^\']*?[\']/i', '', $the_content);

  //marginwidth属性を取り除く
  $the_content = preg_replace('/ *?marginwidth=["][^"]*?["]/i', '', $the_content);
  $the_content = preg_replace('/ *?marginwidth=[\'][^\']*?[\']/i', '', $the_content);

  //marginheight属性を取り除く
  $the_content = preg_replace('/ *?marginheight=["][^"]*?["]/i', '', $the_content);
  $the_content = preg_replace('/ *?marginheight=[\'][^\']*?[\']/i', '', $the_content);

  //contenteditable属性を取り除く
  $the_content = preg_replace('/ *?contenteditable=["][^"]*?["]/i', '', $the_content);
  $the_content = preg_replace('/ *?contenteditable=[\'][^\']*?[\']/i', '', $the_content);

  //YouTubeプレイヤーのtype属性を取り除く
  $the_content = str_replace(" class='youtube-player' type='text/html'", " class='youtube-player'", $the_content);
  $the_content = str_replace(' class="youtube-player" type="text/html"', ' class="youtube-player"', $the_content);

  //FONTタグを取り除く
  $the_content = preg_replace('/<font[^>]+?>/i', '', $the_content);
  $the_content = preg_replace('/<\/font>/i', '', $the_content);

  //ドロップダウンのアーカイブウィジェットは削除
  $pattern = '{<aside id="archives-.+?archives-dropdown.+?</aside>}is';
  $append = '';
  $the_content = preg_replace($pattern, $append, $the_content);
  $pattern = '{<div id="archives-.+?<select id="archives-dropdown-.+?</div>}is';
  $append = '';
  $the_content = preg_replace($pattern, $append, $the_content);

  //ドロップダウンのカテゴリウィジェットは削除
  $pattern = '{<aside id="categories-.+?categories-dropdown.+?</aside>}is';
  $append = '';
  $the_content = preg_replace($pattern, $append, $the_content);
  $pattern = '{<div id="categories.+?categories-dropdown.+?</div>}is';
  $append = '';
  $the_content = preg_replace($pattern, $append, $the_content);

  //formタグを取り除く
  $the_content = preg_replace('{<form.+?</form>}is', '', $the_content);

  //selectタグを取り除く
  $the_content = preg_replace('{<select.+?</select>}is', '', $the_content);

  //アプリーチの画像対応
  $the_content = preg_replace('/<img([^>]+?src="[^"]+?(mzstatic\.com|phobos\.apple\.com|googleusercontent\.com|ggpht\.com)[^"]+?[^>\/]+)\/?>/is', '<amp-img$1 width="75" height="75" sizes="(max-width: 75px) 100vw, 75px"></amp-img>', $the_content);
  $the_content = preg_replace('/<img([^>]+?src="[^"]+?nabettu\.github\.io[^"]+?[^>\/]+)\/?>/is', '<amp-img$1 width="120" height="36" sizes="(max-width: 120px) 100vw, 120px"></amp-img>', $the_content);

  //imgタグをamp-imgタグに変更する
  $res = preg_match_all('/<img(.+?)\/?>/is', $the_content, $m);
  //var_dump($res);
  //var_dump($m);
  if ($res) {//画像タグがある場合

    foreach ($m[0] as $match) {
      //変数の初期化
      $src_attr = null;
      $url = null;
      $width_attr = null;
      $width_value = null;
      $height_attr = null;
      $height_value = null;
      $alt_attr = null;
      $alt_value = null;
      $title_attr = null;
      $title_value = null;
      $sizes_attr = null;
      //var_dump(htmlspecialchars($match));

      //src属性の取得（画像URLの取得）
      $src_res = preg_match('/src=["\']([^"\']+?)["\']/is', $match, $srcs);
      if ($src_res) {
        $src_attr = ' '.$srcs[0];//src属性を作成
        $url = $srcs[1];//srcの値（URL）を取得する
      }

      //width属性の取得
      $width_res = preg_match('/width=["\']([^"\']*?)["\']/is', $match, $widths);
      if ($width_res) {
        $width_attr = ' '.$widths[0];//width属性を作成
        $width_value = $widths[1];//widthの値（幅）を取得する
      }

      //height属性の取得
      $height_res = preg_match('/height=["\']([^"\']*?)["\']/is', $match, $heights);
      if ($height_res) {
        $height_attr = ' '.$heights[0];//height属性を作成
        $height_value = $heights[1];//heightの値（高さ）を取得する
      }

      //alt属性の取得
      $alt_res = preg_match('/alt=["]([^"]*?)["]/is', $match, $alts);
      if (!$alt_res)
        $alt_res = preg_match("/alt=[']([^']*?)[']/is", $match, $alts);
      if ($alt_res) {
        $alt_attr = ' '.$alts[0];//alt属性を作成
        $alt_value = $alts[1];//altの値を取得する
      }

      //title属性の取得
      $title_res = preg_match('/title=["]([^"]*?)["]/is', $match, $titles);
      if (!$title_res)
        $title_res = preg_match("/title=[']([^']*?)[']/is", $match, $titles);
      if ($title_res) {
        $title_attr = ' '.$titles[0];//title属性を作成
        $title_value = $titles[1];//titleの値を取得する
      }

      $class_attr = null;
      //widthとheight属性のないものは画像から情報取得
      if ($url && (empty($width_value) || empty($height_value))) {
        $size = get_image_width_and_height($url);
        if ($size) {
          $class_attr = ' class="internal-content-img"';
          $width_value = $size['width'];
          $width_attr = ' width="'.$width_value.'"';//width属性を作成
          $height_value = $size['height'];
          $height_attr = ' height="'.$height_value.'"';//height属性を作成
        } else {
          //外部サイトにある画像の場合
          $class_attr = ' class="external-content-img"';
          //var_dump($url);
          if (
            strpos($url,'//images-fe.ssl-images-amazon.com') !== false ||
            strpos($url,'//thumbnail.image.rakuten.co.jp') !== false ||
            strpos($url,'//item.shopping.c.yimg.jp') !== false
          ) {
            //Amazon・楽天・Yahoo!ショッピング商品画像にwidthとheightの属性がない場合
            $width_value = 75;
            $width_attr = ' width="75"';//width属性を作成
            $height_value = 75;
            $height_attr = ' height="75"';//height属性を作成
          } else {
            $width_value = 300;
            $width_attr = ' width="300"';//width属性を作成
            $height_value = 300;
            $height_attr = ' height="300"';//height属性を作成
          }

        }
      }

      //sizes属性の作成（きれいなレスポンシブ化のために）
      if ($width_value) {
        $sizes_attr = ' sizes="(max-width: '.$width_value.'px) 100vw, '.$width_value.'px"';
      }

      //amp-imgタグの作成
      $tag = '<amp-img'.$src_attr.$width_attr.$height_attr.$alt_attr.$title_attr.$sizes_attr.$class_attr.'></amp-img>';
      // echo('<pre>');
      // var_dump($srcs);
      // var_dump(htmlspecialchars($tag));
      // var_dump($widths);
      // var_dump($heights);
      // var_dump($alts);
      // var_dump($titles);
      // echo('</pre>');

      //imgタグをamp-imgタグに置換
      $the_content = preg_replace('{'.preg_quote($match).'}', $tag , $the_content, 1);
    }
  }


  //画像タグをAMP用に置換
  $the_content = preg_replace('/<img(.+?)\/?>/is', '<amp-img$1></amp-img>', $the_content);

  // Twitterをamp-twitterに置換する（埋め込みコード）
  $pattern = '/<blockquote class="twitter-tweet".*?>.+?<a href="https:\/\/twitter.com\/.*?\/status\/([^\?"]+).*?">.+?<\/blockquote>/is';
  $append = '<p><amp-twitter width=592 height=472 layout="responsive" data-tweetid="$1"></amp-twitter></p>';
  $the_content = preg_replace($pattern, $append, $the_content);

  // JetpackによるFacebook埋め込みをamp-facebookに置換する（埋め込みコード）
  $pattern = '/<fb:post href="([^"]+?)"><\/fb:post>/is';
  $append = '<amp-facebook width=324 height=438 layout="responsive" data-href="$1"></amp-facebook>';
  $the_content = preg_replace($pattern, $append, $the_content);

  // vineをamp-vineに置換する
  $pattern = '/<iframe[^>]+?src="https:\/\/vine.co\/v\/(.+?)\/embed\/simple".+?><\/iframe>/is';
  $append = '<p><amp-vine data-vineid="$1" width="592" height="592" layout="responsive"></amp-vine></p>';
  $the_content = preg_replace($pattern, $append, $the_content);

  // Instagramをamp-instagramに置換する
  $pattern = '/<blockquote class="instagram-media".+?"https:\/\/www.instagram.com\/p\/(.+?)\/".+?<\/blockquote>/is';
  $append = '<p><amp-instagram layout="responsive" data-shortcode="$1" width="592" height="592" ></amp-instagram></p>';
  $the_content = preg_replace($pattern, $append, $the_content);

  // audioをamp-amp-audioに置換する
  $pattern = '/<audio .+?src="([^"]+?)".+?<\/audio>/is';
  $append = '<p><amp-audio src="$1"></amp-audio></p>';
  $the_content = preg_replace($pattern, $append, $the_content);

  // //YouTubeのURL埋め込み時にiframeのsrc属性のURLに余計なクエリが入るのを除去（力技;）
  // $the_content = preg_replace('/\??(((?<!service)version=\d*)|(&|&|&)rel=\d*|(&|&|&)fs=\d*|(&|&|&)autohide=\d*|(&|&|&)showsearch=\d*|(&|&|&)showinfo=\d*|(&|&|&)iv_load_policy=\d*|(&|&|&)wmode=transparent)+/is', '', $the_content);
  // YouTubeを置換する（埋め込みコード）
  $pattern = '/<iframe[^>]+?src="https?:\/\/www.youtube.com\/embed\/([^\?"]+).*?".*?><\/iframe>/is';
  $append = '<amp-youtube layout="responsive" data-videoid="$1" width="800" height="450"></amp-youtube>';
  $the_content = preg_replace($pattern, $append, $the_content);

  // Facebookを置換する（埋め込みコード）
  $pattern = '/<div class="fb-video" data-allowfullscreen="true" data-href="([^"]+?)"><\/div>/is';
  $append = '<amp-facebook layout="responsive" data-href="$1" width="500" height="450"></amp-facebook>';
  $the_content = preg_replace($pattern, $append, $the_content);

  //iframe埋め込み対策
  $the_content = preg_replace('/ +allowTransparency(=["\'][^"\']*?["\'])?/i', '', $the_content);
  $the_content = preg_replace('/ +allowFullScreen(=["\'][^"\']*?["\'])?/i', '', $the_content);
  $the_content = preg_replace('/ +webkitAllowFullScreen(=["\'][^"\']*?["\'])?/i', '', $the_content);
  $the_content = preg_replace('/ +mozallowfullscreen(=["\'][^"\']*?["\'])?/i', '', $the_content);

  //タイトルつきiframeでhttpを呼び出している場合は通常リンクに修正
  $pattern = '/<iframe[^>]+?src="(http:\/\/[^"]+?)"[^>]+?title="([^"]+?)"[^>]+?><\/iframe>/is';
  $append = '<a href="$1">$2</a>';
  $the_content = preg_replace($pattern, $append, $the_content);
  $pattern = '/<iframe[^>]+?title="([^"]+?)[^>]+?src="(http:\/\/[^"]+?)""[^>]+?><\/iframe>/is';
  $append = '<a href="$1">$2</a>';
  $the_content = preg_replace($pattern, $append, $the_content);
  //iframeでhttpを呼び出している場合は通常リンクに修正
  $pattern = '/<iframe[^>]+?src="(http:\/\/[^"]+?)"[^>]+?><\/iframe>/is';
  $append = '<a href="$1">$1</a>';
  $the_content = preg_replace($pattern, $append, $the_content);

  //iframeをamp-iframeに置換する
  $pattern = '/<iframe/i';
  $append = '<amp-iframe layout="responsive" sandbox="allow-scripts allow-same-origin allow-popups"';
  $the_content = preg_replace($pattern, $append, $the_content);
  $pattern = '/<\/iframe>/i';
  $append = $amp_placeholder.'</amp-iframe>';
  $the_content = preg_replace($pattern, $append, $the_content);

  //スクリプトを除去する
  $pattern = '/<p><script.+?<\/script><\/p>/i';
  $append = '';
  $the_content = preg_replace($pattern, $append, $the_content);
  $pattern = '/<script(?!.*type="application\/json").+?<\/script>/is';
  $append = '';
  $the_content = preg_replace($pattern, $append, $the_content);
  // $pattern = '/<script.+?<\/script>/is';
  // $append = '';
  // $the_content = preg_replace($pattern, $append, $the_content);

  //空のamp-imgタグは削除
  $pattern = '{<amp-img></amp-img>}i';
  $append = '';
  $the_content = preg_replace($pattern, $append, $the_content);


  //空のpタグは削除
  $pattern = '{<p></p>}i';
  $append = '';
  $the_content = preg_replace($pattern, $append, $the_content);


  // echo('<pre>');
  // var_dump(htmlspecialchars($the_content));
  // echo('</pre>');

  return $the_content;
}
endif;

//テンプレートの中身をAMP化する
if ( !function_exists( 'get_template_part_amp' ) ):
function get_template_part_amp($template_name){
  ob_start();//バッファリング
  get_template_part($template_name);//テンプレートの呼び出し
  $template = ob_get_clean();//テンプレート内容を変数に代入
  $template = convert_content_for_amp($template);
  echo $template;
}
endif;

//AMP用のAdSenseコードを取得する
if ( !function_exists( 'generate_amp_adsense_code' ) ):
function generate_amp_adsense_code(){
  $adsense_code = null;
  if ( get_amp_adsense_code() || is_active_sidebar( 'adsense-300' ) ) {
    $ad300 = get_amp_adsense_code();
    ob_start();
    dynamic_sidebar('adsense-300');
    $ad300 .= ob_get_clean();
    //var_dump(htmlspecialchars($ad300));
    preg_match('/data-ad-client="(ca-pub-[^"]+?)"/i', $ad300, $m);
    if (empty($m[1])) return;
    $data_ad_client = $m[1];
    if (!$data_ad_client) return;
    preg_match('/data-ad-slot="([^"]+?)"/i', $ad300, $m);
    $data_ad_slot = $m[1];
    if (!$data_ad_slot) return;
    $adsense_code = '<amp-ad width="300" height="250" type="adsense" data-ad-client="'.$data_ad_client.'" data-ad-slot="'.$data_ad_slot.'"></amp-ad>';
    //var_dump(htmlspecialchars($adsense_code));
  }
  return $adsense_code;
}
endif;

//最初のH2の手前に広告を挿入（最初のH2を置換）
if ( !function_exists( 'add_ads_before_1st_h2_in_amp' ) ):
function add_ads_before_1st_h2_in_amp($the_content) {
  if ( is_amp() ) {//AMPの時のみ有効
    //広告（AdSense）タグを記入
    ob_start();//バッファリング
    get_template_part('ad-amp');//広告貼り付け用に作成したテンプレート
    $ad_template = ob_get_clean();
    $h2result = get_h2_included_in_body( $the_content );//本文にH2タグが含まれていれば取得
    if ( $h2result ) {//H2見出しが本文中にある場合のみ
      //最初のH2の手前に広告を挿入（最初のH2を置換）
      $count = 1;
      $the_content = preg_replace(H2_REG, $ad_template.PHP_EOL.PHP_EOL.$h2result, $the_content, $count);
    }
  }
  return $the_content;
}
endif;
add_filter('the_content','add_ads_before_1st_h2_in_amp');

//AMP用のURLを取得する
if ( !function_exists( 'get_amp_permalink' ) ):
function get_amp_permalink(){
  $permalink = get_permalink();
  //URLの中に?が存在しているか
  if (strpos($permalink,'?') !== false) {
    $amp_permalink = $permalink.'&amp;amp=1';
  } else {
    $amp_permalink = $permalink.'?amp=1';
  }
  return $amp_permalink;
}
endif;

// //画像URLから幅と高さを取得する（同サーバー内ファイルURLのみ）
// function get_image_width_and_height($image_url){
//   //URLにサイトアドレスが含まれていない場合
//   if (!includes_site_url($image_url)) {
//     return false;
//   }
//   $wp_upload_dir = wp_upload_dir();
//   $uploads_dir = $wp_upload_dir['basedir'];
//   $uploads_url = $wp_upload_dir['baseurl'];
//   $image_file = str_replace($uploads_url, $uploads_dir, $image_url);
//   $imagesize = getimagesize($image_file);
//   if ($imagesize) {
//     $res = array();
//     $res['width'] = $imagesize[0];
//     $res['height'] = $imagesize[1];
//     return $res;
//   }
// }

//AMPページではCrayon Syntax Highlighterを表示しない
add_action( 'wp_loaded','remove_crayon_syntax_highlighter' );
if ( !function_exists( 'remove_crayon_syntax_highlighter' ) ):
function remove_crayon_syntax_highlighter() {
  if (isset($_GET['amp']) && $_GET['amp'] === '1') {
    //Crayon Syntax HighlighterはAMPページで適用しない
    remove_filter('the_posts', 'CrayonWP::the_posts', 100);
  }
}
endif;

if ( !function_exists( 'get_the_singular_content' ) ):
function get_the_singular_content(){
  $all_content = null;
  //while(have_posts()): the_post();
    ob_start();//バッファリング
    get_template_part('tmp/body-top');//bodyタグ直下から本文まで
    $body_top_content = ob_get_clean();

    ob_start();//バッファリング
    if (is_single()) {
      get_template_part('tmp/single-contents');
    } else {
      get_template_part('tmp/page-contents');
    }
    $body_content = ob_get_clean();
    //_v($body_content);

    ob_start();//バッファリング
    dynamic_sidebar( 'sidebar' );
    $sidebar_content = ob_get_clean();

    ob_start();//バッファリング
    dynamic_sidebar( 'sidebar-scroll' );
    $sidebar_scroll_content = ob_get_clean();

    ob_start();//バッファリング
    dynamic_sidebar('footer-left');
    dynamic_sidebar('footer-center');
    dynamic_sidebar('footer-right');
    $sidebar_scroll_content = ob_get_clean();

    $all_content = $body_top_content.$body_content.$sidebar_content.$sidebar_scroll_content;
  //endwhile;
  //$all_content = convert_content_for_amp($all_content);
  return $all_content;
}
endif;

//<style amp-custom>タグの作成
if ( !function_exists( 'generate_style_amp_custom_tag' ) ):
function generate_style_amp_custom_tag(){?>
<style amp-custom><?php
  // if ( WP_Filesystem() ) {//WP_Filesystemの初期化
  //   global $wp_filesystem;//$wp_filesystemオブジェクトの呼び出し

  $css_all = '';
  //AMPスタイルの取得
  $css_url = get_template_directory_uri().'/amp.css';
  $css = css_url_to_css_minify_code($css_url);
  if ($css !== false) {
    $css_all .= $css;
  }
  // $css_file = get_template_directory().'/amp.css';
  // if ( file_exists($css_file) ) {
  //   $css = $wp_filesystem->get_contents($css_file);//ファイルの読み込み
  //   $css_all .= $css;
  // }

  ///////////////////////////////////////////
  //IcoMoonのスタイル
  ///////////////////////////////////////////
  $css_icomoom = css_url_to_css_minify_code(get_template_directory_uri().'/webfonts/icomoon/style.css');
  if ($css_icomoom !== false) {
    $css_all .= $css_icomoom;
  }

  ///////////////////////////////////////////
  //スキンのスタイル
  ///////////////////////////////////////////
  if ( $skin_url = get_skin_url() ) {//設定されたスキンがある場合
    //通常のスキンスタイル
    $amp_css = css_url_to_css_minify_code($skin_url);
    if ($amp_css !== false) {
      $css_all .= $amp_css;
    }
    // $skin_file = url_to_local(get_skin_url());
    // $amp_css_file = str_replace('style.css', 'amp.css', $skin_file);
    // if (file_exists($amp_css_file)) {
    //   $amp_css = $wp_filesystem->get_contents($amp_css_file);//ファイルの読み込み
    //   $css_all .= $amp_css;
    // }
  }

  ///////////////////////////////////////////
  //カスタマイザーのスタイル
  ///////////////////////////////////////////
  ob_start();//バッファリング
  get_template_part('tmp/css-custom');//カスタムテンプレートの呼び出し
  $css_custom = ob_get_clean();
  $css_all .= minify_css($css_custom);

  ///////////////////////////////////////////
  //子テーマのスタイル
  ///////////////////////////////////////////
  if ( is_child_theme() ) {
    //通常のスキンスタイル
    $css_child_url = get_stylesheet_directory_uri().'/amp.css';
    $child_css = css_url_to_css_minify_code($css_child_url);
    if ($child_css !== false) {
      $css_all .= $child_css;
    }
    // $css_file_child = get_stylesheet_directory().'/amp.css';
    // if ( file_exists($css_file_child) ) {
    //   $css_child = $wp_filesystem->get_contents($css_file_child);//ファイルの読み込み
    //   $css_all .= $css_child;
    // }
  }

  //!importantの除去
  $css_all = preg_replace('/!important/i', '', $css_all);

  //CSSの縮小化
  $css_all = minify_css($css_all);

  //全てのCSSの出力
  echo $css_all;
  //}?></style>
<?php
}
endif;

if ( !function_exists( 'get_cleaned_css_selector' ) ):
function get_cleaned_css_selector($selector){
  //class用のドットを取り除く
  $selector = str_replace('.', ' ', $selector);
  //ID用のシャープを取り除く
  $selector = str_replace('#', ' ', $selector);
  //>をスペースに変換
  $selector = str_replace('>', ' ', $selector);
  ///////////////////////////////////////
  // 擬似要素
  ///////////////////////////////////////
  //:beforeを取り除く
  $selector = str_replace(':before', '', $selector);
  //:afterを取り除く
  $selector = str_replace(':after', '', $selector);

  ///////////////////////////////////////
  // 疑似クラス
  ///////////////////////////////////////
  // //:hoverを取り除く
  // $selector = str_replace(':hover', '', $selector);
  // //:first-childを取り除く
  // $selector = str_replace(':first-child', '', $selector);
  // //:last-childを取り除く
  // $selector = str_replace(':last-child', '', $selector);
  // //:first-of-typeを取り除く
  // $selector = str_replace(':first-of-type', '', $selector);
  // //:last-of-typeを取り除く
  // $selector = str_replace(':last-of-type', '', $selector);

  $classes = array(':active',':any',':checked',':default',':disabled',':empty',':enabled',':first',':first-child',':first-of-type',':fullscreen',':focus',':hover',':indeterminate',':in-range',':invalid',':last-child',':last-of-type',':left',':link',':only-child',':only-of-type',':optional',':out-of-range',':read-only',':read-write',':required',':right',':root',':scope',':target',':valid',':visited');
  foreach ($classes as $class) {
    $selector = str_replace($class, '', $selector);
  }
  //:を取り除く
  $selector = str_replace(':', '', $selector);
  //連続した半角スペースを1つに置換
  $selector = str_replace('  ', ' ', $selector);
  return $selector;
}
endif;

//CSSセレクターセットが本文内に存在するか（厳密な判別ではない、結構大ざっぱ）
if ( !function_exists( 'is_comma_splited_selector_exists_in_body_tag' ) ):
function is_comma_splited_selector_exists_in_body_tag($comma_splited_selector, $body_tag){
  //amp-imgが含まれるCSSセレクタは除外しない
  if (strpos($comma_splited_selector, 'amp-img') !== false) {
    return true;
  }
  $comma_splited_selector = get_cleaned_css_selector($comma_splited_selector);
  $space_splited_selectors = explode(' ', $comma_splited_selector);
  // if (count($space_splited_selectors) > 8) {
  //   _v($comma_splited_selector);
  // }
  foreach ($space_splited_selectors as $selector) {
    // if (preg_match('/amp-img/', $selector)) {
    //   _v(strpos($body_tag, $selector) !== false);
    //   _v($body_tag);
    // }
    //$selector = get_cleaned_css_selector($selector);

    //調べるまでもなく最初から存在するとわかっているセレクターは次に飛ばす（多少なりとも処理時間の短縮）
    $elements = array('html', 'body', 'div', 'span', 'a', 'aside', 'section', 'figure', 'main', 'header', 'footer', 'sidebar', 'article', 'ul', 'ol', 'li', 'p', 'h1', 'h2', 'h3');
    if (in_array($selector, $elements)) {
      continue;
    }

    //本文内にセレクタータグが存在しない場合
    if ($selector && strpos($body_tag, $selector) === false) {
      return false;
    }
  }
  return true;
}
endif;

//AMP用のCSSから不要なCSSコードを取り除く（なるべくAMPの50KB制限に引っかからないようにサイズ節約）
if ( !function_exists( 'get_dieted_amp_css_tag' ) ):
function get_dieted_amp_css_tag($style_amp_custom_tag, $body_tag){
  $css = $style_amp_custom_tag;
  if (preg_match_all('/\}([\.#\-a-zA-Z0-9\s>,:]+?)\{/i', $css, $m)
      && isset($m[1])) {
    $selectors = $m[1];
    //重複は統一
    $selectors = array_unique($selectors);
    //_v($selectors);
    $delete_target_selectors = array();
    //セレクター判別用の清掃
    foreach ($selectors as $selector) {
      //カンマで区切られたCSS配列を分割
      $comma_splited_selectors = explode(',', $selector);
      $comma_splited_selectors = array_unique($comma_splited_selectors);

      foreach ($comma_splited_selectors as $comma_splited_selector) {
        //置換用のターゲットCSSセレクタの保存
        $delete_target_selector = $comma_splited_selector;
        if (!is_comma_splited_selector_exists_in_body_tag($comma_splited_selector, $body_tag)) {
          $delete_target_selectors[] = $delete_target_selector;
        }
      }


    }
    //_v($delete_target_selectors);
    //削除候補のCSSセレクタを置換で削除
    foreach ($delete_target_selectors as $delete_target_selector) {
      $css = preg_replace('/\}'.preg_quote($delete_target_selector, '/').',/i', '}', $css);
      $css = preg_replace('/\}'.preg_quote($delete_target_selector, '/').'{/i', '}{', $css);
    }
    //カッコ{css codf}のみになっているCSSを削除
    $css = preg_replace('/(\{.+?\})(\{.+?\})+/i', '$1', $css);
    // $css = preg_replace('/\}\{.+?\}/i', '}', $css);
    // $css = preg_replace('/\}\{.+?\}/i', '}', $css);
    // $css = preg_replace('/\}\{.+?\}/i', '}', $css);
    // $css = preg_replace('/\}\{.+?\}/i', '}', $css);

    // if (preg_match_all('/\}(\{.+?\})/i', $css, $m) && $m[1]) {
    //   //_v($m[1]);
    //   $delete_css_codes = $m[1];
    //   foreach ($delete_css_codes as $delete_css_code) {
    //     $css = str_replace($delete_css_code, '', $css);
    //   }
    // }
    // if (preg_match_all('/[\.#\-a-zA-Z0-9\s>,:@]+?\{.+?\}/i', $css, $m)) {
    //   _v($m[0]);
    // }
  }
  //_v($css);
  return $css;
}
endif;

//AMP化コールバックの開始
add_action( 'wp_loaded','wp_loaded_ampfy_html', 1 );
if ( !function_exists( 'wp_loaded_ampfy_html' ) ):
function wp_loaded_ampfy_html() {
  ob_start('html_ampfy_call_back');
}
endif;

//AMP化処理
if ( !function_exists( 'html_ampfy_call_back' ) ):
function html_ampfy_call_back( $html ) {
  if (is_admin()) {
    return $html;
  }
  //_v('$html');

  if (!is_amp()) {
    return $html;
  }

  $head_tag = null;
  $body_tag = null;
  $style_amp_custom_tag = null;
  //ヘッダータグの取得
  if (preg_match('{<!doctype html>.+</head>}is', $html, $m)) {
    if (isset($m[0])) {
      $head_tag = $m[0];
    }
  }

  //ボディータグの取得
  if (preg_match('{<body .+</html>}is', $html, $m)) {
    if (isset($m[0])) {
      $body_tag = $m[0];
    }
  }

  //AMP用CSSスタイルの取得
  if (preg_match('{<style amp-custom>.+</style>}is', $head_tag, $m)) {
    if (isset($m[0])) {
      $default_style_amp_custom_tag = $m[0];
      //_v($default_style_amp_custom_tag);
      //不要なCSSを削除してサイズ削減
      $dieted_style_amp_custom_tag = get_dieted_amp_css_tag($default_style_amp_custom_tag, $body_tag);
      //_v($dieted_style_amp_custom_tag);
      //ヘッダーの<style amp-custom>をサイズ削減したものに入れ替える
      $head_tag = str_replace($default_style_amp_custom_tag, $dieted_style_amp_custom_tag, $head_tag);
    }
  }

  if ($head_tag && $body_tag) {
    //bodyタグ内をAMP化
    $body_tag = convert_content_for_amp($body_tag);
    return $head_tag . $body_tag;
  }

  //_v($body);
  //_v('$html');

  return $html;
}
endif;
