<?php

// 1. 必要なファイルを読み込む
// 2. URLから取得したIDを基にデータベースから該当キャラクターを取得
// 3. HTML(編集フォーム）

// 1. 必要なファイルを読み込む
require_once 'functions/security.php';
    // XSS(Cross-Site Scripting)対策のため、htmlspecialchars()関数を使用
    // データに悪意がある場合、HTMLタグがそのまま表示されてしまうため、htmlspecialchars()関数を使用してエスケープする
require_once 'functions/sql_util.php'; 
    // SQL操作を共通化したファイル
require_once 'functions/security.php';
    // loginCheck()関数を使用するため、セッションを開始します。
    // セッションIDを再生成し、新しいIDを `$_SESSION['chk_ssid']` に保存する
loginCheck();
require_once 'functions/db_connect.php';
    // データベース接続用のファイル
    // db_connect.phpの中身は、下記の通り
    // $pdo = new PDO('mysql:dbname=' . $db_name . ';charset=utf8;host=' . $db_host, $db_id, $db_pw);
    // $pdo     調理場（データベース）を指す変数
$pdo = db_connect(); 


// 2. URLから取得したIDを基にデータベースから該当キャラクターを取得
$id = $_GET['id']; 
// URLパラメータからIDを取得
$sql = 'SELECT * FROM players WHERE id = :id'; 
// 該当キャラクターのデータ取得するSQL文  
// $idは、操作される可能性があるため、プレースホルダーを使用してSQLインジェクション対策を行う
$paramas = [':id' => $id]; 
// プレースホルダーに値をバインド
$player = fetchQuery($pdo, $sql, $paramas); 
// fetchQuery()関数を使って、SQL文を実行し、データを取得します。

if (!$player) {
    exit('キャラクターが見つかりませんでした。');
}
?>



<!-- 3.HTML(編集フォーム） -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>キャラクター編集</title>
    <link rel="stylesheet" href="css/character.css">
    <link rel="icon" href="img/project8.png"> <!-- ファビコンの設定 -->
</head>
<body>
    <h1>キャラクター編集</h1>
    <form action="update_process.php" method="POST">
        <input type="hidden" name="id" value="<?php echo h($player['id']); ?>"> 
        <!-- idは変更されることがないため、hiddenで送信 -->
        
        <label for="name">名前</label>
        <input type="text" id="name" name="name" value="<?php echo h($player['name']); ?>" required><br>
        <!-- value：入力欄の中に初期値を設定する値 -->
        <label for="job">職業</label>
        <select id="job" name="job" required>
            <option value="戦士" <?php if ($player['job'] === '戦士') echo 'selected'; ?>>戦士</option>
            <option value="魔法使い" <?php if ($player['job'] === '魔法使い') echo 'selected'; ?>>魔法使い</option>
            <option value="Gsクリエーター" <?php if ($player['job'] === 'Gsクリエーター') echo 'selected'; ?>>Gsクリエーター</option>
            <option value="Gsイノベーター" <?php if ($player['job'] === 'Gsイノベーター') echo 'selected'; ?>>Gsイノベーター</option>
            <option value="Gsバグバスター" <?php if ($player['job'] === 'Gsバグバスター') echo 'selected'; ?>>Gsバグバスター</option>
            <!-- 現在の職業が、条件に一致すると選択される -->
             <!-- 職業を変えると、それがvalueに入って送信される -->
        </select><br>

        <label for="hp">HP</label>
        <input type="number" id="hp" name="hp" value="<?php echo h($player['hp']); ?>" min="0" required><br>
        <!-- 最小値を0にしました -->

        <label for="mp">MP</label>
        <input type="number" id="mp" name="mp" value="<?php echo h($player['mp']); ?>" min="0" required><br>

        <button type="submit">更新</button>
    </form>
    <a href="register_confirm.php">戻る</a>
</body>
</html>
