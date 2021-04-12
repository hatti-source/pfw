#  pfw


###  用語

  アプリケーションで使用する用語の共通化

  1.  クラス
    1-1.  クラス関数
    1-2.  クラス変数


  2.  略名
    object       -->  obj
    string       -->  str
    array        -->  ary
    parameter    -->  param
    encapsulate  -->  encap


###  命名規則

  * 変数  /  スネークケース

    ( 配列 _ ) 型 __ 名詞 _( 名詞 )_( 属性 )
    $ary_str__database_information_id

  * 定数  /  スネークケース

    カテゴリ __ ( 中カテゴリ ) __ 名詞 _ ( 属性 )

  * クラスインスタンス変数  /  キャメルケースや、大文字を含む

    $CommonContent = new CommonContent();
    $CC = new CommonContent();

  * メソッド、関数  /  記号は含まない

      動詞 + ( キャメル ) 名詞


### PHP スカラー値は 4 種

  論理値 (boolean) 、整数 (integer) 、浮動小数点数 (double) 、文字列 (string)


###  関数規則

  *  修飾子

    public     クラス内、外のどこからでもアクセス可能
    protected  同じクラス及び、子クラスからアクセス可能
    private    同じクラス内からのみアクセス可能

  *  返り値

    値 or null
    ブール true or false


###  クラス、関数の作成完了箇所は、PHP ドキュメントを記載

  PHP Doc

    @access より下は必要に応じて記載


  参考 クラスの場合 ( フォーマット )
```PHP
/**
 * [区分]クラスの概要
 *
 * クラスの詳細
 * 出来るだけ細かく書いたほうがよいが、詳細な説明は各メソッドに任せる。
 * 全体での共通ルールとか仕様を書く。
 *
 * @access アクセスレベル
 * @author 名前 <メールアドレス>
 * @copyright 会社名 All Rights Reserved
 * @package パッケージ（MVC）
 */
```

  * 説明

    区分に、[API]とか[CMS]とかそういった情報を書く。
    パッケージは、コントローラだったら Contoroller 、モデルだったら Model と書く。

  具体例
```PHP
/**
 * [API] メッセージ送信系APIコントローラークラス
 *
 * メッセージ送信に関するAPIをまとめたコントローラークラス。
 * エンドポイント単位でメソッドを定義する。
 *
 * @access public
 * @author itosho <hogehoge@example.com>
 * @copyright  hogehoge Corporation All Rights Reserved
 * @package Controller
 */
```

  参考 関数の場合 ( フォーマット )
```PHP
/**
 *  [区分] 関数の概要
 *
 *  関数の詳細
 *  出来るかぎり細かく、シンプルに
 *
 * @access  アクセスレベル
 * @param   型 パラメーター名（物理名） パラメーター型名（論理名）
 * @return  型 戻り値（物理名） 戻り値（論理名）
 * @see     関連（呼び出したり）する関数
 * @throws  例外についての記述
 * @todo    未対応（改善）事項等
 */
```

  * 説明

    区分に、クラスと同じか、リクエストメソッド [POST] 、 [GET] を書く。 ( メソッドの場合、書かなくてもよいこととする。)
    引数、返り値は型も書き、物理名と論理名を書く。
    @see 、 @throws 、 @todo は必要に応じて書く。

    メソッドはコントローラーとモデルでタグが違うことが多いので、それぞれ具体例を書きます。

  具体例 コントローラ
```PHP
/**
 * [POST] メッセージ送信APIのコントローラ関数
 *
 * 即時送信の場合は、実際にメッセージ送信処理を行う。
 * 予約送信の場合は、メッセージの登録処理のみを行う。
 *
 * @access public
 * @see MessageApi::paramCheck
 * @throws NotFoundException メッセージがない場合は404エラーを返す
 */
```

  具体例 モデル
```PHP
/**
 * メッセージ登録処理用の関数
 *
 * メッセージ登録後、送信者情報も更新する。
 * 送信者情報の更新はREPLACE INTOで更新する。
 *
 * @access public
 * @param array $sender
 *        送信者情報
 * @param array $params
 *        リクエストパラメータ
 * @return integer $messageId メッセージID（エラー時は0）
 * @todo パフォーマンス改善の余地あり
 */
```

###  参考

  * PDO

    prepare()  ユーザの入力を利用する場合
    query()    ユーザの入力を利用しない場合


  * include と require の違い

    ファイルを読み込めなかった場合の挙動に違いがあります。
    ファイルを読み込んだ場合の挙動には違いがありません。
    include  Warning     ( 警告 ) を発して処理を継続
    require  Fatal Error ( 重大なエラー ) を発して処理を停止
    補足 )
    Warning     エラーが起きた処理のみを中止、処理を続行
    Fatal Error エラーが起きた時点で、処理を停止

  * 型の定義

    datetime 型の書式 YYYY-MM-DD 23:59:59


###  正規表現

  PHP には正規表現リテラルがないので、正規表現パターンは文字列として記述。
  文字列なのでシングルクォートで囲む。ダブルクォートを使うと変数が展開され、意図しない動作になる可能性がある。
  正規表現パターンは、スラッシュ / ( デリミタ ) で囲む。

  '/正規表現パターン/'


  ( 肯 | 否 )定 ( 先 | 後 )読み

    * 肯定先読み ( Positive lookahead )
    * 否定先読み ( Negative lookahead )
    * 肯定後読み ( Positive lookbehind )
    * 否定後読み ( Negative lookbehind )

  書き方
    (?=regex)   直後に regex
    (?!regex)   直後に regex が無い
    (?<=regex)  直前に regex
    (?<!regex)  直前に regex が無い

  基本系 (?=regex)
  否定なら !
  直前なら < を追加

  例）
  (?<=hoge)foo(?!bar)  直前に hoge があり、直後に bar が無い foo にマッチ
  (?<!hoge)foo(?=bar)  直前に hoge が無く、直後に bar がある foo にマッチ


### HTML

#### id 、 name について

    id
      DOM( Document Object Model ) を介して HTML 要素を識別。
      JavaScript 等で使用されるフィールドにラベルを付けます。

    name
      form 要素に対応、サーバにポストバックされるものを識別。
      HTTP( HyperText Transfer Protocol ) を GET 、 POST を使用してサーバに送信されるメッセージ内の
      フィールドにラベルを付けるために使用。

    name 名は、フォーム内で、ユニークでなければなりません。
    id   名は、文書全体中で、ユニークでなければなりません。

#### 見出しの定義

  階層 英語名 名称 備考
  1 part          編 部
  2 chapter       章      中小規模の文書に於いては、編 部ではなく章が最大の構造を取ることが多い。
  3 section       節
  4 subsection    項 小節
  5 subsubsection 目 小々節  実際に 1 目 などと表記されることは稀であり、専ら番号のみ記される。


### CSS

  設計規則 BEM マニュアル

    block__element--modifier
      block と element は、アンダースコア 2 つで区切る。
      element と modifier は、ハイフン 2 つで区切る。
      各々 が複数単語になる場合、単語と単語の間はハイフン 1 つで区切る。

    例 )
      article-list という block の中に article-title という element がある場合、
      この element のクラス名は

        article-list__article-title


###  基本的なアーキテクチャ

  コントローラ

    固有コントローラは全て、 ControllerBase クラスを継承する設計
    ControllerBase クラスは、各コントローラの共通処理を行うクラス


    ControllerBase クラス

      各コントローラクラスには、多くの共通するメソッドを含む為、コントローラの共通処理 ControllerBase クラスを作成、中に run() メソッドを置く。
      各コントローラクラスの共通メソッドは、run() メソッドの中に作成して実行する。

      先ず、run() メソッドでは、ビューの初期化を実行。 ( Template.php のクラスインスタンスを生成 )
      テンプレートは、 /views/templates 内に、コントローラ名と同名ディレクトリを作り、テンプレートファイルを配置すれば、自動使用される。
      アクションメソッドの実行後に、Template.php 内の処理は実行される。


    ControllerBase クラス / preAction()

      共通前処理 ( 各コントローラクラスでオーバーライドして使用する前提 )
      アクションメソッドの前に必ず実行される、全てのアクションに共通して行いたい前処理がある場合に使用。
      ポイントは、ビューの初期化後のタイミングであること。
      あくまで、設定するテンプレートはデフォルト。
      もし、アクションごとにテンプレートを用意するのではなく、共通テンプレートを使う場合、preAction() に設定すれば、
      ビューの初期化で設定されたものを上書きする。

      protected function preAction()
      {
      }


###  this or self, static or dynamic

クラスインスタンスに属する $this & dynamic
クラスに属する　　　　　　 Class::(method|vars) & self::