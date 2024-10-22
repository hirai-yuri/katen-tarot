### **機能要件**

- **カードのシャッフル**
  　　 22 枚のタロットカードをランダムに並べ替える機能

- **カードの分割**
  　　 3 つのグループに分ける（6 ～ 8 枚ずつ）

- **グループの順序決定**
  　　 1 番、2 番、3 番を決め、1 番を一番上にしてまとめる

- **カードをめくる**
  　　最上部のカードをクリックしてめくるアニメーション

- **カードの意味表示**
  　　カードをめくった際に、データベースからそのカードの意味を取得し、表示する

### ** tarot_db 構築　 SQL 文**

CREATE TABLE users (
user_id INT AUTO_INCREMENT PRIMARY KEY,
email VARCHAR(255) NOT NULL,
password VARCHAR(255) NOT NULL,
created_at DATETIME,
);

CREATE TABLE tarot_results (
id INT AUTO_INCREMENT PRIMARY KEY,
user_id INT,
tarot_result TEXT,
image_path VARCHAR(255),
tarot_type VARCHAR(50),
created_at DATETIME,
FOREIGN KEY (user_id) REFERENCES users(user_id)
);
