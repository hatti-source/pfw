<?php
  ////////////////////////////////////////////////////////////////
  //  Router  /  R. All Rights Reserved  /  R < a@a.a >
  ////////////////////////////////////////////////////////////////
  /**
   *  ネットワークにおいて、クライアントの要求に対し、用途に応じて処理をする
   *
   *  関数
   *  1.  通常配列をツリー構造の多次元配列に生成後、呼び出し元に値を返す
   *  2.  ツリー構造の多次元配列を走査、値を取得後、呼び出し元に値を返す
   *  3.  ツリー構造の多次元配列を走査、取得後の値から、URL パスを生成、呼び出し元に値を返す
   *  4.  ルートマップを生成
   *
   *  @access   final
   *  @package  MVC パッケージ
   *  @todo
   */
  final class Router
  {
    /*
     *  変数宣言
     */
    private $group            = 0;
    private static $ary_route = [];


    /*
     *  コンストラクタ
     */
    public function __construct( $args )
    {
      $this->group = $args; //  現在のグループ
    }


    /**
     *  ルートマップを含める関数
     */
    public static function setRouteInfo( $args )
    {
      self::$ary_route = $args; //  グループにより、ルート設定ファイルのルートマップを振り分け、書き込む
    }


    /**
     *  ツリー構造の多次元配列内を走査、値を取得、呼び出し元に値を返す関数
     *
     *  当該関数は、パターン、アクションの両方に、パラメータ値を含んでいる必要が有り、
     *  含んでいない場合の返り値は、パターン、アクションの両方の値に NULL を含め、呼び出し元に値を返す
     *
     *  @access  public
     *  @param   string   $aHttp_method  HTTP リクエストメソッド
     *  @param   string   $aPatten
     *  @param   string   $aAction
     *  @return  string[] $ary
     *  
     *  @throws  可能性のある例外 ???
     *  @todo    現状では、空文字を含む値と NULL を返す
     */
    public function routing( $aHttp_method, $aPatten, $aAction )
    {
      /*
       *  変数宣言
       */
      $ary = []; //  返り値用
      $tree_ary = $this->buildTree();


      /*
       *  処理
       */
      foreach( $tree_ary[ $aHttp_method ] as $row => $col )
      {
        foreach( $col as $K => $V )
        {
          //  パターン値を含める
          if ( $K === 'patten' ) {
            if ( $V === $aPatten ) {
              $ary = [ 'patten' => $V ];
            }
            else {
              $ary = [ 'patten' => null, 'action' => null ];
            }
          }

          /* アクション値を含める */
          //  action キーであり、 $ary['patten'] に、パターン値を含んでいる場合
          if ( $K === 'action' && $ary['patten'] !== null ) {
            if ( $V === $aAction ) {
              $ary = $ary + [ 'action' => $V ];
              break 2;
            }
            else {
              $ary = [ 'patten' => null, 'action' => null ];
            }
          }
        }
      }

      return $ary;
    }


    /**
     *  ツリー構造の多次元配列を生成、呼び出し元に値を返す関数
     *
     *  @access  public
     *
     *  @return  string[] ツリー構造の多次元配列を返す
     *  @throws  可能性のある例外 ???
     *  @todo    ???
     */
    public function buildTree()
    {
      /*
       *  変数宣言
       */
      $ary_tree = []; //  返り値用
      $ary_node = []; //  ツリー構造構成用
      $ary_str  = []; //  分割文字列用

      /*
       *  処理
       */
      foreach ( self::$ary_route[$this->group] as $row => $col )
      {
        $ary_node = &$ary_tree[ $col[0] ]; //  HTTP メソッドを格納
        $ary_node = &$ary_node[ $col[1] ]; //  URL 生成用の文字列を格納

        $ary_str = explode( '@', $col[2] ); //  パターン名とアクション名に分割抽出
        $ary_node['patten'] = $ary_str[0];  //  パターン名を格納
        $ary_node['action'] = $ary_str[1];  //  アクション名を格納
      }
      unset( $ary_node );

      return $ary_tree;
    }
  }
?>
