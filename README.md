# conduitの起動方法

```bash
composer install
./vendor/bin/sail up -d
sail artisan migrate:fresh --seed
```

[localhost](localhost)にアクセス

## 上手く起動しない場合は、`docker-compose.yml`ファイルのポート番号を書き換えてください

```bash
# 既に使用中のportを確認
docker ps

# 使えるポートか確認
sudo lsof -i:3306
```


# テスト
1. Sign up
- ヘッダー右上のSign upからユーザー登録を行う
- 何も入力せずにSign upボタンをクリックし登録できないことを確認
- Usernameを入力し、Sign upボタンをクリックし登録できないことを確認
- Emailに`aaa`を入力し、Sign upボタンをクリックし登録できないことを確認
- Passwordに`aaa`を入力しSign upボタンをクリックし登録できないことを確認
- Emailを正しい形式で入力しSign upボタンをクリックし登録できることを確認

2. 記事の投稿、詳細、編集、削除
- ヘッダー右上のNew Articleからユーザー登録を行う
- 何も入力せずにPublish Articleボタンをクリックし、記事を投稿できないことを確認
- Enter tagsに`aaa`と入力しEnterをクリックして`aaa`のタグが表示されることを確認
- `aaa`タグの`❌`アイコンをクリックし、タグが削除されることを確認
- Article Title,What's this article about?, Write your article (in markdown)に文字を入力し、Enter tagsに`aaa`と入力しEnterをクリックして`aaa`のタグを2個作成する、Publish Articleボタンをクリックし、記事を投稿できないことを確認する
- `aaa`タグを削除し`bbb`タグを追加する
また、以下の文字列をArticle Title, What's this article about?, Write your article (in markdown)に入力する

```md
# a
## b

- 1
- 2
- 3
```

Publish Articleボタンをクリックし記事が投稿されたことを確認する


- [localhost](localhost)にて追加されたArticleのユーザー画像、ユーザー名、article_title,article_abstract,tag,favorite_countが正しく表示されていることを確認する
- 新しく追加されたarticleをクリックし、Articleの詳細ページが正しく表示されていることを確認する
- Articleの詳細ページに、Edit Articleボタンをクリックし、Article編集画面が表示されることを確認する
- 全ての要素を変更し、正しく反映されていることを確認する
- Delete ArticleボタンをクリックしArticleが削除されることを確認する

3. 記事詳細
- [localhost](localhost)から記事をクリックし、Write a comment...のテキストボックスに文字を入力し、Post Commentボタンをクリックして正しくコメントが投稿できていることを確認する

4. 記事一覧画面
- [localhost](localhost)にて、下にスクロールしページネーションをクリックした際にに正しい記事が表示されていることを確認する
- Popular tagsのタグボタンをクリックして適切にタグがフィルタリングされていることを確認する
