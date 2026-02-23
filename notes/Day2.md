# 📅 Day 2：動態路由與開發工具進階

## 🛠️ 必備工具：Symfony CLI

今天捨棄了基礎的 `php -S`，改用官方推薦的 **Symfony CLI**。

| 功能 | 指令 | 說明 |
| --- | --- | --- |
| **安裝 (macOS/Linux)** | `curl -sS https://get.symfony.com/cli/installer | bash` | 官方安裝腳本 |
| **環境檢查** | `symfony check:req` | 檢查 PHP 擴充套件是否齊全 |
| **HTTPS 證書** | `symfony server:ca:install` | 讓本地開發環境支援 HTTPS (避免瀏覽器警告) |
| **啟動伺服器** | `symfony serve -d` | 背景啟動高效能伺服器 (支援 HTTP/2) |
| **停止伺服器** | `symfony server:stop` | 關閉伺服器 |

## 🛣️ 路由 (Routing) 進階技巧

### 1. 動態參數 (Wildcards)

網址不再是死板的固定字串，可以透過 `{}` 接收變數。

* **範例**：`#[Route('/task/{id}', name: 'app_task_show')]`
* **代碼**：`public function show(int $id)`，Symfony 會自動將網址變數對應到 function 參數。

### 2. 路由限制 (Requirements)

為了安全性，可以使用正則表達式限制參數格式。

* **限制數字**：`requirements: ['id' => '\d+']`
* **結果**：若輸入 `/task/abc`，Symfony 會直接回傳 **404**，保護後端不被非法格式攻擊。

### 3. Request 物件注入

不只能拿網址變數，還能拿到整個 HTTP Request 的資訊（Query String, Headers, Body）。

* **必備引用**：`use Symfony\Component\HttpFoundation\Request;`
* **常用方法**：
* `$request->query->get('key')`：拿 GET 參數 (`?id=1`)。
* `$request->request->get('key')`：拿 POST 表單參數。
* `$request->getMethod()`：確認是 GET、POST 還是 PUT。



## 🔍 調試指令 (Debug Commands)

雖然有了 Web 介面，但終端機指令在開發時更快速：

* **列出所有路由**：`php bin/console debug:router`
* **測試路由匹配**：`php bin/console router:match /task/123`

## 💡 關鍵觀念：解耦合 (Decoupling)

* **為什麼不用 `php artisan serve`？**
Symfony 秉持「解耦合」哲學，將**框架邏輯**與**開發工具**分離。框架本身 (my-app) 保持純淨，強大的工具 (CLI) 獨立存在。這也是為何 Drupal 核心選擇 Symfony 組件的原因：**純粹、標準、互操作性強。**

