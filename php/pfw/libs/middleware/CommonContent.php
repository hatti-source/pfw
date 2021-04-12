<?php
  ////////////////////////////////////////////////////////////////
  //  CommonContent  /  R. All Rights Reserved  /  R < a@a.a >
  ////////////////////////////////////////////////////////////////
  /**
   *  ネットワークにおいて、クライアントからの要求に対し、共通コンテンツ上での用途に応じて処理を振り分けるクラス
   *
   *  1. GET もしくは、 POST により格納するパラメータの値をリクエストクラスにて取得
   *  2. 共通コンテンツに適正なパラメータであるかをフィルタリング
   *    2-1. パラメータ名の有無、適正なパラメータ名であるかを確認
   *    2-2. 適正なパラメータ値であるかを確認 ( 英文字のみ )
   *  @access   public
   *  @package  ミドルウェア
   */
  class CommonContent
  {
    /*
     *  クラス変数宣言
     */
    private $request = null; //  リクエスト クラスインスタンス


    /*
     *  コンストラクタ
     */
    public function __construct()
    {
      // HTTP GET リクエストメソッドで、 URL パラメータを格納
      $this->request = new Request( 'get' );
    }


    /**
     *  対象の URL パラメータが適正であれば、呼び出し元に値を返す関数
     *
     *  URL パラメータが空配列及び、値が空の場合、ループ構文をスキップ、呼び出し元に NULL 値を返す
     *
     *  @param  string         $args   URL パラメータ名
     *  @return string | NULL  $matche 返り値
     */
    public function filter( $args )
    {
      /*
       *  変数宣言
       */
      $matche    = '';
      $ary_param = []; //  リクエストパラメータ配列

      /*
       *  処理
       */
      $ary_param = $this->request->getter(); //  URL パラメータ配列を格納

      //  URL パラメータ 空配列ではない場合
      if ( $ary_param !== [] ) {

        //  パラメータ名と値の適正評価
        foreach ( $ary_param as $K => $V )
        {
          //  パラメータ名が適正の場合
          if ( $args === $K && $V !== '' ) {

            //  パラメータ値を文字数分を最後の文字まで繰り返し抽出
            $i = 0;
            while ( $i < strlen( $V ) )
            {
              //  ASCII コード表上の a-z に適正の場合
              if ( 97 <= ord( $V[$i] ) && ord( $V[$i] ) <= 122 ) {
                // 文字を連結格納
                $matche .= $V[$i];
              }
              //  ASCII コード表上の a-z に不適な場合
              else {
                //  NULL を格納
                $matche = null;
                //  while foreach の実行を終了
                break 2;
              }
              $i++;
            }

            break;
          }
          //  対象のパラメータ名が不適な場合
          else {
            $matche = null;
          }
        }

      }
      //  URL パラメータ 空配列の場合
      else {
        $matche = null;
      }

      return $matche;
    }
  }
?>
