📅 Day 9：Security 權限控制與 Event Subscriber 事件攔截
1. Security：誰能進來？進來能幹嘛？
Symfony 的安全機制像是一層層的「過濾網」，主要由三個部分組成：

User Entity：資料庫裡的帳號模型（透過 make:user 建立）。

Authenticator：門禁守衛，負責檢查帳號密碼（透過 make:auth 建立）。

Access Control：路由警察，負責檢查是否有權限。

🔐 實戰：限制路由權限
有三種方式可以限制 /tasks 必須登入：

Attribute 標籤 (最推薦)：#[IsGranted('ROLE_USER')] 加在 Controller 方法上。

設定檔 (全域)：在 security.yaml 的 access_control 區塊定義路徑規則。

手動檢查：在代碼內使用 $this->denyAccessUnlessGranted('ROLE_USER')。

Drupal 聯想：Drupal 的 *.routing.yml 中定義的 _permission 或 _role 就是這套邏輯的延伸。

2. Event Subscriber：當...發生時，我要自動...
這是 Symfony 解耦合的精髓，也是 Drupal 模組開發的靈魂。

核心概念：
Event (事件)：系統中發生的事情（例如：LoginSuccessEvent 登入成功）。

Dispatcher (發佈者)：負責大喊「有人登入成功了！」。

Subscriber (訂閱者)：坐在旁邊聽，聽到特定事件就跳出來執行程式碼。

🛠️ 實戰：監聽登入成功
PHP
public static function getSubscribedEvents(): array {
    return [
        LoginSuccessEvent::class => 'onLoginSuccess',
    ];
}
Drupal 聯想：在 Drupal 8/9/10 中，幾乎所有的 Hook（如 hook_node_insert）都已經被 Symfony 的 Event Subscriber 所取代。學會這個，你就能攔截 Drupal 的任何動作。

3. Data Fixtures：測試資料的王道
在開發階段，我們不手動進資料庫加 User。

使用 AppFixtures 配合 UserPasswordHasherInterface 來生成加密過的測試帳號。

指令：php bin/console doctrine:fixtures:load。

4. 關鍵指令複習 (Day 9)
php bin/console make:user：建立使用者類別。

php bin/console make:auth：建立登入表單與認證邏輯。

php bin/console make:subscriber：快速生成事件訂閱者模板。

php bin/console security:hash-password：手動計算密碼雜湊。