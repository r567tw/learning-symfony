📝 Day 8 筆記要點 (對應 Drupal 學習)
FormType：這就是 Drupal 的 buildForm。它定義了表單欄位與類型。

handleRequest：這是處理 POST 數據的關鍵。它會自動把 $_POST 裡的資料塞進物件。

Validation Attributes：這對應 Drupal 的內容類型 (Content Type) 欄位設定。透過標籤定義規則，框架會自動在 $form->isValid() 時檢查。

CSRF Protection：Symfony 預設開啟。這對資安非常重要，確保請求是從你的網站發出的。