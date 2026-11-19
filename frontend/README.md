# frontend

推し活グッズ管理システムのフロントエンド（Vue 3 + Vite）です。
プロジェクト全体の説明・セットアップ手順は、リポジトリ直下の [README.md](../README.md) を参照してください。

## 構成

| ディレクトリ | 内容 |
| --- | --- |
| `src/views/` | 画面単位のコンポーネント |
| `src/components/` | 画面をまたいで使う共通コンポーネント（`AppNav.vue` など） |
| `src/router/` | 画面遷移（ルーティング）の定義 |
| `src/services/` | API通信の共通処理（axiosのインスタンス） |
| `src/assets/` | CSS・画像 |

## コマンド

```sh
npm install      # 依存パッケージのインストール
npm run dev      # 開発サーバー起動
npm run build    # 本番用ビルド
npm run lint     # ESLint / oxlint で検査・自動修正
npm run format   # Prettier で整形
```

バックエンドのAPIは `src/services/api.js` の `baseURL` を参照しています。
Laravel Sail の起動ポートに合わせて設定してください。
