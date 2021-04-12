<?php
  ////////////////////////////////////////////////////////////////
  // カテゴリーズ コントローラ
  ////////////////////////////////////////////////////////////////
  class ObjectsController extends ControllerBase {

    // 初期表示
    // リストを取得
    protected function listAction() {
      return $this->Model->list();
    }


    // 追加
    protected function addAction() {
      return $this->Model->add();
    }


    // 更新
    protected function updateAction() {
      return $this->Model->update();
    }


    // 削除 ( 論理削除 )
    protected function deleteAction() {
      return $this->Model->delete();
    }

  }

?>
