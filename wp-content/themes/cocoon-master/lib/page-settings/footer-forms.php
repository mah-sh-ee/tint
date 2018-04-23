<div class="metabox-holder">

<!-- フッター設定 -->
<div id="footer" class="postbox">
  <h2 class="hndle"><?php _e( 'フッター設定', THEME_NAME ) ?></h2>
  <div class="inside">

    <p><?php _e( 'フッターやクレジット表示設定です。', THEME_NAME ) ?></p>
    <p class="preview-label"><?php _e( 'プレビュー', THEME_NAME ) ?></p>
    <div class="demo">
      <?php get_template_part('tmp/footer-bottom'); ?>
    </div>

    <table class="form-table">
      <tbody>

        <!-- フッター表示タイプ  -->
        <tr>
          <th scope="row">
            <?php generate_label_tag(OP_FOOTER_DISPLAY_TYPE, __( 'フッター表示タイプ', THEME_NAME ) ); ?>
          </th>
          <td>
            <?php

            $options = array(
              'logo_enable' => 'ロゴ＆メニュー＆クレジット',
              'left_and_right' => 'メニュー＆クレジット（左右）',
              'up_and_down' => 'メニュー＆クレジット（中央揃え）',
            );
            generate_radiobox_tag(OP_FOOTER_DISPLAY_TYPE, $options, get_footer_display_type())

            ?>
          </td>
        </tr>


        <!-- クレジット表記  -->
        <tr>
          <th scope="row">
            <?php generate_label_tag('', __( 'クレジット表記', THEME_NAME ) ); ?>
          </th>
          <td>
            <?php
            generate_label_tag(OP_SITE_INITIATION_YEAR, __( 'サイト開設年：', THEME_NAME ));
            generate_number_tag(OP_SITE_INITIATION_YEAR, get_site_initiation_year(), '', 1970, intval(date('Y')));

            $options = array(
              'simple' => '© '.get_site_initiation_year().' '.get_bloginfo('name').'.',
              //'simple_year' => '© '.get_site_initiation_year().' '.get_bloginfo('name'),
              'simple_year_begin_to_now' => '© '.get_site_initiation_year().'-'.date('Y').' '.get_bloginfo('name').'.',
              'full' => 'Copyright © '.get_site_initiation_year().' '.get_bloginfo('name').' All Rights Reserved.',
              'full_year_begin_to_now' => 'Copyright © '.get_site_initiation_year().'-'.date('Y').' '.get_bloginfo('name').' All Rights Reserved.',
              'user_credit' => '独自表記',
            );
            generate_radiobox_tag(OP_CREDIT_NOTATION, $options, get_credit_notation());

            generate_label_tag(OP_USER_CREDIT_NOTATION, __( '上記設定で「独自表記」と入力した場合', THEME_NAME ));
            echo '<br>';
            generate_textarea_tag(OP_USER_CREDIT_NOTATION, get_user_credit_notation(), __( 'クレジット表記を入力してください。タグ入力も可能です。', THEME_NAME ), 4)

            ?>
          </td>
        </tr>
      </tbody>
    </table>

  </div>
</div>



</div><!-- /.metabox-holder -->