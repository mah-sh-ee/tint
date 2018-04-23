<?php
//一覧ページへのURL
$list_url = IR_LIST_URL;
 ?>
<form name="form1" method="post" action="<?php echo $list_url; ?>" class="item-ranking-delete">
  <?php
  $id = isset($_GET['id']) ? $_GET['id'] : null;

  if ($id) {
    $record = get_item_ranking($id);
    if (!$record) {
      //指定IDの関数テキストが存在しない場合は一覧にリダイレクト
      redirect_to_url($list_url);
    }
    $edit_url = add_query_arg(array('action' => 'edit',   'id' => $id));
  }
  ?>
  <p><?php _e( '以下の内容を削除しますか？', THEME_NAME ) ?></p>

  <div id="sb-list" class="postbox" style="max-width: 800px; padding: 20px;">
    <a href="<?php echo $edit_url; ?>" class="ir-list-title"><?php echo $record->title; ?></a>
  </div>
  <?php //デモの表示
  //require_once 'demo.php'; ?>

  <div class="yes-back">
    <?php submit_button(__( '削除する', THEME_NAME )); ?>
    <p><a href="<?php echo $list_url; ?>"><?php _e( '削除しないで一覧に戻る', THEME_NAME ) ?></a></p>
  </div>

  <input type="hidden" name="action" value="delete">
  <input type="hidden" name="id" value="<?php echo $id; ?>">
  <input type="hidden" name="<?php echo HIDDEN_DELETE_FIELD_NAME; ?>" value="Y">
</form>