# MovieSearch SPA

TMDb APIを利用した映画検索SPAです。
Laravel（API）とReact（SPA）を分離した構成で、外部APIを利用した検索機能を提供します。

[![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge\&logo=laravel\&logoColor=white)](https://laravel.com/)
[![React](https://img.shields.io/badge/React-20232A?style=for-the-badge\&logo=react\&logoColor=61DAFB)](https://react.dev/)
[![TypeScript](https://img.shields.io/badge/TypeScript-3178C6?style=for-the-badge\&logo=typescript\&logoColor=white)](https://www.typescriptlang.org/)

---

## Table of Contents

1. [プロジェクト概要](#1-プロジェクト概要)
2. [開発背景](#2-開発背景)
3. [技術スタック](#3-技術スタック)
4. [Architecture Highlights](#4-architecture-highlights)
5. [アーキテクチャ](#5-アーキテクチャ)
6. [データフロー](#6-データフロー)
7. [主な機能](#7-主な機能)
8. [テスト戦略](#8-テスト戦略)
9. [セットアップ](#9-セットアップ)
10. [今後の展望](#10-今後の展望)

---

# 1. プロジェクト概要

本プロジェクトは、外部API（TMDb）を利用した映画検索SPAです。

* 映画タイトル検索
* 成人向けフラグ指定
* ページネーション

といった条件で映画情報を取得し、一覧表示します。

本アプリは「外部APIを利用するアプリケーションにおける設計」をテーマに、

* API依存の隔離
* レイヤ分離
* SPA構成

を実践することを目的としています。

---

# 2. 開発背景

外部APIを利用したアプリケーションでは、以下の問題が発生しやすいです。

* API仕様変更の影響が広範囲に及ぶ
* フロントとバックエンドの責務が曖昧になる
* HTTP通信処理とビジネスロジックが混在する

本プロジェクトではこれらを解決するために、

* Repositoryによる外部API抽象化
* UseCase中心の設計
* フロント・バック分離（SPA + API）

を採用しています。

---

# 3. 技術スタック

| カテゴリ        | 技術                          |
| ----------- | --------------------------- |
| Backend     | Laravel 12 / PHP 8.2        |
| Frontend    | React 19 / TypeScript       |
| HTTP Client | Axios / Laravel HTTP Client |
| Routing     | React Router                |
| Styling     | TailwindCSS                 |
| Environment | Docker (Laravel Sail)       |

---

# 4. Architecture Highlights

## 1. 外部API依存の隔離

TMDbの仕様（クエリ・レスポンス）はInfrastructure層に閉じ込めています。

* QueryConverter
* Mapper
* API Client

により、上位層は外部仕様を意識しません。

## 2. UseCase中心の設計

アプリケーションの処理はUseCaseに集約されています。

* Controllerは薄い
* ビジネスロジックはUseCaseへ集約

## 3. Repositoryによる依存逆転

```
UseCase → Repository Interface → Infrastructure実装
```

この構造により、データソースの差し替えが可能です。

## 4. CQRS的設計（Read特化）

本プロジェクトは検索機能のみのため、

* 書き込み処理なし
* ドメインロジック最小

という前提から、Domain層をあえて導入せず、
UseCase + DTO中心の構成としています。

---

# 5. アーキテクチャ

## Backend

```
Presentation (Controller / Request / Resource)
        ↓
Application (UseCase / DTO / Query / Repository Interface)
        ↓
Infrastructure (TMDb API / Client / Mapper / Converter)
```

## Frontend

```
UI (pages / components)
        ↓
API Layer (movieApi.ts)
        ↓
HTTP Client (axios wrapper)
```

---

# 6. データフロー

```
Frontend → Laravel API → UseCase → Repository → TMDb API
```

* 外部API仕様はInfrastructureで吸収
* フロントはAPIレスポンスのみを扱う

---

# 7. 主な機能

* 映画検索（タイトル）
* 成人向けフィルタ
* ページネーション
* APIレスポンスの整形表示

---

# 8. テスト戦略

本プロジェクトでは、Clean Architectureの構成を活かし、
UseCase層を中心にユニットテストを実装しています。

* Repositoryをモック化し外部API依存を排除
* UseCase単体の動作検証
* APIの基本動作はFeatureテストで確認

---

# 9. セットアップ

本プロジェクトは、Backend（Laravel Sail）とFrontend（Vite + React）を別コンテナで起動する構成になっています。

```
MovieSearch/
 ├─ backend   # Laravel（Sail）
 └─ frontend
     ├─ app   # Reactアプリ
     └─ docker
```

---

## 1. リポジトリ取得

```bash
git clone https://github.com/jounouchi666/MovieSearch.git
cd MovieSearch
```

---

## 2. Backend（Laravel Sail）セットアップ

```bash
cd backend

# 依存関係インストール
composer install

# .env作成
cp .env.example .env

# アプリキー生成
./vendor/bin/sail artisan key:generate

# コンテナ起動
./vendor/bin/sail up -d
```

---

## 3. Frontend（React + Vite）セットアップ

フロントエンドもDockerコンテナとして起動します。
frontendディレクトリに移動し、docker-composeで一括起動します。

```bash
cd ../frontend

# .env作成
cp app/.env.example app/.env

# コンテナ起動
docker compose up --build
```

## 4. アクセス

* Frontend: [http://localhost:5173](http://localhost:5173)
* Backend API: [http://localhost/api](http://localhost/api)

---

## 備考

* BackendはLaravel Sail（Docker）上で動作します
* FrontendはViteの開発サーバで動作します（Docker外）
* API通信はCORS設定により許可されています

---

# 10. 今後の展望

* 例外ハンドリングの統一
* エラーレスポンスの標準化
* キャッシュ戦略の強化
* React Query導入によるデータ管理改善

---

# License

MIT
