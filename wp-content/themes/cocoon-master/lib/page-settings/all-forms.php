<div class="metabox-holder">

<!-- 全体設定 -->
<div id="all" class="postbox">
  <h2 class="hndle"><?php _e( '全体設定', THEME_NAME ) ?></h2>
  <div class="inside">

    <p><?php _e( 'ページ全体の表示に関する設定です。', THEME_NAME ) ?></p>

    <p class="preview-label"><?php _e( 'プレビュー', THEME_NAME ) ?></p>
    <div class="demo iframe-standard-demo all-demo">
      <iframe id="all-demo" class="iframe-demo" src="<?php echo home_url(); ?>" width="1000" height="400"></iframe>
    </div>

    <table class="form-table">
      <tbody>

        <!-- キーカラー -->
        <tr>
          <th scope="row">
            <?php generate_label_tag(OP_SITE_KEY_COLOR, __('キーカラー', THEME_NAME) ); ?>
            <?php generate_select_color_tip_tag(); ?>
          </th>
          <td>
            <?php
            generate_color_picker_tag(OP_SITE_KEY_COLOR,  get_site_key_color(), 'サイトキーカラー');

            generate_tips_tag(__( 'サイト全体のポイントとなる部分に適用される背景色を指定します。', THEME_NAME ));

            generate_color_picker_tag(OP_SITE_KEY_TEXT_COLOR,  get_site_key_text_color(), 'サイトキーテキストカラー');
            generate_tips_tag(__( 'サイト全体のポイントとなる部分に適用されるテキスト色を指定します。', THEME_NAME ));
            ?>
          </td>
        </tr>

        <!-- サイトフォント  -->
        <tr>
          <th scope="row">
            <?php generate_label_tag(OP_SITE_FONT_FAMILY, __('サイトフォント', THEME_NAME) ); ?>
          </th>
          <td>
            <div class="col-2">
              <div style="min-width: 270px;">
                <?php
                $options = array(
                  'yu_gothic' => __( '游ゴシック体, ヒラギノ角ゴ', THEME_NAME ),
                  'meiryo' => __( 'メイリオ, ヒラギノ角ゴ', THEME_NAME ),
                  'ms_pgothic' => __( 'ＭＳ Ｐゴシック, ヒラギノ角ゴ', THEME_NAME ),
                  'noto_sans_jp' => __( '源ノ角ゴシック（WEBフォント）', THEME_NAME ),
                  'mplus_1p' => __( 'Mplus 1p（WEBフォント）', THEME_NAME ),
                  'rounded_mplus_1c' => __( 'Rounded Mplus 1c（WEBフォント）', THEME_NAME ),
                  'hannari' => __( 'はんなり明朝（WEBフォント）', THEME_NAME ),
                  'kokoro' => __( 'こころ明朝（WEBフォント）', THEME_NAME ),
                  'sawarabi_gothic' => __( 'さわらびゴシック（WEBフォント）', THEME_NAME ),
                  'sawarabi_mincho' => __( 'さわらび明朝（WEBフォント）', THEME_NAME ),
                );
                generate_selectbox_tag(OP_SITE_FONT_FAMILY, $options, get_site_font_family());
                generate_tips_tag(__( 'サイト全体適用されるフォントを選択します。', THEME_NAME ));

                $font_options = array(
                  '12px' => __( '12px', THEME_NAME ),
                  '13px' => __( '13px', THEME_NAME ),
                  '14px' => __( '14px', THEME_NAME ),
                  '15px' => __( '15px', THEME_NAME ),
                  '16px' => __( '16px', THEME_NAME ),
                  '17px' => __( '17px', THEME_NAME ),
                  '18px' => __( '18px', THEME_NAME ),
                  '19px' => __( '19px', THEME_NAME ),
                  '20px' => __( '20px', THEME_NAME ),
                  '21px' => __( '21px', THEME_NAME ),
                  '22px' => __( '22px', THEME_NAME ),
                );
                generate_selectbox_tag(OP_SITE_FONT_SIZE, $font_options, get_site_font_size());
                generate_tips_tag(__( 'サイト全体のフォントサイズを変更します。', THEME_NAME ));

                ?>

              </div>
              <div style="width: auto">
                <?php if (!is_site_font_family_local()): ?>
                  <link rel="stylesheet" href="<?php echo get_site_font_source_url(); ?>">
                <?php endif ?>
                <p class="preview-label"><?php _e( 'フォントプレビュー', THEME_NAME ) ?></p>
                <div class="demo" style="width: 100%">
                  <div class="<?php echo get_site_font_family_class(); ?> <?php echo get_site_font_size_class(); ?>">
                  <p>1234567890</p>
                  <p>abcdefghijklmnopqrstuvwxyz</p>
                  <p>ABCDEFGHIJKLMNOPQRSTUVWXYZ</p>
                  <p><?php _e( '吾輩は猫である。名前はまだ無い。どこで生れたかとんと見当がつかぬ。何でも薄暗いじめじめした所でニャーニャー泣いていた事だけは記憶している。吾輩はここで始めて人間というものを見た。', THEME_NAME ) ?></p>
                  </div>
                </div>
              </div>
            </div>
          </td>
        </tr>

        <!-- モバイルサイトフォント -->
        <tr>
          <th scope="row">
            <?php generate_label_tag(OP_MOBILE_SITE_FONT_SIZE, __('モバイルサイトフォント', THEME_NAME) ); ?>
          </th>
          <td>
            <?php
                generate_selectbox_tag(OP_MOBILE_SITE_FONT_SIZE, $font_options, get_mobile_site_font_size());
              generate_tips_tag(__( 'モバイル端末でのフォントサイズを変更します（横幅が480px以下の端末）。', THEME_NAME ));
             ?>
          </td>
        </tr>


        <!-- サイト背景色 -->
        <tr>
          <th scope="row">
            <?php generate_label_tag(OP_SITE_BACKGROUND_COLOR, __('サイト背景色', THEME_NAME) ); ?>
            <?php generate_select_color_tip_tag(); ?>
          </th>
          <td>
            <?php
            generate_color_picker_tag(OP_SITE_BACKGROUND_COLOR,  get_site_background_color(), '背景色');
            generate_tips_tag(__( 'サイト全体の背景色を選択します。', THEME_NAME ));
            ?>
          </td>
        </tr>

        <!-- サイト背景画像 -->
        <tr>
          <th scope="row">
            <?php generate_label_tag(OP_SITE_BACKGROUND_IMAGE_URL, __('サイト背景画像', THEME_NAME) ); ?>
          </th>
          <td>
            <?php
            generate_upload_image_tag(OP_SITE_BACKGROUND_IMAGE_URL, get_site_background_image_url());
            generate_tips_tag(__( 'サイト全体の背景画像を選択します。', THEME_NAME ));
            ?>
          </td>
        </tr>

        <!-- サイト幅を揃える  -->
        <tr>
          <th scope="row">
            <?php generate_label_tag(OP_ALIGN_SITE_WIDTH, __('サイト幅の均一化', THEME_NAME) ); ?>
          </th>
          <td>
            <?php
            generate_checkbox_tag(OP_ALIGN_SITE_WIDTH, is_align_site_width(), __( 'サイト幅を揃える', THEME_NAME ));
            generate_tips_tag(__('サイト全体の幅をコンテンツ幅で統一します。', THEME_NAME));
            ?>

          </td>
        </tr>

        <!-- サイトリンク色 -->
        <tr>
          <th scope="row">
            <?php generate_label_tag(OP_SITE_LINK_COLOR, __('サイトリンク色', THEME_NAME) ); ?>
            <?php generate_select_color_tip_tag(); ?>
          </th>
          <td>
            <?php
            generate_color_picker_tag(OP_SITE_LINK_COLOR,  get_site_link_color(), 'リンク色');
            generate_tips_tag(__( 'サイトで利用されるリンク色を選択します。', THEME_NAME ));
            ?>
          </td>
        </tr>

        <!-- サイドバーの位置  -->
        <tr>
          <th scope="row">
            <?php generate_label_tag(OP_SIDEBAR_POSITION, __( 'サイドバーの位置', THEME_NAME ) ); ?>
          </th>
          <td>
            <?php
            $options = array(
              'sidebar_right' => __( 'サイドバー右', THEME_NAME ),
              'sidebar_left' => __( 'サイドバー左', THEME_NAME ),
            );
            //アドミンバーに独自管理メニューを表示
            generate_radiobox_tag(OP_SIDEBAR_POSITION, $options, get_sidebar_position());
            generate_tips_tag(__( 'サイドバーの表示位置の設定です。', THEME_NAME ));
            ?>
          </td>
        </tr>

        <!-- サイドバーの表示状態  -->
        <tr>
          <th scope="row">
            <?php generate_label_tag(OP_SIDEBAR_DISPLAY_TYPE, __( 'サイドバーの表示状態', THEME_NAME ) ); ?>
          </th>
          <td>
            <?php
            $options = array(
              'display_all' => __( '全てのページで表示', THEME_NAME ),
              'no_display_all' => __( '全てのページで非表示', THEME_NAME ),
              'no_display_front_page' => __( 'フロントページで非表示（固定ページがトップページの場合）', THEME_NAME ),
              'no_display_index_pages' => __( 'インデックスページで非表示', THEME_NAME ),
              'no_display_pages' => __( '固定ページで非表示', THEME_NAME ),
              'no_display_singles' => __( '投稿ページで非表示', THEME_NAME ),
            );
            //アドミンバーに独自管理メニューを表示
            generate_radiobox_tag(OP_SIDEBAR_DISPLAY_TYPE, $options, get_sidebar_display_type());
            generate_tips_tag(__( 'サイドバーを表示するページの設定です。', THEME_NAME ));
            ?>
          </td>
        </tr>

        <!-- サイトアイコン -->
        <tr>
          <th scope="row">
            <?php generate_label_tag('', __('ファビコン', THEME_NAME) ); ?>
          </th>
          <td>
            <p><?php _e( 'ファビコン（サイトアイコン）設定は、テーマ管理画面から「外観→カスタマイズ」メニューにある「サイト基本情報」にある「サイトアイコン」設定項目から行ってください。', THEME_NAME ) ?></p>
          </td>
        </tr>

        <!-- サイトアイコン -->
        <!-- <tr>
          <th scope="row">
            <?php generate_label_tag(OP_SITE_ICON_URL, __('サイトアイコン', THEME_NAME) ); ?>
          </th>
          <td>
            <?php
            //var_dump(get_site_icon_url());
            generate_upload_image_tag(OP_SITE_ICON_URL, get_site_icon_url2());
            generate_tips_tag(__( 'サイトアイコンはサイトのアプリとブラウザーのアイコンとして使用されます。アイコンは正方形で、幅・高さともに 512 ピクセル以上である必要があります。', THEME_NAME ));
            ?>
          </td>
        </tr> -->

      </tbody>
    </table>

  </div>
</div>



</div><!-- /.metabox-holder -->