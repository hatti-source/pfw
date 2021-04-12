<?php
  ////////////////////////////////////////////////////////////////
  // オブジェクト テーブル
  ////////////////////////////////////////////////////////////////
  class Index extends ModelBase
  {
    /*
     * 変数宣言
     */
    private $sql  = '';
    private $stmt = null;
    private $rows = null;

    /*
     * コンストラクタ
     */
    public function __construct()
    {
      parent::__construct(); //  PDO インスタンスを生成
    }


    /*
     * 全リストを抽出
     */
    public function list()
    {
    }


    /**
     * 追加
     *
     *
     */
    public function add()
    {
    }


    /**
     * 更新
     *
     *
     */
    public function update()
    {
    }


    /**
     * 削除 ( 論理削除 )
     *
     *
     */
    public function delete()
    {
    }
  }
?>
