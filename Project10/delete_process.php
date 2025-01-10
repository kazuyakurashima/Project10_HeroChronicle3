<?php

session_start();

// <データ削除の流れ＞
    // 必要なファイルを読み込み
    // データベースに接続
    // リンクから送られるIDを取得
    // SQL文を作成してデータを登録
    // データ削除後の処理


// 必要なファイルを読み込む
require_once 'functions/security.php';
    // XSS(Cross-Site Scripting)対策のため、htmlspecialchars()関数を使用
    // データに悪意がある場合、HTMLタグがそのまま表示されてしまうため、htmlspecialchars()関数を使用してエスケープする
require_once 'functions/db_connect.php'; // データベース接続用のファイル
    // db_connect.phpの中身は、下記の通り
    // $pdo = new PDO('mysql:dbname=' . $db_name . ';charset=utf8;host=' . $db_host, $db_id, $db_pw);
    // $pdo     調理場（データベース）を指す変数
require_once 'functions/sql_util.php';  // SQL操作を共通化したファイル  


// データベースに接続
$pdo = db_connect();
// $pdoはローカルスコープ（関数内でのみ有効）なので、他のファイルで$pdoを使う場合は、returnで返す必要がある
// 返された$pdoは、$pdo = db_connect();で受け取ることができる
loginCheck();

// リンクから送られるIDを取得
$id = $_POST['id'];

// SQL文を作成してデータを削除
// $pdo             「調理場（データベース）」
// SQL文：           「調理のレシピ（データのCRUD）」
// $params:         「材料の名前（key)と実際の材料（values）」
// bindValue():     「材料（値）を追加する」

// SQLとは、データベースに対して行う操作のこと（Structured Query Language）
        // 1．プレースホルダーの使い方：SQL文の中の変動箇所をプレースホルダー（；で始まる代替文字列）として指定する
        // 2．bindValue()メソッドを使って、プレースホルダーに値をバインド（割り当て）する
$sql = 'DELETE from players where id = :id';
        // 調理のレシピ（SQL文）を作成
// DELETE FROM テーブル名 WHERE カラム名 = :プレースホルダー
        // SQL文とは、データベースに対して行う操作のこと(Structured Query Language)
// SQL文を使って、crad(create:作成)、read(読み取り)、update(更新)、delete(削除))の操作を行う
// シングルクォートで囲まれた部分は、文字列として扱われる。シングルクォートなら変数展開はされない。

// 材料の準備
// key      :材料の名前     →   プレースホルダー
// value    :実際の材料     →   バインドする値
$params = [':id' => $id];
        // 材料の名前(key)と実際の材料(values)を連想配列形式で設定

executeQuery($pdo, $sql, $params);
// sql_util.phpのexecuteQuery()関数を使って、SQL文を実行。データを登録する

// データ削除後の処理
$_SESSION['message'] = 'キャラクターが正常に削除されました。新しいキャラクターを登録しましょう！';
header('Location: register_confirm.php');
exit;
    // exit()は、プログラムを終了する関数
    // リダイレクト後に、それ以降の処理を行わないようにするために使われる