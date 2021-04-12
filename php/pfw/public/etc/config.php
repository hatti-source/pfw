<?php
  ////////////////////////////////////////////////////////////////
  // アプリケーションの設定
  ////////////////////////////////////////////////////////////////

  #  各上位ディレクトリの絶対パスを定義
  define( 'PATH__ROOT',   realpath( dirname( __FILE__ ) . '/../..' ) ); //  ルート
  define( 'PATH__LIBS',   PATH__ROOT . '/libs'   );                     //  ライブラリーズ
  define( 'PATH__PUBLIC', PATH__ROOT . '/public' );                     //  パブリックルート


  #  上位ディレクトリの絶対パスをインクルードパス ( include_path ) に追加
  $ary_include = [
    PATH__LIBS,
    PATH__LIBS   . '/middleware',
    PATH__LIBS   . '/mvc',
    PATH__PUBLIC . '/dbo',
  ];
  $incPath  = implode( PATH_SEPARATOR, $ary_include );
  set_include_path( get_include_path() . PATH_SEPARATOR . $incPath );


  #  エラー出力関連を設定 ( php.ini による設定も可 )
  ini_set( 'display_errors',      1 ); //  エラーを HTML として画面に出力
  ini_set( 'error_reporting', E_ALL ); //  出力する PHP エラーの種類を設定


  #  データベース接続情報
  $db_info = [
    'dsn'     => 'mysql:host=127.0.0.1;dbname=pfw;charset=utf8',
    'db_user' => 'root',
    'db_pass' => 't6xgpfbz'
  ];


  #  ルート設定ファイルを含める
  include_once 'route.php';
?>
