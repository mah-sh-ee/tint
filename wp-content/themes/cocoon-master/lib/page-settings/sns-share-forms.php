<div class="metabox-holder">

<?php
//本文上ボタン用フォーム
require_once 'sns-share-forms-top.php';
//本文下ボタン用フォーム
require_once 'sns-share-forms-bottom.php';
?>

<!-- ツイート設定 -->
<div id="sns-share-twitter" class="postbox">
  <h2 class="hndle"><?php _e( 'ツイート設定', THEME_NAME ) ?></h2>
  <div class="inside">
    <p><?php _e( 'Twitter上でのツイート動作の設定です。', THEME_NAME ) ?></p>
    <table class="form-table">
      <tbody>

        <!-- メンション -->
        <tr>
          <th scope="row">
            <?php generate_label_tag(OP_TWITTER_ID_INCLUDE, __( 'メンション', THEME_NAME )); ?>
          </th>
          <td>
            <?php
            generate_checkbox_tag( OP_TWITTER_ID_INCLUDE, is_twitter_id_include(), __( 'ツイートにメンションを含める', THEME_NAME ));
            generate_tips_tag(__( 'シェアされたツイートに著者のTwitter IDを含める。', THEME_NAME ));
            ?>
          </td>
        </tr>

        <!-- プロモーション -->
        <tr>
          <th scope="row">
            <?php generate_label_tag(OP_TWITTER_RELATED_FOLLOW_ENABLE, __( 'プロモーション', THEME_NAME )); ?>
          </th>
          <td>
            <?php
            generate_checkbox_tag( OP_TWITTER_RELATED_FOLLOW_ENABLE, is_twitter_related_follow_enable(), __( 'ツイート後にフォローを促す', THEME_NAME ));
            generate_tips_tag(__( 'ツイート後に著者のフォローボタンを表示します。', THEME_NAME ));
            ?>
          </td>
        </tr>


        <!-- ハッシュタグ -->
        <tr>
          <th scope="row">
            <?php generate_label_tag(OP_TWITTER_HASH_TAG, __( 'ハッシュタグ', THEME_NAME )); ?>
          </th>
          <td>
            <?php
            generate_textbox_tag(OP_TWITTER_HASH_TAG, get_twitter_hash_tag(), '#'.get_bloginfo('name').' '.__( '#ハッシュタグ', THEME_NAME ));
            generate_tips_tag(__( 'ツイート時に含めるハッシュタグを入力してください。半角スペースで区切って複数入力も可能です。URLやタイトルを含めて140文字を超える場合は正常動作しない可能性もあります。', THEME_NAME ));

            ?>
          </td>
        </tr>
      </tbody>
    </table>

  </div>
</div>


<!-- キャッシュ設定 -->
<div id="sns-share-cache" class="postbox">
  <h2 class="hndle"><?php _e( 'キャッシュ設定', THEME_NAME ) ?></h2>
  <div class="inside">
    <p><?php _e( 'シェア数取得時のキャッシュ利用設定です。キャッシュを利用するとページ表示スピードを多少なりともあげることができます。', THEME_NAME ) ?></p>
    <table class="form-table">
      <tbody>

        <!-- キャシュの有効化 -->
        <tr>
          <th scope="row">
            <?php generate_label_tag(OP_SNS_SHARE_COUNT_CACHE_ENABLE, __( 'キャシュの有効化', THEME_NAME )); ?>
          </th>
          <td>
            <?php
            generate_checkbox_tag( OP_SNS_SHARE_COUNT_CACHE_ENABLE, is_sns_share_count_cache_enable(), __( 'キャッシュを有効にする', THEME_NAME ));
            generate_tips_tag(__( 'SNSシェア数をキャッシュ化することでページ表示スピードの短縮化を図ります。', THEME_NAME ));
            ?>
          </td>
        </tr>

        <!-- キャッシュ間隔 -->
        <tr>
          <th scope="row">
            <?php generate_label_tag(OP_SNS_SHARE_COUNT_CACHE_INTERVAL, __('キャッシュ間隔', THEME_NAME) ); ?>
          </th>
          <td>
            <?php
            $options = array(
              '1' => __( '1時間', THEME_NAME ),
              '2' => __( '2時間', THEME_NAME ),
              '3' => __( '3時間', THEME_NAME ),
              '4' => __( '4時間', THEME_NAME ),
              '5' => __( '5時間', THEME_NAME ),
              '6' => __( '6時間', THEME_NAME ),
              '8' => __( '8時間', THEME_NAME ),
              '10' => __( '10時間', THEME_NAME ),
              '12' => __( '12時間', THEME_NAME ),
              '16' => __( '16時間', THEME_NAME ),
              '20' => __( '20時間', THEME_NAME ),
              '24' => __( '24時間', THEME_NAME ),
              '48' => __( '2日間', THEME_NAME ),
              '36' => __( '3日間', THEME_NAME ),
            );
            generate_selectbox_tag(OP_SNS_SHARE_COUNT_CACHE_INTERVAL, $options, get_sns_share_count_cache_interval());
            generate_tips_tag(__( 'キャッシュの取得間隔を設定します。間隔が狭いほど更新は増えますがサーバー負担は増えます（主に相手サーバー）。', THEME_NAME ));
            ?>
          </td>
        </tr>

      </tbody>
    </table>

  </div>
</div>




</div><!-- /.metabox-holder -->