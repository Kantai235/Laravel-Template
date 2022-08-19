# Laravel 基礎模板

這是一項起始基於 [Laravel Boilerplate](https://github.com/rappasoft/laravel-boilerplate) 下去改進的專案，加入了一些自己對於系統的想法、追求更新的版本，適合作為專案或系統開發的起始模板，大部分需要的功能都已經完善了，讓開發者可以只需要專注在自己系統的特色功能。

## 特色

### 功能面

1. 全面支援中文
2. 支援二階段身份驗證(2FA)
3. 具有公告系統(Announcement)
4. 基於以角色為基礎的存取控制(RBAC)的使用者、角色、權限管理系統

### 技術面

* Laravel 9.x
* Vue 3.x
* Bootstrap 5.x
* CoreUI 4.x

## 預計接下來的項目

* 完整移除 jQuery 依賴
* 新增公告系統(Announcement)於後台的新增、刪除、修改、查詢，以及權限管理
# 安裝

## 自行架設環境

1. 克隆此 `Laravel-Template`
    

```bash
# Clone this repository
git clone https://github.com/Kantai235/Laravel-Template.git

# Enter the repository
cd Laravel-Template
```

2. 建立一個 `.env` 的設定檔案，並將 `.env.example` 裡面的內容複製過去，並根據自己的環境設定變數內容。

## 使用laradock

本說明會以 `nginx mysql redis workspace` 的組合安裝環境

### 建立laradock環境

1. 克隆此 `Laravel-Template`並進入 `laradock` 資料夾

```bash
# Clone this repository with submodules
git clone --recurse-submodules https://github.com/Kantai235/Laravel-Template.git

# Enter the repository
cd Laravel-Template

# Enter laradock repository
cd laradock
```

2. 你現在應該在`Laravel-Template/laradock`資料夾，在此建立一個`.env` 的設定檔案，並將 `.env.example` 裡面的內容複製過去。
3. 修改`.env`的變數 `PHP_VERSION=8.1`，有其他個人想修改的內容可以自行修改其他變數內容
4. 運行容器

```bash
docker-compose up -d nginx mysql redis workspace
```

### 設定Laravel-Template環境變數

1. 進入`workspace`容器

```bash
# Enter workspace container
docker-compose exec workspace /bin/bash
```

2. 你現在應該在workspace container內的/var/www資料夾，在此建立一個 `.env` 的設定檔案，並將 `.env.laradock.example` 裡面的內容複製過去。

```bash
# Copy .env file
cp .env.laradock.example .env
```

## 安裝相依並啟動

```shell
composer install
npm install
npm run production
php artisan key:generate
php artisan migrate:refresh --seed
php artisan storage:link
php artisan serve
```

### 管理員

```
Account: admin@admin.com
Password: secret
```

### 使用者

```
Account: user@user.com
Password: secret
```

## 單元測試、檢查程式碼標準
### 單元測試
```shell
./vendor/bin/phpunit tests
```

### 檢查程式碼標準
```shell
./vendor/bin/phpcs --standard=phpcs.xml
```

## Queues
```
# 它需要持續執行，但不要重複執行，死掉後還要懂得自己復活自己。
php artisan queue:restart && php artisan queue:work database --sleep=3 --tries=3 --daemon
```

## Task Scheduling
```
# 它需要每分鐘執行一次。
php artisan schedule:run
```
