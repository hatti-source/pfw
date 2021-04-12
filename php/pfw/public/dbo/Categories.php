<?php
  ////////////////////////////////////////////////////////////////
  // カテゴリ名 テーブル
  ////////////////////////////////////////////////////////////////
  class Categories extends ModelBase
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
      $sql = 'SELECT * FROM categories';

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
      $sql = 'INSERT INTO categories( name, created_at ) value( :name, now() )';

      // ステートメント
      $stmt = $this->pdo->prepare( $sql );
      $stmt->bindValue( ':name', '???', PDO::PARAM_STR );
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
      $sql = 'UPDATE categories SET name = :name, updated_at = now()
              WHERE id = :id';

      // ステートメント
      $stmt = $this->pdo->prepare( $sql );
      $stmt->bindValue( ':id'  , 3      , PDO::PARAM_INT );
      $stmt->bindValue( ':name', 'cat03', PDO::PARAM_STR );
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
      $sql = 'UPDATE categories SET deleted_at = now()
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
  }
?>
