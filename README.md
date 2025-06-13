EasePleasure會員系統

這是一個使用 Laravel 框架建置的 Web 專案，功能包含帳號註冊、登入、角色管理、資料列表與搜尋等，前後端透過 RESTful API 串接，支援 Docker 自動化部署。


專案功能:
-  會員註冊 / 登入（支援 JWT / cookie）
-   使用者角色（Admin / User）
-  密碼寄信（PHPMailer + Gmail SMTP）
-  註冊信箱驗證
-  前後端分離
-  使用者圖片上傳
-  搜尋與分頁功能
-  Docker 環境建置 + GitHub Actions 自動部署 

環境需求:
-  PHP 8.2+
-  Laravel 10+
-  MySQL 8
-  Docker / Docker Compose
-  Node.js 18+
-  Mailtrap / Gmail SMTP（忘記密碼功能）


開發環境會建立預設帳號：

-  Admin 帳號：TestAdmin@example.com ，密碼: TestAdmin@123
-  User 帳號：TestUser@example.com 密碼: TestUser@123

自動部署流程:
-  當 push 到 main 分支時，自動打包 Docker Image 並推送到 Docker Hub
-  使用 SSH 登入 AWS EC2，拉取最新 image 並重新啟動容器

作品:
作品連結：https://easepleasure.keepgoingpiggy.com/


備註:
本專案為自學作品，開發目的為練習 Laravel + Docker + API 架構。
