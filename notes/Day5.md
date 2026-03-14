# 📅 Day 5：Twig 模板引擎 —— 前端顯示邏輯

## 1. 環境架構

* **安裝指令**：`composer require twig`（在 `skeleton` 版本中必做）。
* **檔案存放**：所有 `.html.twig` 檔案必須放在專案根目錄的 `templates/` 資料夾下。
* **Controller 串接**：Controller 必須繼承 `AbstractController`，並使用 `$this->render()` 方法。

## 2. Twig 三大語法

Twig 的語法非常直覺，主要分為三種括號：

| 語法 | 名稱 | 用途 | 範例 |
| --- | --- | --- | --- |
| **`{{ ... }}`** | **印出 (Output)** | 顯示變數、運算結果或函式回傳值 | `{{ user.name }}` |
| **`{% ... %}`** | **標籤 (Tag)** | 控制邏輯：迴圈、判斷、模板繼承 | `{% if user.isAdmin %}` |
| **`{# ... #}`** | **註解 (Comment)** | 僅供開發者查看，不會出現在 HTML 源碼中 | `{# 暫時隱藏此區塊 #}` |

## 3. 模板繼承 (Inheritance) —— 最強大的功能

這是為了避免重複寫一樣的 HTML 結構（如 Header, Footer）。

### A. 父模板 (`base.html.twig`)

定義大框架，並預留「洞」給子頁面填。

```twig
<html>
    <head><title>{% block title %}預設標題{% endblock %}</title></head>
    <body>
        <nav>這是導航列</nav>
        {% block body %}{% endblock %}
    </body>
</html>

```

### B. 子模板 (`index.html.twig`)

只寫改變的部分。

```twig
{% extends 'base.html.twig' %}

{% block title %}首頁{% endblock %}

{% block body %}
    <h1>歡迎來到首頁</h1>
{% endblock %}

```

## 4. 常用過濾器 (Filters)

Twig 內建許多方便的過濾器，用 `|`（管道符號）來呼叫：

* **`{{ name|upper }}`**：轉大寫。
* **`{{ date|date('Y-m-d') }}`**：格式化日期。
* **`{{ list|length }}`**：取得陣列長度。

## 5. 安全性：自動轉義 (Auto-escaping)

Twig 預設會防止 **XSS 攻擊**。如果變數裡包含 `<script>`，Twig 會自動將其轉義為純文字顯示。若你確信該 HTML 是安全的，需手動加上 `|raw`：

* `{{ my_html|raw }}`

---

### 💡 今日感悟

> 「Controller 負責找資料，Twig 負責擺放資料。兩者各司其職，程式碼就不會變成一團亂碼。這種 **關注點分離 (Separation of Concerns)** 是大型框架的核心思想。」

