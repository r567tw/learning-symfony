<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Service\MessageGenerator; // 引入剛寫的 Service

final class HelloController extends AbstractController
{
    #[Route('/hello', name: 'app_hello')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Hello, World!',
            'day' => 1
        ]);
    }

    #[Route('/task/{id}', name: 'app_task_show')]
    public function show(int $id): JsonResponse
    {
        return $this->json([
            'task_id' => $id,
            'title' => "這是第 {$id} 號任務的標題",
            'description' => '從網址抓到了 ID！'
        ]);
    }

    #[Route('/task/{slug}/{id}', name: 'app_task_slug')]
    public function showSlug(string $slug, int $id): JsonResponse
    {
        return $this->json([
            'task_id' => $id,
            'slug' => $slug,
            'title' => "這是第 {$id} 號任務的標題",
            'description' => '從網址抓到了 ID！'
        ]);
    }

    #[Route('/search', name: 'app_search')]
    public function search(Request $request): JsonResponse
    {
        // 獲取網址 ?keyword=apple 的值，如果沒有則預設為 'nothing'
        $keyword = $request->query->get('keyword', 'nothing');

        return $this->json([
            'searching_for' => $keyword,
            'method' => $request->getMethod(), // 取得請求方法 (GET/POST)
            'client_ip' => $request->getClientIp()
        ]);
    }

    #[Route('/lucky', name: 'app_lucky')]
    public function lucky(MessageGenerator $messageGenerator): JsonResponse
    {
        return $this->json([
            'message' => $messageGenerator->getHappyMessage()
        ]);
    }
}
