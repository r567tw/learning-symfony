# 📅 Day 6：Doctrine ORM —— 從 PHP 到資料庫的橋樑

```
composer require symfony/orm-pack
composer require --dev symfony/maker-bundle

```
## 1. 核心組件大三元

在 Symfony 中，操作資料庫主要靠這三個角色：

| 角色 | 說明 |
| --- | --- |
| **Entity (實體)** | 對應資料表的 **PHP 類別**（例如 `Task.php`）。 |
| **EntityManager** | 負責**執行動作**的管理者。用來 `persist` (暫存) 與 `flush` (真正寫入)。 |
| **Repository** | 負責**查詢資料**的助手。每個 Entity 都有自己的 Repository。 |

## 2. SQLite 的特殊處理

* **現象**：執行 `doctrine:database:create` 報錯 `Operation not supported`。
* **原因**：SQLite 是檔案型資料庫，不需要 SQL 指令建立資料庫，只需要「建立檔案」。
* **解法**：直接執行 `doctrine:migrations:migrate`，Doctrine 會自動生成 `.db` 檔案。

## 3. 重要指令流（必背！）

開發新功能時的標準動作：

1. **建立/修改模型**：
`php bin/console make:entity` (依照提示輸入欄位)
2. **紀錄變化（產生遷移檔）**：
`php bin/console make:migration`
3. **同步資料庫（執行遷移）**：
`php bin/console doctrine:migrations:migrate`
4. **檢查同步狀態**：
`php bin/console doctrine:schema:validate`

## 4. 存入資料的邏輯

在 Controller 中，存入一筆資料的流程如下：

```php
// 1. 建立物件
$task = new Task();
$task->setTitle('學習 Symfony');

// 2. 透過 DI 注入 EntityManager
// 3. 告訴管理器：這筆資料我要存 (還沒真的進資料庫)
$entityManager->persist($task);

// 4. 真正執行 SQL 指令並寫入檔案
$entityManager->flush();

```

## 5. 為什麼要用 Migration (遷移)？

* **版本控制**：資料庫的結構變化會被記錄在 `migrations/` 資料夾下，這讓團隊開發時，別人只要跑一次指令就能同步你的資料表結構。
* **安全性**：避免手動進資料庫下 `ALTER TABLE` 指令導致人為失誤。

---

### 💡 今日感悟

> 「資料庫不再是一堆複雜的 SQL 指令，而是一個個可以被 `set` 和 `get` 的 PHP 物件。雖然 SQLite 的建立方式比較特別，但核心的 Migration 流程才是確保專案穩定的關鍵。」
