<?php
  ////////////////////////////////////////////////////////////////
  // コントローラの共通処理クラス
  ////////////////////////////////////////////////////////////////
  class ControllerBase
  {
    public $Model       = null; //  モデル クラスインスタンス
    public $Template    = null; //  ビュー クラスインスタンス
    public $Router      = null; //  ルータクラスインスタンス
    public $public_root = '';   //  システムディレクトリパス
    public $patten      = '';   //  パターン名 ( モデル名、ビュー名 )
    public $action      = '';   //  アクションメソッド名


    /**
     *  パブリックルートの絶対パスを書き込む関数
     *
     *  /libs/mvc/Dispatcher.php より書き込み
     */
    public function setPublicRoot( $args )
    {
      $this->public_root = $args;
    }


    /**
     *  ルータクラスインスタンス、パターン、アクションを書き込む関数
     *
     *  /libs/mvc/Dispatcher.php より書き込み
     */
    public function setValue( $aRouter, $aPatten, $aAction )
    {
      $this->Router = $aRouter;
      $this->patten = $aPatten;
      $this->action = $aAction;
    }



    /**
     *  モデルとビューを実行する関数
     */
    public function run()
    {
      //  モデルのクラスインスタンスを読み込む
      $this->Model = $this->getModel( $this->patten );

      //  ビューの初期化
      $this->Template = new Template( $this->Router );

      //  アクションメソッド
      $methodName = $this->action . 'Action';
      $this->Template->ary_data = $this->$methodName();

      //  テンプレート
      $this->Template->obHtml( $this->public_root, $this->patten );               //  コンテンツ
      $this->Template->render( $this->public_root, $this->patten, '/base.html' ); //  ベース
    }


    /**
     *  対象モデルのクラスインスタンスを生成する関数
     */
    public function getModel( $args )
    {
      //  引数を strtolower() により、全て小文字に、ucfirst() で 1 文字目を大文字として、クラス名を格納
      $class = ucfirst( strtolower( $args ) );

      //  対象コントローラファイルを読み込み
      include_once $this->public_root . '/models/' . $class . '.php';

      // 対象モデルのクラスインスタンスを生成
      $model_instance = new $class();

      return $model_instance;
    }
  }
?>
