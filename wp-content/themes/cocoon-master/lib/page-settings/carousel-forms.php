<div class="metabox-holder">

<!-- カルーセル -->
<div id="carousel-area" class="postbox">
  <h2 class="hndle"><?php _e( 'カルーセル設定', THEME_NAME ) ?></h2>
  <div class="inside">

    <p><?php _e( 'ヘッダー下でカルーセル表示させたい投稿の設定を行います。', THEME_NAME );
             echo get_help_page_tag('https://wp-cocoon.com/carousel-setting/') ?></p>
    <p class="preview-label"><?php _e( 'プレビュー', THEME_NAME ) ?></p>
    <div class="demo carousel-area-demo" style="">
      <?php get_template_part('tmp/carousel'); ?>
    </div>
    <?php generate_tips_tag(__( '設定が反映されない場合はリロードしてみてください。', THEME_NAME )); ?>

    <table class="form-table">
      <tbody>

        <!-- カルーセルの表示 -->
        <tr>
          <th scope="row">
            <?php generate_label_tag(OP_CAROUSEL_DISPLAY_TYPE, __('カルーセルの表示', THEME_NAME) ); ?>
          </th>
          <td>
            <?php
            $options = array(
              'none' => __( '表示しない', THEME_NAME ),
              'all_page' => __( '全ページで表示', THEME_NAME ),
              'front_page_only' => __( 'フロントページのみで表示', THEME_NAME ),
              'not_singular' => __( '投稿・固定ページ以外で表示', THEME_NAME ),
            );
            generate_selectbox_tag(OP_CAROUSEL_DISPLAY_TYPE, $options, get_carousel_display_type());
            generate_tips_tag(__( 'カルーセルを表示するページを設定します。', THEME_NAME ));
            ?>
          </td>
        </tr>

        <!-- カルーセルカテゴリーID -->
        <tr>
          <th scope="row">
            <?php generate_label_tag(OP_CAROUSEL_CATEGORY_IDS, __( '表示カテゴリー', THEME_NAME )); ?>
          </th>
          <td>
            <?php
            generate_hierarchical_category_check_list( 0, OP_CAROUSEL_CATEGORY_IDS, get_carousel_category_ids(), 300 );
            generate_tips_tag(__( 'カルーセルと関連付けるカテゴリを選択してください。最大10個までランダムで表示されます。', THEME_NAME ));
            ?>
          </td>
        </tr>

        <!-- オートプレイ-->
        <tr>
          <th scope="row">
            <?php generate_label_tag(OP_CAROUSEL_AUTOPLAY_ENABLE, __( 'オートプレイ', THEME_NAME )); ?>
          </th>
          <td>
            <?php
            generate_checkbox_tag( OP_CAROUSEL_AUTOPLAY_ENABLE, is_carousel_autoplay_enable(), __( 'オートプレイを実行', THEME_NAME ));
            generate_tips_tag(__( 'カルーセルが自動的に送られます。', THEME_NAME ));
            ?>
          </td>
        </tr>

      </tbody>
    </table>

  </div>
</div>

</div><!-- /.metabox-holder -->