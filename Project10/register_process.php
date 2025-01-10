<?php

session_start();

// データ登録の処理をするファイル
    // ＜データ登録の準備＞
        // 必要なファイルを読み込む
        // POST送信されたデータを受け取る

    // <データ登録の流れ＞
        // 1．データベースに接続
        // 2．SQL文を作成してデータを登録
        // 3．セッションに記録させる
        // 4．登録後の処理

// 必要なファイルを読み込む
require_once 'functions/db_connect.php'; // データベース接続用のファイル
require_once 'functions/sql_util.php';  // SQL操作を共通化したファイル  
require_once('functions/security.php');
loginCheck();

// POST送信されたデータを受け取る
$name = $_POST['name'];
$job = $_POST['job'];
$hp = $_POST['hp'];
$mp = $_POST['mp'];


// 登録完了メッセージをセッションに保存
$_SESSION['message'] = "$name を登録しました。";

// 1. データベースに接続
$pdo = db_connect();
// $pdoはローカルスコープ（関数内でのみ有効）なので、他のファイルで$pdoを使う場合は、returnで返す必要がある
// 返された$pdoは、$pdo = db_connect();で受け取ることができる


// 2.SQL文を作成してデータを登録
// $pdo             「調理場（データベース）」
// SQL文：           「調理のレシピ（データのCRUD）」
// $params:         「材料の名前（key)と実際の材料（values）」
// bindValue():     「材料（値）を追加する」


// SQLとは、データベースに対して行う操作のこと（Structured Query Language）
        // 1．プレースホルダーの使い方：SQL文の中の変動箇所をプレースホルダー（；で始まる代替文字列）として指定する
        // 2．bindValue()メソッドを使って、プレースホルダーに値をバインド（割り当て）する
$sql = 'INSERT INTO players (name, job, hp, mp) VALUES (:name, :job, :hp, :mp)';
// 調理のレシピ（SQL文）を作成
// INSERT INTO テーブル名 (カラム1, カラム2, カラム3, ...) VALUES (値1, 値2, 値3, ...);
// SQL文とは、データベースに対して行う操作のこと(Structured Query Language)
// SQL文を使って、crad(create:作成)、read(読み取り)、update(更新)、delete(削除))の操作を行う
// シングルクォートで囲まれた部分は、文字列として扱われる。シングルクォートなら変数展開はされない。

// 材料の準備
// key      :材料の名前     →   プレースホルダー
// value    :実際の材料     →   バインドする値
$params = [':name' => $name, ':job' => $job, ':hp' => $hp, ':mp' => $mp];

executeQuery($pdo, $sql, $params);
// sql_util.phpのexecuteQuery()関数を使って、SQL文を実行。データを登録する

// 3. セッションに記録させる
$id = $pdo->lastInsertId(); // データベースに挿入された直近のidを取得
$_SESSION['player'] = [
    'id' => $id,         // ここでidを追加
    'name' => $name,
    'job' => $job,
    'hp' => $hp,
    'mp' => $mp
];

// 4．登録後の処理
header('Location: register_confirm.php'); 
    // 登録内容確認ページへ遷移
    exit();
    // exit()は、プログラムを終了する関数
    // リダイレクト後に、それ以降の処理を行わないようにするために使われる


    // セッションにデータを保存
// register.phpで入力されたデータをセッションに保存
// $_SESSIONは、サーバー側にデータを保存するためのスーパーグローバル変数
    // グローバル変数とは、どこからでもアクセスできる変数のこと
    // スーパーグローバル変数とは、PHPが元々用意している特殊なグローバル変数のこと
        // 例えば、$_POST、$_GET、$_SESSIONなどがある
// $_SESSIONは、サーバー側にデータを保存するためのスーパーグローバル変数