<?php if ( is_active_sidebar( 'sidebar' ) ) : ?>
<div id="sidebar" class="sidebar cf" role="complementary">

  <?php //サイドバー上の広告表示
  if (is_ad_pos_sidebar_top_visible() && is_all_adsenses_visible()){
    get_template_part_with_ad_format(get_ad_pos_sidebar_top_format(), 'ad-sidebar-top', is_ad_pos_sidebar_top_label_visible());
  }; ?>

	<?php dynamic_sidebar( 'sidebar' ); ?>

  <?php //サイドバー下の広告表示
  if (is_ad_pos_sidebar_bottom_visible() && is_all_adsenses_visible()){
    get_template_part_with_ad_format(get_ad_pos_sidebar_bottom_format(), 'ad-sidebar-bottom', is_ad_pos_sidebar_bottom_label_visible());
  }; ?>

  <?php
  ////////////////////////////
  //サイドバー追従領域
  ////////////////////////////
  if ( is_active_sidebar( 'sidebar-scroll' ) ) : ?>
  <div id="sidebar-scroll" class="sidebar-scroll">
    <?php dynamic_sidebar( 'sidebar-scroll' ); ?>
  </div>
  <?php endif; ?>

</div>
<?php endif; ?>