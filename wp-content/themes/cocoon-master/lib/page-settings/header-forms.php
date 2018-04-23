<div class="metabox-holder">

<!-- ヘッダー設定 -->
<div id="header" class="postbox">
  <h2 class="hndle"><?php _e( 'ヘッダー設定', THEME_NAME ) ?></h2>
  <div class="inside">

    <p><?php _e( 'ヘッダーの表示設定を行います。', THEME_NAME ) ?></p>

    <p class="preview-label"><?php _e( 'プレビュー', THEME_NAME ) ?></p>
    <div class="demo header-demo">
      <?php get_template_part('tmp/header-container'); ?>
    </div>

    <table class="form-table">
      <tbody>

        <!-- ヘッダーレイアウト -->
        <tr>
          <th scope="row">
            <?php generate_label_tag(OP_HEADER_LAYOUT_TYPE, __( 'ヘッダーレイアウト', THEME_NAME ) ); ?>
          </th>
          <td>
            <?php
            $options = array(
              'center_logo' => 'センターロゴ（デフォルト）',
              'center_logo_top_menu' => 'センターロゴ（トップメニュー）',
              'top_menu' => 'トップメニュー',
              'top_menu_right' => 'トップメニュー（右寄せ）',
              'top_menu_small' => 'トップメニュー小',
              'top_menu_small_right' => 'トップメニュー小（右寄せ）',
            );
            generate_selectbox_tag(OP_HEADER_LAYOUT_TYPE, $options, get_header_layout_type());
            generate_tips_tag(__( 'ヘッダーの表示形式を選択します。', THEME_NAME ));
            ?>
          </td>
        </tr>

        <!-- 高さ -->
        <tr>
          <th scope="row">
            <?php generate_label_tag(OP_HEADER_AREA_HEIGHT, __('高さ', THEME_NAME) ); ?>
          </th>
          <td>
            <?php
            generate_number_tag(OP_HEADER_AREA_HEIGHT,  get_header_area_height(), '', 0, 800);
            generate_tips_tag(__( 'ヘッダーの高さをpx数で指定します。モバイル環境では高さは無効になります。（最小：0px、最大：800px）', THEME_NAME ));
            ?>
          </td>
        </tr>

        <!-- ヘッダーロゴ -->
        <tr>
          <th scope="row">
            <?php generate_label_tag(OP_THE_SITE_LOGO_URL, __( 'ヘッダーロゴ', THEME_NAME ) ); ?>
          </th>
          <td>
            <?php
            generate_upload_image_tag(OP_THE_SITE_LOGO_URL, get_the_site_logo_url());
            generate_tips_tag(__( 'ヘッダー部分に表示する画像を設定します。', THEME_NAME ));
            ?>
          </td>
        </tr>

        <!-- キャッチフレーズの配置 -->
        <tr>
          <th scope="row">
            <?php generate_label_tag(OP_TAGLINE_POSITION, __('キャッチフレーズの配置', THEME_NAME) ); ?>
          </th>
          <td>
            <?php
            $options = array(
              'none' => __( '表示しない', THEME_NAME ),
              'header_top' => __( 'ヘッダートップ（デフォルト）', THEME_NAME ),
              'header_bottom' => __( 'ヘッダーボトム', THEME_NAME ),
            );
            generate_radiobox_tag(OP_TAGLINE_POSITION, $options, get_tagline_position());
            generate_tips_tag(__( 'キャッチフレーズの表示位置を設定します。※「ヘッダーレイアウト」が「センターロゴ」の場合。', THEME_NAME ));
            ?>
          </td>
        </tr>

        <!-- ヘッダー背景画像 -->
        <tr>
          <th scope="row">
            <?php generate_label_tag(OP_HEADER_BACKGROUND_IMAGE_URL, __( 'ヘッダー背景画像', THEME_NAME ) ); ?>
          </th>
          <td>
            <?php
            generate_upload_image_tag(OP_HEADER_BACKGROUND_IMAGE_URL, get_header_background_image_url());
            generate_tips_tag(__( 'ヘッダー背景として表示する画像を設定します。', THEME_NAME ));

            //ヘッダー背景画像の固定
            generate_checkbox_tag(OP_HEADER_BACKGROUND_ATTACHMENT_FIXED, is_header_background_attachment_fixed(), __( 'ヘッダー背景画像の固定', THEME_NAME ));
            generate_tips_tag(__( 'ヘッダーに設定した背景画像を固定します。上下にスクロールしたときに背景画像が移動しなくなります。', THEME_NAME ));
            ?>
          </td>
        </tr>

        <!-- ヘッダー全体色 -->
        <tr>
          <th scope="row">
            <?php generate_label_tag(OP_HEADER_CONTAINER_BACKGROUND_COLOR, __( 'ヘッダー全体色', THEME_NAME ) ); ?>
            <?php generate_select_color_tip_tag(); ?>
          </th>
          <td>

            <?php

            generate_color_picker_tag(OP_HEADER_CONTAINER_BACKGROUND_COLOR,  get_header_container_background_color(), 'ヘッダー全体背景色');
            generate_tips_tag(__( 'ロゴ部分やグローバルナビ全てを含めた背景色を選択します。', THEME_NAME ));

            generate_color_picker_tag(OP_HEADER_CONTAINER_TEXT_COLOR,  get_header_container_text_color(), 'ヘッダー全体文字色');
            generate_tips_tag(__( 'ロゴ部分やグローバルナビ全てを含めたテキスト色を選択します。', THEME_NAME ));
            ?>
          </td>
        </tr>

        <!-- ヘッダー色 -->
        <tr>
          <th scope="row">
            <?php generate_label_tag('', __( 'ヘッダー色（ロゴ部）', THEME_NAME ) ); ?>
            <?php generate_select_color_tip_tag(); ?>
          </th>
          <td>
            <?php

            generate_color_picker_tag(OP_HEADER_BACKGROUND_COLOR,  get_header_background_color(), 'ロゴエリア背景色');
            generate_tips_tag(__( 'グローバルナビ上のヘッダー背景色を選択します。', THEME_NAME ));

            generate_color_picker_tag(OP_HEADER_TEXT_COLOR,  get_header_text_color(), 'ロゴ文字色');
            generate_tips_tag(__( 'グローバルナビ上のヘッダーテキスト色を選択します。', THEME_NAME ));
            ?>
          </td>
        </tr>

        <?php require_once 'navi-forms.php'; ?>

      </tbody>
    </table>

  </div>
</div>


</div><!-- /.metabox-holder -->