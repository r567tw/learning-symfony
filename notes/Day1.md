
# 📅 Day 1：Symfony 環境搭建與核心概念

## 🏗️ 專案結構 (Project Architecture)

為了同時管理「開發代碼」與「學習筆記」，我採用的目錄配置如下：

```text
your-git-repo/
├── notes/             # 存放 30 天學習筆記
└── my-app/            # Symfony 專案根目錄 (Project Root)
    ├── bin/           # 執行檔 (例如：console)
    ├── config/        # 設定檔 (YAML)
    ├── public/        # 網頁入口 (index.php) 與 靜態資源
    ├── src/           # 核心程式碼 (PHP)
    ├── var/           # 系統暫存 (Cache) 與 日誌 (Log)
    ├── vendor/        # Composer 下載的第三方套件
    └── .env           # 環境變數設定 (例如：資料庫密碼)

```

## 🛠️ 核心指令紀錄

| 動作 | 指令 | 說明 |
| --- | --- | --- |
| **初始化** | `composer create-project symfony/skeleton my-app` | 建立最精簡的 Symfony 骨架 |
| **安裝工具** | `composer require --dev symfony/maker-bundle` | 安裝「代碼生成助手」(開發時必備) |
| **建立控制器** | `php bin/console make:controller HelloController` | 自動生成 Controller 檔案與資料夾 |
| **啟動伺服器** | `php -S localhost:8000 -t public` | 使用 PHP 內建伺服器預覽網頁 |

## 📂 `src/` 資料夾重點導覽

Symfony 遵循 **PSR-4** 標準，預設命名空間為 `App\`。

1. **Controller/**：處理 HTTP 請求，決定回傳 JSON 或 HTML。
2. **Entity/**：資料庫的映射（Object-Relational Mapping），把資料表物件化。
3. **Repository/**：專門負責「撈資料」的邏輯，保持代碼整潔。
4. **Service/**：存放業務邏輯（例如：寄信、計算金額）。
5. **Kernel.php**：專案的大腦，負責啟動框架，初學者通常不需改動。

## 💡 關鍵觀念

### 1. 核心工作流 (Workflow)

Symfony 的本質就是一個 **Request -> Response** 的轉換器。

* **Request**：使用者傳進來的資訊。
* **HttpKernel**：框架處理核心。
* **Response**：你必須回傳的結果（例如 `JsonResponse`）。

### 2. 為什麼看到預設歡迎頁？

* 當 `APP_ENV=dev` 且你**尚未定義根目錄路由 (`/`)** 時，Symfony 會自動顯示歡迎頁面。
* 底下的黑色橫條是 **Profiler**，是 Debug 的神兵利器。

### 3. Route Attribute (路由屬性)

PHP 8 引入的語法，直接在函數上方標註網址，例如：
`#[Route('/hello', name: 'app_hello')]`

---

### 🌟 我的 Day 1 成果

* [x] 成功建立 `my-app` 專案。
* [x] 成功透過 `make:controller` 產生第一個控制器。
* [x] 成功在 `http://localhost:8000/hello` 看到 JSON 輸出。
