<?php
session_start();
require_once('functions/security.php');
loginCheck();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- imgフォルダにあるproject8.pngというファビコンを挿入する -->
    <link rel="icon" href="img/project8.png">
    <title>Create Your Legend</title>
    <link rel="stylesheet" href="css/character.css">
</head>
<body>
    <h1>キャラクター登録</h1>
    <!-- action：サーバーへの送信先 -->
    <form action="register_process.php" method="POST">

        <!-- 名前の入力 -->
        <label for="name">名前</label>
        <input type="text" id="name" name="name" required><br>
        <!-- required：未入力のままの送信を防ぐ -->

        <!-- 職業の選択 -->
        <label for="job">職業</label>
        <select  id="job" name="job" required>
            <option value="戦士">戦士</option>
            <option value="魔法使い">魔法使い</option>
            <option value="Gsクリエーター">Gsクリエーター</option>
            <option value="Gsイノベーター">Gsイノベーター</option>
            <option value="Gsバグバスター">Gsバグバスター</option>
        </select>

        <!-- HPとMPの入力 -->
        <label for="hp">HP:</label>
        <input type="number" id="hp" name="hp" min="0" required><br>

        <!-- MPの入力 -->
        <label for="mp">MP:</label>
        <input type="number" id="mp" name="mp" min="0" required><br>
 
        <!-- 送信ボタン -->
        <button type="submit">登録</button>
    </form>
        

    
    <!-- JavaScriptの記述 -->
        <script>
 
        // ランダムな整数を生成する関数
        function getRandomInt(max) {
            // Math.random(): 0以上1未満のランダムな小数を生成
            // これにmaxを掛けて、0以上max未満のランダムな小数を得る
            // Math.floor(): 小数点以下を切り捨てて整数にする
            return Math.floor(Math.random() * max);
        }

        /**
         * ページが完全に読み込まれた後にHPとMPの初期値を設定する
         * ここでは「DOMContentLoaded」イベントを使用することで、
         * HTML要素がすべて準備できた状態でスクリプトを実行する。
         */
        document.addEventListener("DOMContentLoaded", () => {
            // ページ内のHTML要素をJavaScriptで操作する準備ができた状態

            // HP（体力）の初期値を設定
            // "hp"というidを持つHTMLのinput要素を取得
            const hpElement = document.getElementById("hp");
            // ランダムに0～99の整数を生成して、取得したinput要素の値に設定
            hpElement.value = getRandomInt(100); // 例: HP = 35

            // MP（魔力）の初期値を設定
            // "mp"というidを持つHTMLのinput要素を取得
            const mpElement = document.getElementById("mp");
            // ランダムに0～99の整数を生成して、取得したinput要素の値に設定
            mpElement.value = getRandomInt(100); // 例: MP = 12

            // コンソールに初期値を表示（デバッグ目的）
            console.log("HP初期値:", hpElement.value);
            console.log("MP初期値:", mpElement.value);
        });

        // 注意:
        // このスクリプトはHTMLが完全に読み込まれるのを待つため、
        // 必ず<body>タグ内、またはHTMLの最後に配置してください。
        </script>
    </body>
</html>

