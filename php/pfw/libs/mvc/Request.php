<?php
  ////////////////////////////////////////////////////////////////
  //  リクエストクラス
  ////////////////////////////////////////////////////////////////
  /**
   *  パラメータを格納する変数を直接参照させないカプセル化クラス
   *
   *  < クラス変数 >
   *  private string[] $ary_param
   *
   *  < クラス関数 >
   *  パラメータ格納用のセッタ関数
   *  パラメータを読み込み、呼び出し元に、値を返すゲッタ関数
   */
  final class Request
  {
    /*
     *  変数宣言
     */
    private $ary_param = [];

    /*
     *  コンストラクタ
     */
    public function __construct( $args )
    {
      $this->setter( $args );
    }

    /**
     *  パラメータ格納 ( 書き込み ) 用の、セッタ関数
     *
     *  @access protected
     *  @param  string $args ( get | post )
     *          HTTP GET または、POST リクエストメソッド
     */
    public function setter( $args )
    {
      // GET リクエストを格納の場合
      if ( $args === 'get' ) {
        $this->ary_param = $_GET;
      }
      // POST リクエストを格納の場合
      if ( $args === 'post' ) {
        $this->ary_param = $_POST;
      }
    }

    /**
     *  パラメータを読み込み、呼び出し元に、値を返すゲッタ関数
     *
     *  @access public
     *  @return string[]
     */
    public function getter()
    {
      return $this->ary_param;
    }
  }


?>