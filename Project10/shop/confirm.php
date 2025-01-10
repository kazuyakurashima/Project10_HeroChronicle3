<!-- ここでdata.phpを読み込んでください  -->
<?php
session_start(); // セッション開始
require_once('data.php');
require_once '../functions/db_connect.php';
require_once '../functions/sql_util.php';
require_once '../functions/security.php';
loginCheck(); // ログインしていない場合、ログイン画面にリダイレクト
$pdo = db_connect(); // データベース接続準備
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>ギークマーケット</title>
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/stylesheet.css">
  <link rel="icon" type="image/png" href="./img/fab-theSupper.png">
  <link href='https://fonts.googleapis.com/css?family=Pacifico|Lato' rel='stylesheet' type='text/css'>
</head>
<body>
        <h2 class="logo2"><br>この度はご注文いただき、誠にありがとうございます。</br>
            <br>お客様の選ばれましたアイテムは、ギーク界のエリートたちにより特別に開発された逸品でございます。<br>
            <br>お手元に届きました際には、その品質をご堪能いただければ幸いに存じます。</br>
        </h2>
    <div class="order-wrapper">
    <!-- totalPaymentの初期設定 -->
    <?php $totalPayment =0 ?>

    <?php foreach ($menus as $menu): ?>
        <!-- 変数$orderCountに,$_POSTで受け取った値を代入するよ！ -->
        <!-- 例えば、beefなら、$orderCountには、$_POST[beef]が入っている。beefの個数が入る -->
        <?php 
            $orderCount = $_POST[$menu->getName()];
            $menu->setOrderCount($orderCount);
            $totalPayment += $menu->getTotalPrice();

            if($orderCount > 0) {
                $sql = "INSERT INTO orders (player_id, product_name, quantity, total_price) VALUES (:player_id, :product_name, :quantity, :total_price)";
                $params = [
                    ':player_id' => $_POST['player_id'],
                    ':product_name' => $menu->getName(),
                    ':quantity' => $orderCount,
                    ':total_price' => $menu->getTotalPrice()
                ];
                executeQuery($pdo, $sql, $params);
            }
        ?>
        


        <p class="order-amount">
            <!-- nameのプロパティを表示 -->
            <?php echo $menu->getName() ?>
             ×
            <?php echo $orderCount ?>
            個
        </p>
        <!-- $menuに対してgetTotalPriceメソッドを呼び出して、金額を表示 -->
        <p class="order-price"><?php echo $menu->getTotalPrice() ?>円</P>

        <!-- データの書き込み・保存 -->
        <?php
            // 日時の取得
            $DateTime = date("Y-m-d H:i:s");
            $file = fopen("orders.txt","a");
            // sprintf・・・string（文字列）、print(データを整形)、formatted（フォーマット）
            // 第1引数：フォーマット文字列（"%s × %d個 - 合計: %d円\n"）
            // 第2引数以降：フォーマットに挿入する値（$menu->getName(), $orderCount, $menu->getTotalPrice()）
            fwrite(
                $file,
                sprintf("%s × %d個　- 合計:　%d円 - 時間: %s\n", $menu->getName(),$orderCount,$menu->getTotalPrice(), $DateTime)
            );
            fclose($file);
        ?>

    <?php endforeach ?>
    <h3>合計金額:<?php echo $totalPayment ?>円</h3>

    <h3>注文履歴：</h3>
    <?php
        if (file_exists("orders.txt")) {
            readfile("orders.txt");
        } else {
            echo "注文履歴がありません";
        }
    ?>
  </div>
</body>
</html>