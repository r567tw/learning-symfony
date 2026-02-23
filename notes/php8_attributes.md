# 📝 專題筆記：PHP 8 Attributes (原生屬性/註解)

## 1. 核心定義

* **是什麼**：PHP 8.0 引入的一種原生語法，用於給類別 (Class)、方法 (Method)、屬性 (Property) 加上**元數據 (Metadata)**。
* **比喻**：它就像是包裹上的「易碎品」或「此面朝上」**標籤**。標籤本身不具備保護功能，而是由**搬運工 (框架)** 看到標籤後決定如何處理。

## 2. 語法結構

```php
#[Attribute名稱(參數: '值')]
public function myMethod() { ... }

```

### 多重標籤 (Multiple Attributes)

可以同時疊加多個標籤，這是 Symfony 最常見的用法：

```php
#[Route('/api/task', methods: ['GET'])]  // 路由標籤
#[IsGranted('ROLE_USER')]                // 權限標籤
#[Cache(maxage: 3600)]                   // 快取標籤
public function getTasks() { ... }

```

## 3. 運作原理：反射 (Reflection)

Attribute 標籤在程式執行時**不會自動執行**。它必須透過 PHP 的 `Reflection` API 來讀取。

**運作流程：**

1. **定義標籤**：建立一個帶有 `#[Attribute]` 的類別。
2. **貼上標籤**：在目標代碼上方寫下 `#[...]`。
3. **讀取標籤**：框架底層使用 `ReflectionMethod::getAttributes()` 抓取標籤內容。
4. **執行邏輯**：框架根據抓到的標籤實例化 (newInstance)，並執行對應動作（如：導向網址、檢查權限）。

## 4. 為什麼比舊版 (Annotation) 好？

| 特性 | 舊版註解 (Annotations) | PHP 8 原生屬性 (Attributes) |
| --- | --- | --- |
| **格式** | 寫在 DocBlock 註解 `/** ... */` 裡 | 原生語法 `#[...]` |
| **效能** | 必須解析字串，速度較慢 | PHP 直接解析，效能極佳 |
| **強型別** | 容易寫錯字而不自知 | 支援 IDE 補完與類型檢查 |
| **來源** | 需要第三方套件 (Doctrine Annotations) | PHP 內建支援 |

## 5. 在框架中的角色

* **Symfony**: 靈魂核心。用於路由 (`#[Route]`)、驗證 (`#[Assert]`)、依賴注入標記等。
* **Laravel**: 較常出現在 Eloquent Model 的轉型 (Casts) 或關聯定義中。
* **Drupal**: 未來趨勢。Drupal 10+ 正在將大量的舊式註解 (Plugin Annotations) 遷移到 Attributes。

---

### 💡 學習體悟

> 「在 Symfony 裡，看到 `#[...]` 不要把它當成神奇魔術，要把它當成是一份**配置說明書**。我負責寫說明書，Symfony 的 **Service Container** 負責閱讀並執行它。」

### 與 Python Decorator 的異同：
- 相似處：都是為了實作 AOP (切面導向程式設計)，讓核心邏輯（如刪除使用者）與橫向邏輯（如權限、日誌）分離。
- 不同處：Python 是「函數包裹函數」的**動態攔截**；PHP 是「代碼標註資訊」的**靜態宣告**(必須有另一個地方寫了 $reflection->getAttributes()，事情才會發生)。