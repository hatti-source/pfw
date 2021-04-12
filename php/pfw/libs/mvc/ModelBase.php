<?php
  ////////////////////////////////////////////////////////////////
  // データベース接続の共通処理クラス
  ////////////////////////////////////////////////////////////////
  /*
      このクラスを継承したクラスでは、PhysicalModel = 物理モデル ( データモデル ) を形作る。
    記載の物理とは、アプリケーションに必要なデータストアを表す。
      Model の重用な役割の 1 つとして、データの入出力があり、
    設計の形として、モデルクラス = データベースの 1 テーブルで、形作る。
  */
  class ModelBase
  {
    /*
     *  変数宣言
     */
    public static $db_info = [];
    protected     $pdo     = null;

    /*
     *  コンストラクタ
     */
    public function __construct()
    {
      $this->initDatabase(); //  PDO インスタンスを生成、拡張したクラスに渡す
    }


    /**
     *  PDO インスタンスを生成
     */
    public function initDatabase()
    {
      $this->pdo = new PDO( self::$db_info['dsn'], self::$db_info['db_user'], self::$db_info['db_pass'] );
      $this->pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    }


    /**
     *  接続情報を設定する関数
     */
    public static function setDbInfo( $args )
    {
      self::$db_info = $args;
    }
  }
?>
