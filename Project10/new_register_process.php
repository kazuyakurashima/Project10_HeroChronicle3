<!-- 新規登録の準備 -->
<!-- ユーザーIDが既に存在するか確認 -->
<!-- 新規登録処理 -->

<?php
// 新規登録の準備
session_start();
require_once 'functions/sql_util.php';
require_once 'functions/db_connect.php';

$pdo = db_connect();
$lid = $_POST['lid'];
$lpw = $_POST['lpw'];


// ユーザーIDが既に存在するか確認
$sql = 'SELECT COUNT(*) FROM users WHERE lid = :lid';
$params = [':lid' => $lid];
$stmt = executeQuery($pdo, $sql, $params);
// $stmtには、該当するユーザーIDの情報が格納される
$count = $stmt->fetchColumn();
// $countには、ユーザーIDが存在する場合は1以上、存在しない場合は0が代入される
if ($count > 0) {
    // 既にユーザーIDが存在する場合
    header('Location: login.html?error=exists');
    exit();
}


//新規登録処理
$hashed_pw = password_hash($lpw, PASSWORD_DEFAULT);
// パスワードのハッシュ化
// ユーザー情報（ユーザーIDとハッシュ化されたパスワード）をDBに登録
$sql = 'INSERT INTO users (lid, lpw) VALUES (:lid, :lpw)';
$params = [':lid' => $lid, ':lpw' => $hashed_pw];
executeQuery($pdo, $sql, $params);
header('Location: login.html?message=registered'); // ログイン画面へリダイレクト
exit();
?>
