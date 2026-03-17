📝 Day 7 筆記要點 (建議存入 notes/day07.md)
Repository 查詢：findAll() 拿全部，findBy() 可以過濾與排序。

Path Helper：在 Twig 裡絕對不要寫死 <a href="/task/5">，務必使用 {{ path('路由名', {參數}) }}，這讓以後改路由網址時不需要動到模板。

自動轉換 (Value Resolver)：Controller 參數直接寫 Entity 型別，框架會自動處理查詢邏輯，這與 Drupal 的 Route Upcasting 邏輯完全一致。