<?php

// menu.phpの読み込み
require_once('menu.php');

// データ定義用のファイル
//  Menuクラスのインスタンス（設計図）を作り、変数を定義した。引数も入れた。
$ErrorFreeMug = new Menu('エラー回避のお守りG’sマグカップ', 1300, 'img/ErrorFreeMug.jpg');
$DeployCandle = new Menu('必ずﾃﾞﾌﾟﾛｲ成功!アロマキャンドル', 700, 'img/DeployCandle.jpg');
$TurboThursday = new Menu('木曜日限定！徹夜コーヒー', 500, 'img/TurboThursday.jpg');
$BugWand = new Menu('バグ消しの魔法の杖',12000, 'img/BugWand.jpg');

// 配列に、4つのインスタンスを入れて、変数$menusに代入
$menus = array($ErrorFreeMug, $DeployCandle, $TurboThursday, $BugWand);

?>