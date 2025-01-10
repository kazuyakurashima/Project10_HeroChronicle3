<?php

function executeQuery($pdo, $sql, $params = []) {

    try {
        // SQL文を準備（プレースホルダーを使用）
        $stmt = $pdo->prepare($sql);
        // 調理場(=データベース)（$pdo）にいるシェフ（$stmt）に、調理レシピ（$sql）が伝わる
        // prepare()は、PDOクラスのメソッド
        // prepare()は、データベースに対してSQL文を送信して実行準備をさせるPODのメソッド

        // $stmtには、実行するSQL文がセットされたPDOStatementクラスのインスタンスが代入される
        // PODStatementクラスは、データベースに対して実行するSQL文を表すクラス


        // プレースホルダーに値をバインド
        // （実際の料理内容は次の4つ）
            // $stmt->bindValue(':name', $name, PDO::PARAM_STR);
            // $stmt->bindValue(':job', $job, PDO::PARAM_STR);
            // $stmt->bindValue(':hp', $hp, PDO::PARAM_INT);
            // $stmt->bindValue(':mp', $mp, PDO::PARAM_INT);

        foreach ($params as $key => $value) {
            // 値が整数なら PDO::PARAM_INT、それ以外は PDO::PARAM_STR を指定
            if (is_int($value)) {
                // is_int()関数は、変数が整数型かどうかを調べる関数
                $type = PDO::PARAM_INT;
            } else {
                $type = PDO::PARAM_STR;
            }
            $stmt->bindValue($key, $value, $type); // 安全に値をバインド
        }

                // PDO::PARAM_STR       PDOクラスが持つ定数(PARAM_STR）にアクセス（：：）する
                // ::                   スコープ解決演算子（クラス定数やメソッドを呼び出すために使用）   
                // PARAM_STR            文字列型（string）を指定するための定数
                // PARAM_INT            整数型（integer）を指定するための定数


        // SQLを実行
        $stmt->execute();
        // 実行した結果のステートメントオブジェクトを返す
        return $stmt;

    } catch (PDOException $e) {
        // PDOExceptionは、エラー発生にPDOクラスが自動的に作る例外クラス
        // $eは、PDOExceptionクラスのインスタンス
        // エラーログを記録（error_logでログファイルに書き込む）
        error_log('SQLエラー: ' . $e->getMessage());
        // ユーザーに安全なエラーメッセージを表示して終了
        exit('データベースエラーが発生しました。');
    }
}



// 1件のデータを取得する共通関数
// この関数は、1つの行（データ）を取得して返します。
function fetchQuery($pdo, $sql, $params = []) {
    // executeQuery関数を使ってSQLを実行
    // 引数：$paramsはなくても良いので、[]で空の配列を指定
    $stmt = executeQuery($pdo, $sql, $params);
// 調理場(=データベース)（$pdo）にいるシェフ（$stmt_latest）に、最新データ取得のレシピを渡す

    // 実行結果から1行を取得して返す（連想配列形式で取得）
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


// 全データを取得する共通関数
// この関数は、複数の行（データ）を取得して返します。
function fetchAllQuery($pdo, $sql, $params = []) {
    // executeQuery関数を使ってSQLを実行
    $stmt = executeQuery($pdo, $sql, $params);

    // 実行結果からすべての行を取得して返す（連想配列形式で取得）
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


// SQL共通の処理をまとめたファイル
// 1．SQLを安全に実行する関数
// 2．1件のデータを取得する関数
// 3．全データを取得する関数

// 1.SQLクエリを安全に実行する関数(executeQuery)
// ＜アナロジーによる説明＞
// $pdo             「調理場（データベース）」
// SQL文：           「調理のレシピ（データのCRUD）」
// $params:         「材料の名前（key)と実際の材料（values）」
// prepare():       「レシピ（SQL文）を調理場（データベース）に伝える」
// $stem:           「シェフ（調理する人）」
// bindValue():     「材料（値）を追加する」
// execute():       「料理（SQL命令）を作る」
// $status:         「料理（SQL命令）が作れたか、失敗したかを示す」
// fetch():         「料理（SQL命令）を1品取り出す」
// fetchAll():      「料理（SQL命令）を全品取り出す」


// PDOStatement:    「シェフという職業（抽象概念）」
    // PDOStatementクラスのインスタンス     $stmt（実際のシェフ）
    // PDOStatementクラスのメソッド         bindValue()、execute(),fetch(),fetchAll()