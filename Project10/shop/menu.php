<?php
// クラス定義用のファイル

class Menu {
    //name,price,imageプロパティを定義 
    // これらは変更出来ないように、プロパティのアクセス権をprivateにしましたよ！
    private $name;
    private $price;
    private $image;
    private $orderCount = 0;

    // コンストラクタ(construct)を定義（newを使って新しいインスタンスを作ると自動で生成するもの）
    // コンストラクタの引数に$name,$price,$imageを入れて、定義しちゃう
    // thisはクラスのメソッド内でのみ使える変数
    public function __construct($name,$price,$image) {
    $this->name = $name;
    $this->price = $price;
    $this->image = $image;
    }

    // getNameメソッドを定義（privateにしているので、プロパティを呼び出す関数が必要）
    public function getName() {
        return $this->name;
    }

    public function getImage() {
        return $this->image;
    }

    public function getOrderCount() {
        return $this->orderCount;
    }

    // setOrderCountメソッドを定義（privateにしているので、値をセットする関数が必要）
    // nameやpriceは変わらない数字だが、orderCountはその都度変わる値。変数である。
    // setOrderCountという関数を使うと、orderCountを安全に変更できる
    public function setOrderCount($orderCount) {
        $this->orderCount = $orderCount;
    }

    // getTaxIncludedPriceメソッドを定義
    public function getTaxIncludedPrice() {
        return floor($this->price * 1.1);
    }

    // getTotalPriceメソッドを定義
    public function getTotalPrice() {
        return $this->getTaxIncludedPrice() * $this->orderCount;
    }

}
?>