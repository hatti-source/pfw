<?php
  ////////////////////////////////////////////////////////////////
  //  Dispatcher  /  R. All Rights Reserved  /  R < a@a.a >
  ////////////////////////////////////////////////////////////////
  /**
   *  ネットワークにおいて、クライアントからの要求に、用途に応じて処理を振り分け、実行するクラス
   *
   *  @access   final
   *  @package  MVC
   */
  final class Dispatcher
  {
    /*
     *  変数宣言
     */
    private $public_root = '';   //  パブリックルートパス
    private $controller  = null; //  コントローラクラスインスタンス


    /**
     *  パブリックルートの絶対パスを格納する関数
     *
     *  /system_root/htdocs/index.php ( 起点スクリプト ) より格納
     */
    public function setPublicRoot( $args )
    {
      $this->public_root = $args;
    }


    /**
     *  リクエストを処理、コントローラに MVC パターン、アクションを割り当てる関数
     *
     *  @access  public
     *
     *  @throws
     *  @todo
     */
    public function dispatch()
    {
      /*
       *  ミドルウェア
       */
      #  URL パラメータを取得の後、パラメータ名、値が適正であるかをフィルタリング
      $CC = new CommonContent();        //  通常コンテンツの画面遷移用
      $filtered_ptn = $CC->filter('p'); //  MVC パターン
      $filtered_act = $CC->filter('a'); //  アクション
      #  [ 拡張 ]グループ ID をフィルタリング

      /*
       *  URL ルーティング
       */
      //  コンストラクタ初期化 ( ユーザ権限により、ルートマップを切り替えて用いる必要がある場合、引数を動的に変更する )

      /*
        ログイン状態 ( ユーザ権限 ) を保持しているセッション関連の PG を記載
      */
      $Router = new Router(0);

      //  ミドルウェアでのフィルタリング後の値を含め、ルーティング
      $routed = $Router->routing( 'GET', $filtered_ptn, $filtered_act );


      /*
       *  対象コントローラの設定
       */
      ///  URL ルーティングの返り値が NULL 以外の場合、通常処理を実行  ///
      if( $routed['patten'] === null && $routed['action'] === null ) {
        $routed['patten'] = 'index';
        $routed['action'] = 'default';
      }

      //  コントローラのクラスインスタンスを読み込む
      $this->controller = $this->getController( $routed['patten'] );

      //  コントローラの初期設定
      $this->controller->setPublicRoot( $this->public_root );

      //  ルータクラスインスタンス、パターン、アクションを書き込み
      $this->controller->setValue( $Router, $routed['patten'], $routed['action'] );

      //  実行
      $this->controller->run();
    }


    /**
     *  対象コントローラのクラスインスタンスを生成する関数
     */
    private function getController( $args )
    {
      //  引数を strtolower() により、全て小文字に、ucfirst() で 1 文字目を大文字として、クラス名を格納
      $class = ucfirst( strtolower( $args ) ) . 'Controller';

      //  対象コントローラファイルを読み込み
      include_once $this->public_root . '/controllers/' . $class . '.php';

      //  対象コントローラのクラスインスタンスを生成
      $controller_instance = new $class();

      return $controller_instance;
    }
  }
?>
