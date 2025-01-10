<?php

// PHPの記述
// セッションの設定
    // ギークマーケットでのセッションを引き継ぐために必要
// 必要なファイルを読み込む
    // 1．セキュリティ対策用の関数を読み込む(security.php)
    // 2．データベースに接続する関数を読み込む(db_connect.php)
    // 3．SQL操作を共通化した関数を読み込む(sql_util.php)
    // 4．セッションのチェックを行う関数を読み込む(security.php)
// データを取得する
    // （その1）料理したものを、1品取り出す
    // （その2）料理したものを、全品取り出す


// HTMLの記述
    // 操作結果のメッセージを表示
    // セッションからプレイヤー情報を表示
    // リンク：ギークマーケットへ
    // リンク：登録画面に戻る
    // 全てのデータを一覧表示する


// -----------------------------------------------------
session_start();

// -----------------------------------------------------
// 必要なファイルを読み込む
// 1．セキュリティ対策用の関数を読み込む(security.php)
// XSS(Cross-Site Scripting)対策のため、htmlspecialchars()関数を使用
require_once 'functions/security.php'; 
    // セキュリティ用の関数(htmlspecialchars)が定義されたファイルを読み込む

// 2．データベースに接続する関数を読み込む(db_connect.php)
require_once 'functions/db_connect.php'; 
// functionsの中身は、下記の通り
// $pdo = new PDO('mysql:dbname=' . $db_name . ';charset=utf8;host=' . $db_host, $db_id, $db_pw);
$pdo = db_connect(); 
// $pdoはローカルスコープ（関数内でのみ有効）なので、他のファイルで$pdoを使う場合は、returnで返す必要がある
// 返された$pdoは、$pdo = db_connect();で受け取ることができる

// 3．SQL操作を共通化した関数を読み込む(sql_util.php)
require_once 'functions/sql_util.php';

// 4．セッションのチェックを行う関数を読み込む
require_once('functions/security.php');
loginCheck();

// -----------------------------------------------------
// データを取得する
    // 既に料理したので、SQLインジェクション対策は不要
    // 既にあるデータを、取得し表示するだけ

// （その1）料理したものを、1品取り出す（直近のデータを取得）
$sql_latest = 'SELECT * FROM players ORDER BY id DESC LIMIT 1';
// 直近データを取得するSQL文を作成
// ORDER BY id DESC：idが大きい順（新しい順）に並べ、LIMIT 1で1件だけ取得します。
$latest_player = fetchQuery($pdo, $sql_latest);
// fetchQuery()関数を使って、SQL文を実行し、データを取得します。
// 調理場(データベース）($pdo)に、直近データ取得のレシピ($sql_latest)を渡す


// （その2）料理したものを、全品取り出す（全データを取得）
$sql_all = 'SELECT * FROM players ORDER BY created_at DESC';
// 全データを取得するSQL文を作成
// ORDER BY created_at DESC：登録日時が新しい順に並べます。
$all_players = fetchAllQuery($pdo, $sql_all);
// fetchAllQuery()関数を使って、SQL文を実行し、データを取得します。
// 調理場(データベース）($pdo)に、全データ取得のレシピ($sql_all)を渡す


// セッションにデータを保存
// register.phpで入力されたデータをセッションに保存
// $_SESSIONは、サーバー側にデータを保存するためのスーパーグローバル変数
    // グローバル変数とは、どこからでもアクセスできる変数のこと
    // スーパーグローバル変数とは、PHPが元々用意している特殊なグローバル変数のこと
        // 例えば、$_POST、$_GET、$_SESSIONなどがある
// $_SESSIONは、サーバー側にデータを保存するためのスーパーグローバル変数
// $_SESSIONは、連想配列で、playerがキーになっている


?>




<!-- ----------------------------------------------------- -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>登録内容確認</title> <!-- ページのタイトル -->
    <link rel="stylesheet" href="css/character.css">
    <link rel="icon" href="img/project8.png"> <!-- ファビコンの設定 -->
</head>
<body>
    <!-- 直近に登録されたデータの表示 -->
    <h1>登録内容確認</h1>
    
    <!-- 操作結果のメッセージを表示 -->
    <!-- セッションにメッセージが保存されている場合、その内容を画面に表示する -->
    <?php if (isset($_SESSION['message'])): ?>
        <p style="color: green; font-weight: bold;">
            <?php echo h($_SESSION['message']); ?> 
            <!-- htmlspecialchars()で無害化して表示 -->
            <!-- 安全性のため表示させるところは全てh処理をする -->
        </p>
        <?php unset($_SESSION['message']); ?> 
        <!-- 表示後、セッションからメッセージを削除 -->
    <?php endif; ?>

    <!-- セッションからプレイヤー情報を表示 -->
    <?php if (isset($_SESSION['player'])): ?>
        <p>名前: <?php echo h($_SESSION['player']['name']); ?></p>
        <p>職業: <?php echo h($_SESSION['player']['job']); ?></p>
        <p>HP: <?php echo h($_SESSION['player']['hp']); ?></p>
        <p>MP: <?php echo h($_SESSION['player']['mp']); ?></p>
    <?php else: ?>
        <p>プレイヤー情報がありません。</p>
    <?php endif; ?>

    <!-- shopフォルダにあるindex.htmlに飛ぶリンク -->
    <a href="./shop/index.php">ギークマーケットへ</a><!-- ギークマーケットページに飛ぶリンク -->
    <!-- 登録画面に戻るリンク -->
    <a href="register.php">キャラ登録画面へ戻る</a> <!-- 登録ページに戻るリンク -->

    <!-- 全てのデータを一覧表示する -->
        <!-- tr:Table Row           テーブルを作るよ -->
        <!-- th:Table Header        項目（ヘッダー）を定義 -->
        <!-- td:Table Table Data    実際のデータを入れるよ -->

    <h2>登録済みデータ一覧</h2>
    <table border="1"> <!-- 表を作成します（border="1"で枠線を付ける） -->
        <tr>
            <th>ID</th>
            <th>名前</th>
            <th>職業</th>
            <th>HP</th>
            <th>MP</th>
            <th>登録日時</th>
            <th>編集</th>   
        </tr>
        <!-- foreach文を使って、データベースから取得した全てのデータを1行ずつ表示 -->
        <?php foreach ($all_players as $player): ?>
            <tr>
                <!-- htmlspecialchars()関数で表示する内容を無害化します（セキュリティ対策） -->
                <td><?php echo h($player['id']); ?></td> <!-- IDを表示 -->
                <td><?php echo h($player['name']); ?></td> <!-- 名前を表示 -->
                <td><?php echo h($player['job']); ?></td> <!-- 職業を表示 -->
                <td><?php echo h($player['hp']); ?></td> <!-- HPを表示 -->
                <td><?php echo h($player['mp']); ?></td> <!-- MPを表示 -->
                <td><?php echo h($player['created_at']); ?></td> <!-- 登録日時を表示 -->
                <td>
                    <!-- 編集ボタンを設置 -->
                     <!-- リンク先とクリックしたデータのidを送る -->
                    <a href="update.php?id=<?php echo h($player['id']); ?>">✏️</a> <!-- 編集ページへのリンク -->
                    <!-- ?          クエリパラメータを示す記号 -->
                    <!-- ?id        idというクエリパラメータを、サーバーに渡します -->
                    <!-- $player     プレイヤーの関する連想配列 -->

                    <!-- 例えば、id=1をクリックした場合、リンク先："update.php、データ：id=1が伝わる -->
                     <!-- phpなので、変数を埋め込むためにはechoが必要。データ：1は、：<php echo h($player['id']);?>と表現  -->

                    <!-- 削除ボタンを設置 -->
                    <a href="delete.php?id=<?php echo h($player['id']); ?>">🗑️</a> <!-- 削除ページへのリンク -->
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>