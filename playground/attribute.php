<?php

// 1. 定義一個屬性類別：用來標記「誰能執行這個動作」
#[Attribute]
class CanExecute {
    public function __construct(
        public string $role // 定義這個屬性接收一個角色名稱
    ) {}
}

// 2. 建立你的功能類別
class AdminPanel {
    
    #[CanExecute(role: 'ADMIN')]
    public function deleteUser() {
        echo "成功刪除使用者！\n";
    }

    #[CanExecute(role: 'GUEST')]
    public function viewPost() {
        echo "正在閱讀文章...\n";
    }
}

// 3. 模擬框架底層：檢查權限的「守門員」
function permissionChecker($className, $methodName, $userRole) {
    // 使用 Reflection (反射) 照鏡子，看那個方法上面貼了什麼標籤
    $reflection = new ReflectionMethod($className, $methodName);
    $attributes = $reflection->getAttributes(CanExecute::class);

    if (empty($attributes)) {
        echo "此方法沒有權限限制，可以直接執行。\n";
        return;
    }

    // 取得標籤實體
    $attributeInstance = $attributes[0]->newInstance();
    
    if ($attributeInstance->role === $userRole) {
        echo "✅ 權限通過！[$userRole] 匹配標籤上的 [{$attributeInstance->role}]\n";
        (new $className)->$methodName();
    } else {
        echo "❌ 權限拒絕！[$userRole] 無法執行標籤要求為 [{$attributeInstance->role}] 的動作。\n";
    }
}

// --- 測試開始 ---
echo "--- 測試一：管理者嘗試刪除 ---\n";
permissionChecker(AdminPanel::class, 'deleteUser', 'ADMIN');

echo "\n--- 測試二：訪客嘗試刪除 ---\n";
permissionChecker(AdminPanel::class, 'deleteUser', 'GUEST');