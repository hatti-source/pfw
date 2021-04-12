<?php
  ////////////////////////////////////////////////////////////////
  // オブジェクト テーブル
  ////////////////////////////////////////////////////////////////
  class Objects extends ModelBase
  {
    /*
     * 変数宣言
     */
    private $sql  = '';
    private $stmt = null;
    private $rows = null;

    /*
     * コンストラクタ
     */
    public function __construct()
    {
      parent::__construct(); //  PDO インスタンスを生成
    }


    /*
     * 全リストを抽出
     */
    public function list()
    {
      // SQL 文を定義
      $sql = 'SELECT * FROM objects';

      // ステートメント
      $stmt = $this->pdo->query( $sql );
      $rows = $stmt->fetchAll( PDO::FETCH_ASSOC );

      return $rows;
    }


    /**
     * 追加
     *
     *
     */
    public function add()
    {
      // SQL 文を定義
      $sql = 'INSERT INTO objects( cat_id, object, created_at ) value( :cat_id, :object, now() )';

      // ステートメント
      $stmt = $this->pdo->prepare( $sql );
      $stmt->bindValue( ':cat_id',     1, PDO::PARAM_INT );
      $stmt->bindValue( ':object', '???', PDO::PARAM_STR );
      // 実行
      $stmt->execute();

      // 確認
      if ( $stmt->rowCount() === 1 ) {
        return $stmt->rowCount();
      } else {
        return null;
      }
    }


    /**
     * 更新
     *
     *
     */
    public function update()
    {
      // SQL 文を定義
      $sql = 'UPDATE objects SET cat_id = :cat_id, object = :object, updated_at = now()
              WHERE id = :id';

      // ステートメント
      $stmt = $this->pdo->prepare( $sql );
      $stmt->bindValue( ':id'    , 3      , PDO::PARAM_INT );
      $stmt->bindValue( ':cat_id', 2      , PDO::PARAM_INT );
      $stmt->bindValue( ':object', '?????', PDO::PARAM_STR );
      // 実行
      $stmt->execute();

      // 確認
      if ( $stmt->rowCount() === 1 ) {
        return $stmt->rowCount();
      } else {
        return null;
      }
    }


    /**
     * 削除 ( 論理削除 )
     *
     *
     */
    public function delete()
    {
      // SQL 文を定義
      $sql = 'UPDATE objects SET deleted_at = now()
              WHERE id = :id';

      // ステートメント
      $stmt = $this->pdo->prepare( $sql );
      $stmt->bindValue( ':id' , 1, PDO::PARAM_INT );
      // 実行
      $stmt->execute();

      // 確認
      if ( $stmt->rowCount() === 1 ) {
        return $stmt->rowCount();
      } else {
        return null;
      }
    }


    /**
     * 外部結合 ( LEFT JOIN )
     *
     * Objects 、 Categories テーブルの外部結合
     * 論理削除 ( deleted_at NULL ) されていない Objects テーブルの全データと、紐付く categories テーブルのカテゴリ名を抽出
     */
    public function outerjoin()
    {
      $sql = 'SELECT * FROM objects LEFT OUTER JOIN categories
              ON objects.cat_id = categories.id WHERE objects.deleted_at IS NULL';

      // ステートメント
      $stmt = $this->pdo->query( $sql );
      $rows = $stmt->fetchAll( PDO::FETCH_ASSOC );

      return $rows;
    }
  }
?>
