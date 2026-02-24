恭喜你！手寫出第一個 Service 並看著它被自動注入（Autowiring），是理解 Symfony 最關鍵的一步。這代表你已經從「寫腳本」的思維進化到「設計系統」的思維了。

以下是為你整理的 **Day 3 筆記**，你可以直接存入 `notes/day03.md`。

---

# 📅 Day 3：依賴注入 (DI) 與服務容器 (Service Container)

## 1. 核心概念：Service (服務)

* **定義**：在 Symfony 中，任何執行特定任務的 PHP 物件都稱為 **Service**。
* **範例**：發送郵件的類別、處理數學運算的類別、甚至是你寫的 Controller。
* **管理**：所有的 Service 都存放在一個稱為 **Service Container** 的「大盒子」裡統一管理。

## 2. 核心技術：依賴注入 (Dependency Injection)

* **傳統做法 (不可取)**：在類別內直接 `new` 另一個物件。這會導致代碼耦合度高，難以測試。
* **DI 做法 (Symfony 風格)**：你只需要在方法或建構子的參數中**宣告 (Type-hint)** 你需要的類別，框架會自動把實例化好的物件「塞」給你。

## 3. 實作紀錄：建立自定義 Service

為了練習，我建立了一個 `MessageGenerator` 服務。

### A. 建立類別 (`src/Service/MessageGenerator.php`)

```php
namespace App\Service;

class MessageGenerator {
    public function getHappyMessage(): string {
        return "太棒了，這就是 DI 的力量！";
    }
}

```

### B. 在 Controller 注入使用

```php
public function lucky(MessageGenerator $messageGenerator): JsonResponse {
    // 框架自動執行了：$messageGenerator = new MessageGenerator();
    $message = $messageGenerator->getHappyMessage();
    return $this->json(['message' => $message]);
}

```

## 4. 自動裝配 (Autowiring) 運作原理

1. **掃描**：Symfony 啟動時會掃描 `src/` 下的所有類別。
2. **註冊**：預設情況下，`src/` 下的所有類別都會自動註冊為 Service。
3. **匹配**：當你在 Controller 寫下 `MessageGenerator $mg`，Symfony 會在容器中尋找類型為 `MessageGenerator` 的物件。
4. **注入**：找到後，自動將其傳入方法中。

## 5. 實用指令

| 指令 | 說明 |
| --- | --- |
| `php bin/console debug:autowiring` | 列出目前專案中所有可以被自動注入的服務。 |
| `php bin/console debug:container` | 顯示容器中所有的服務詳細資訊。 |

---

## 💡 與 Drupal 的連結

* **Drupal 10+** 同樣基於 Symfony 的 Service Container。
* 在 Drupal 中，你會在 `*.services.yml` 檔案中看到這些 Service 的定義。
* 理解了 DI，未來在開發 Drupal 模組時，你就能輕易地調用核心提供的各種功能（如 `current_user`, `database`, `entity_type.manager`）。