<?php
        function db_connect() {
            try {

            } catch (PDOException $e) {
                // エラー内容を直接画面に表示（本番環境では使用しない）
                exit('接続エラー: ' . $e->getMessage());
            }
        }

// データベース接続用の関数を定義
// データベースの接続に必要な情報を取得（$pdo）
//$pdo = new PDO('mysql:dbname=' . $db_name . ';charset=utf8;host=' . $db_host, $db_id, $db_pw);

// POD(PHP Data Objects)とは、PHPでデータベースを操作するためのクラス(設計図)
    // $pdo：       PDOクラスのインスタンス（実体）を指す変数
    // prepare()：  PDOクラスのメソッド