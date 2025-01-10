<?php
// セッションを開始
session_start();

// ファイルの読み込み 
require_once 'functions/sql_util.php'; 
require_once 'functions/db_connect.php';
$pdo = db_connect();

// POSTデータを取得（ユーザーIDとパスワード）
$lid = $_POST['lid'];
$lpw = $_POST['lpw'];

// データベースからユーザー情報を取得（入力されたユーザーIDに基づく）
$sql = 'SELECT * FROM users WHERE lid = :lid';
$params = [':lid' => $lid];
$val = fetchQuery($pdo, $sql, $params); // fetchQueryでデータ取得

// パスワードが正しいか確認
if ($val && password_verify($lpw, $val['lpw'])) {
    // データベースのユーザー情報が存在し（$valが空でない）し、かつ
    // 平のパスワードとハッシュ化されたパスワードが一致する場合
    $_SESSION['chk_ssid'] = session_id();
    $_SESSION['user_id'] = $val['id'];

    // ロイン成功時の処理
    header('Location: register.php'); // キャラクター登録画面へ
} else {
    // ログイン失敗時
    header('Location: login.html?login=failed'); // ログイン画面へ
}
exit();


// パスワードについて
// 平のパスワードは保存しない。保存しているのは、ハッシュ化されたパスワード
// 平のパスワードが鍵、ハッシュ化されたパスワードが鍵穴

// sessionについて
// sessionとは、サーバー側でユーザーの情報を管理する仕組み
// session_id()は、セッションIDを取得する関数
// session_id()は、サーバーが作って、サーバーが管理する
// クライアント側には、セッションIDが送られる
// セッションIDは、ブラウザを閉じると消えるが、クッキーに保存されている
