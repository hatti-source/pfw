<?php
  ////////////////////////////////////////////////////////////////
  //  起点スクリプト  /  R. All Rights Reserved  /  R < a@a.a >
  ////////////////////////////////////////////////////////////////
  #  設定ファイルを含める
  include_once '../etc/config.php';

  #  テスト 変数表示
  include_once '../../usr/Test.php';


  #  オートローディング
  //  クラスインスタンスを生成すると、該当クラスの有るファイルを自動ロード
  //  ( 対象ディレクトリ )
  //  /libs
  //  /libs/mvc
  spl_autoload_register( function ( $args ) { //  無名関数 PHP 5.3.0 以降
    include_once $args . '.php';
  });


  #  エラーハンドラ
  //$errorHandler = new ErrorHandler();
  //echo $x;       # Notice,      handled on callable
  //exec( null );  # Warning,     handled on callable
  //fho();         # Fatal error, stop running and catched


  #  データベース接続情報を格納
  ModelBase::setDbInfo( $db_info );

  #  ルートマップ情報を格納
  Router::setRouteInfo( $ary_route );


  #  ネットワークにおいて、クライアントからの要求に、用途に応じて処理を振り分け、実行する
  $Dispatcher = new Dispatcher();             //  Dispatcher クラスインスタンスを生成
  $Dispatcher->setPublicRoot( PATH__PUBLIC ); //  ルートを設定
  $Dispatcher->dispatch();                    //  実行


  # 読み込んでいる全てのファイルを出力
  // foreach ( get_included_files() as $file )
  // {
  //   echo $file . '<br>';
  // }

?>
