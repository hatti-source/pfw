<?php
  ////////////////////////////////////////////////////////////////
  // エラーハンドリング
  ////////////////////////////////////////////////////////////////
  /*
    例外を拾い、エラーを表示、ログへの書き込み、エラーハンドリングを行う。
  */
  class ErrorHandler
  {
    /* 変数を定義 */
    // エラーログ 絶対パスを指定
    private const DIR__E_LOG  = '/Library/WebServer/Documents/php/pfw/public/system_root/log'; // ディレクトリ
    private const FILE__E_LOG = 'error.log'; //  ファイル
    private const PATH__E_LOG = self::DIR__E_LOG . DIRECTORY_SEPARATOR . self::FILE__E_LOG; //  パス


    /*
     * constructor
     */
    public function __construct()
    {
      /* Error handler on callable */
      set_exception_handler([ $this, 'exceptionHandler' ]);
      set_error_handler([ $this, 'errorHandler' ]);
      register_shutdown_function([ $this, 'onShutdown' ]);
    }


    /*
     * 処理続行不可能、エラーログへの書き込み、エラーページを表示
     * @param Throwable $t
     */
    public function exceptionHandler( Throwable $t )
    {
      // 例外は処理続行できないので、ログ出力のレベルは E_ERROR と同等
      $this->error_log( $this->buildMessage($t), $t->getCode(), $t->getMessage(), $t->getFile(), $t->getLine() );
      $this->showErrorPage();
    }

    /**
     * @param   int $aSeverity
     * @param   string $aMessage
     * @param   string $aFile
     * @param   int $aLine
     * @return  bool
     * @throws  ErrorException
     */
    public function errorHandler( $aSeverity, $aMessage, $aFile, $aLine )
    {
      if ( $this->isFatal( $aSeverity ) ) {
        // FATAL ERROR は処理続行不可能。 exceptionHandler() に処理を引き継ぐ。
        // 大概は、ここを通らず、 FATAL ERROR が発生する場合は直接 register_shutdown_function() に行く。
        throw new ErrorException( $aMessage, 0, $aSeverity, $aFile, $aLine );
      } else {
        // ログを出力、PHP エラーハンドラをバイパス
        $this->error_log( $this->buildMessage(), $aSeverity, $aMessage, $aFile, $aLine );
        return true;
      }
    }

    /**
     * プログラム実行が中断される重大なエラーかどうかを設定
     * @param  int $aSeverity
     * @return bool
     */
    private static function isFatal( $aSeverity )
    {
      return boolval( $aSeverity & ( E_ERROR | E_PARSE | E_CORE_ERROR | E_COMPILE_ERROR | E_USER_ERROR ) );
    }

    /**
     * @return void
     */
    public function onShutdown()
    {
      $lastError = error_get_last();

      if ( empty( $lastError ) ) {
        return;
      }

      $this->error_log( $this->buildMessage( $lastError ), $lastError['type'], $lastError['message'], $lastError['file'], $lastError['line'] );

      // 処理続行不可能な E_ERROR が発生して、errorHandler() が拾えなかった場合ここにくる
      if ( $this->isFatal( $lastError['type'] ) ) {
        $this->showErrorPage();
      }
    }

    /**
     * @return void
     */
    private function showErrorPage()
    {
      // バッファを OFF にする
      while ( ob_get_level() > 0 ) {
        ob_end_flush();
      }
      /** @noinspection PhpIncludeInspection */
      require '/Library/WebServer/Documents/php/pfw/public/system_root/views/500.html';
    }


    /**
     * ログファイルにエラーを追記
     * @param string $aBuildMessage
     * @param string $aSeverity 例外の深刻度
     * @param string $aMessage
     * @param string $aFile
     * @param int $aLine
     * @return void
     */
    private function error_log( $aBuildMessage, $aSeverity, $aMessage, $aFile, $aLine )
    {
      if ( is_writable( self::PATH__E_LOG ) ) {
        file_put_contents( self::PATH__E_LOG, $aBuildMessage . ' Severity ' . $aSeverity . ' Message ' . $aMessage . ' ' . $aFile . ' Line ' . $aLine . PHP_EOL, 
          FILE_APPEND | LOCK_EX
        );
      } else {
        if ( !file_exists( self::PATH__E_LOG ) ) {
          mkdir( self::DIR__E_LOG, 0755 );
          touch( self::PATH__E_LOG );
        }
      }
    }

    /**
     * エラーメッセージを組み立てる
     * @param Throwable $t
     * @return string
     */
    private static function buildMessage( $aThrowable = null )
    {
      $fp = fopen( self::PATH__E_LOG, 'r' );
      // 行数 ( 例外数、エラー数を取得 )
      for( $count = 0; fgets( $fp ); $count++ );

      if ( $aThrowable ) {
        $str = ' Exception:';
      } else {
        $str = ' Error:';
      }

      // 行数 + 日時 + 例外コード + 文字
      return $count . '. ' . date( 'Y/m/d H:i:s' ) . $str;
    }

  }
  // echo $x;         # notice,  handled on callable
  // pg_exec( null ); # warning, handled on callable
  // fho();           # fatal error, stop running and catched
