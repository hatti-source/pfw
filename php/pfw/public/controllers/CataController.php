<?php
  ////////////////////////////////////////////////////////////////
  // Cat A コントローラ
  ////////////////////////////////////////////////////////////////
  class CataController extends ControllerBase {

    // 初期表示
    // リストを取得
    protected function listAction() {
      return $this->Model->list();
    }

  }
?>
