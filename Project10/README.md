①課題番号 - プロダクト名
10 - Hero Chronicle 3

②課題内容（どんな作品か）
Hero Chronicle 3は、RPGのような体験を楽しめるキャラクター管理アプリです。

キャラクター作成: ユーザーは自分のキャラクターを自由に作成・登録できます。
ショップ機能: 作成したキャラクターにアイテムを購入・装備させることが可能です。
編集・削除: 登録されたキャラクターや購入したアイテム情報の編集や削除もサポートします。
データ保存: ユーザーのデータはデータベースで安全に管理されます。
③DEMO
現在準備中です。提出後、GitHubリポジトリへのリンクを掲載予定です。

④アプリケーション用のIDまたはPassword（必要な場合）
ID: 不要
PW: 不要

⑤工夫した点・こだわった点・学んだこと
パスワードのハッシュ化:
ハッシュ化されたパスワードの重要性を学びました。特に、ハッシュ化アルゴリズムがセキュリティの鍵であり、保存されるパスワードが「鍵穴」として機能する点に驚きました。

セッション管理:
セッションをただの一時的な変数としてではなく、各ユーザーに固有のセッションIDを割り当てる仕組みを理解しました。サーバーサイドでセッション情報を適切に管理することで、アプリのセキュリティと利便性を向上させています。

UI/UX設計:
ユーザーが直感的に操作できるUIを目指しました。特に、キャラクター作成画面やショップ画面のデザインに力を入れ、楽しさを感じられるインターフェースを構築しました。

データベース設計:
MySQLを用い、効率的にデータを管理できる構造を設計しました。リレーショナルデータベースを活用し、キャラクター、アイテム、ユーザー情報を一元管理しています。

⑥難しかった点・次回トライしたいこと
難しかった点:

パスワードハッシュ化やセッション管理におけるセキュリティの考慮
複数ページ間でセッションを正確に管理する方法
MVCモデルの導入に伴うコードの整理
次回トライしたいこと:
締切後のコードレビュー会までに、以下の機能を追加予定です：

商品レビュー機能の実装（レビュー投稿・表示）
レビューの編集・削除機能の追加
ユーザーのログイン、商品購入、レビューを統合管理するデータベースの設計
MVCモデルの導入と適切なディレクトリ構造の構築
⑦質問・感想
MVCモデルを適切に導入する具体的な手順についてアドバイスをいただきたいです。特に、既存コードをどのようにリファクタリングすれば効果的か知りたいです。
複数ページにわたるセッション管理を効率化する方法を学びたいです。
UI/UXデザインにおける改善点についてのフィードバックを歓迎します。