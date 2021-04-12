<?php
  ////////////////////////////////////////////////////////////////
  // テンプレートクラス
  ////////////////////////////////////////////////////////////////
  /**
   *  対象のテンプレートディレクトリを割り当て、表示を設定する関数
   */
  class Template
  {
    /*
     *  変数を設定
     */
    # データ
    public $ary_data = []; //  データベースからのデータ

    # HTML
    public $ary_html = [];   //  HTML テンプレート
    public $obj      = null; //  生成リンク

    /*
     *  コンストラクタ
     */
    public function __construct( $args )
    {
      $this->obj = $args; //  ルータクラスインスタンスを書き込み
    }

    /**
     *  ツリー構造の多次元配列内を走査、ルートマップに記載のある URL クエリストリングのエイリアスを基に、 URL クエリストリングを生成
     *
     *  パターン、アクションの両方に、パラメータ値を含んでいる必要有り。
     *  含んでいない場合の返り値は、パターン、アクションの両方の値に NULL を含めて返す。
     *
     *  @access  public
     *  @param   string  $aHttp_method  HTTP リクエストメソッド
     *  @param   string  $aQsAlias      URL クエリストリングのエイリアス
     *  @return  string  $query_str
     *  
     *  @throws  可能性のある例外 ???
     *  @todo
     */
    public function url( $aHttp_method, $aQsAlias )
    {
      /*
       *  変数宣言
       */
      $query_str = ''; //  返り値用
      $tree_ary = $this->obj->buildTree();


      /*
       *  処理
       */
      foreach( $tree_ary[ $aHttp_method ][$aQsAlias] as $PA_key => $PA_val )
      {
        ///  URL クエリストリングを構成  ///
        //  パターン値を含める
        if ( $PA_key === 'patten' ) {
          $query_str = '?p=' . $PA_val;
        }
        //  アクション値を含める
        if ( $PA_key === 'action' ) {
          $query_str .= '&a=' . $PA_val;
        }
      }

      return $query_str;
    }


    /**
     *  HTML ファイルの内容を変数に設定する関数
     */
    public function obHtml( $aSys_root, $aPatten )
    {
      /* 対象ディレクトリ内の .html ファイル群を読み込み */
      $dirs = array_filter(
        scandir( $aSys_root . '/views/templates/' . $aPatten ),
        //  base.html 、 index.html 、 先頭にドットのあるファイル及び、ディレクトリを除外
        function( $args ) {
          return preg_match( '/^(?!(\.|index|base)).*\.html|php$/', $args );
        }
      );

      foreach( $dirs as $finfo )
      {
        //  バッファリングを有効にする
        ob_start();
        //  対象
        $this->ary_html[ $finfo ] = $this->render( $aSys_root, $aPatten, '/' . $finfo );
        //  バッファの内容を取得、バッファリングを無効にする
        $this->ary_html[ $finfo ] = ob_get_clean();
      }
    }


    /**
     *  HTML を出力する関数
     */
    public function render( $aSys_root, $aPatten, $aTemplate )
    {
      include_once $aSys_root . '/views/templates/' . $aPatten . $aTemplate;
    }
  }

?>
