# 📅 Day 4：服務配置與環境變數 (Service Configuration & Env)

### 1. 當「自動化」遇到瓶頸

**Autowiring** 很強，但它只能自動幫你處理「類別（Class）」。
如果你的 Service 建構子需要一個 **字串** 或 **數字**（例如 API Key、手續費率、或是某個開關設定），Symfony 就不知道該塞什麼給你了。

### 2. 實作練習：帶有參數的 Service

假設我們要寫一個 `TaxCalculator`（稅務計算器），它需要一個「稅率」才能運作。

#### 第一步：建立 Service

建立 `src/Service/TaxCalculator.php`：

```php
namespace App\Service;

class TaxCalculator
{
    private float $taxRate;

    // 注意：這裡的 $taxRate 是 float，Symfony 無法自動知道是多少
    public function __construct(float $taxRate)
    {
        $this->taxRate = $taxRate;
    }

    public function calculate(float $amount): float
    {
        return $amount * (1 + $this->taxRate);
    }
}

```

如果你現在直接在 Controller 注入這個 Service，Symfony 會噴出大大的錯誤訊息：

> *Cannot autowire service "App\Service\TaxCalculator": argument "$taxRate" of method "__construct()" is type-hinted "float", you should configure its value explicitly.*
> (這就是在說：我不知道這個 float 要填多少！)

---

### 3. 如何解決？在 `services.yaml` 手動餵食

這就是 `config/services.yaml` 出場的時候了。我們要在這裡幫這個參數「打標籤」。

打開 `config/services.yaml`，在 `services:` 區塊最下方加入：

```yaml
services:
    # ... 之前的預設設定
    
    App\Service\TaxCalculator:
        arguments:
            $taxRate: 0.05  # 手動告訴 Symfony，看到這個變數就填 0.05

```

這樣一來，Symfony 在幫你 `new TaxCalculator` 的時候，就會乖乖把 `0.05` 塞進建構子。

---

### 4. 進階：從 `.env` 讀取敏感資訊

在實務中，我們不會把 0.05 寫死在 YAML 裡，通常會放在 `.env` 檔案中。

**第一步：在專案根目錄的 `.env` 加入：**

```text
SITE_TAX_RATE=0.08

```

**第二步：在 `services.yaml` 引用它：**

```yaml
    App\Service\TaxCalculator:
        arguments:
            $taxRate: '%env(float:SITE_TAX_RATE)%'

```

---

### 5. 為什麼要這麼麻煩？

你可能會問：「我為什麼不在 `TaxCalculator` 裡面直接寫 `$_ENV['TAX_RATE']` 就好？」

1. **測試性**：如果你寫死在裡面，測試時你就很難模擬不同稅率的情況。
2. **解耦合**：你的 Service 變成了一個「純粹的工具」，它不知道外面環境變數叫什麼，它只知道「有人會給我一個稅率」。這讓你的代碼非常乾淨。

---

### 📝 Day 4 筆記要點 (建議存入 `notes/day04.md`)

* **Explicit Configuration (顯式配置)**：當 Autowiring 無法判斷參數（如 string, float, array）時，需在 `services.yaml` 手動定義 `arguments`。
* **Binding (綁定)**：如果很多 Service 都用到同一個參數，可以使用 `_defaults` 裡的 `bind` 功能（明天可以深挖）。
* **Env Var**：使用 `%env(TYPE:NAME)%` 語法將環境變數注入 Service。

