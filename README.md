# Laravel 基礎模板
這是一項起始基於 [Laravel Boilerplate](https://github.com/rappasoft/laravel-boilerplate) 下去改進的專案，加入了一些自己對於系統的想法、追求更新的版本，適合作為專案或系統開發的起始模板，大部分需要的功能都已經完善了，讓開發者可以只需要專注在自己系統的特色功能。

## 特色
### 功能面
1. 全面支援中文
2. 支援二階段身份驗證(2FA)
3. 具有公告系統(Announcement)
4. 基於以角色為基礎的存取控制(RBAC)的使用者、角色、權限管理系統

### 技術面
- Laravel 9.x
- Vue 3.x
- Bootstrap 5.x
- CoreUI 4.x

## 預計接下來的項目
- 完整移除 jQuery 依賴
- 新增公告系統(Announcement)於後台的新增、刪除、修改、查詢，以及權限管理

# 安裝
建立一個 `.env` 的設定檔案，並將 `.env.example` 裡面的內容複製過去。

```shell
composer install
npm install
npm run production
php artisan key:generate
php artisan migrate:refresh --seed
php artisan storage:link
php artisan serve
```

## 管理員
```
Account: admin@admin.com
Password: secret
```

## 使用者
```
Account: user@user.com
Password: secret
```
