<?php //Custom CSS
add_action( 'admin_menu', 'add_custom_css_custom_box' );
if ( !function_exists( 'add_custom_css_custom_box' ) ):
function add_custom_css_custom_box() {
  add_meta_box( 'custom_css', __( 'カスタムCSS', THEME_NAME ), 'view_custom_css_custom_box', 'post', 'normal', 'low' );
  add_meta_box( 'custom_css', __( 'カスタムCSS', THEME_NAME ), 'view_custom_css_custom_box', 'page', 'normal', 'low' );
}
endif;

if ( !function_exists( 'view_custom_css_custom_box' ) ):
function view_custom_css_custom_box() {
  global $post;
  echo '<input type="hidden" name="custom_css_noncename" id="custom_css_noncename" value="'.wp_create_nonce('custom-css').'" />';
  echo '<textarea name="custom_css" id="custom_css" rows="5" cols="30" style="width:100%;" placeholder="'.__( '当ページ変更用のCSSコードのみを入力してください。styleタグは不要です。', THEME_NAME ).'">'.get_post_meta($post->ID,'_custom_css',true).'</textarea>';
}
endif;


add_action( 'save_post', 'custom_css_custom_box_save_data' );
if ( !function_exists( 'custom_css_custom_box_save_data' ) ):
function custom_css_custom_box_save_data($post_id) {
  $custom_css_noncename = isset($_POST['custom_css_noncename']) ? $_POST['custom_css_noncename'] : null;
  if ( !wp_verify_nonce( $custom_css_noncename, 'custom-css' ) ) return $post_id;
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE) return $post_id;
  $custom_css = $_POST['custom_css'];
  update_post_meta( $post_id, '_custom_css', $custom_css );
}
endif;

add_action( 'wp_head','insert_custom_css' );
if ( !function_exists( 'insert_custom_css' ) ):
function insert_custom_css() {
  if ( is_page() || is_single() ) {
    if ( have_posts() ) : while ( have_posts() ) : the_post();
      $custom_css = get_post_meta(get_the_ID(), '_custom_css', true);
      if ($custom_css) {
        echo '<!-- '.THEME_NAME.' Custom CSS -->'.PHP_EOL;
        echo '<style>' . $custom_css . '</style>'.PHP_EOL;
      }
    endwhile; endif;
    rewind_posts();
  }
}
endif;
