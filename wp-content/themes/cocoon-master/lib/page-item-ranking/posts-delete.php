<?php //内容の削除
if (!empty($_POST['id']) && !empty($_POST['action'])) {
  $result = null;
  $id = isset($_POST['id']) ? intval($_POST['id']) : '';
  $result = delete_item_ranking( $id );

  //設定保存メッセージ
  if ($result) {
    generate_notice_message_tag(__( 'ランキングへが削除されました。', THEME_NAME ));
  } else {
    generate_error_message_tag(__( 'ランキングへの削除に失敗しました。', THEME_NAME ));
  }
} else {
  $message = '';
  if (empty($_POST['id']) || empty($_POST['action'])) {
    $message .= __( '入力内容が不正です。', THEME_NAME ).'<br>';
  }
  generate_error_message_tag($message);
}