# conduitの起動方法

```bash
cp .env.example .env
composer require laravel/sail --dev
composer install
php artisan key:generate
./vendor/bin/sail up -d
sail artisan migrate:fresh --seed
npm run build
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

[documentation/TEST.md](documentation/TEST.md)

