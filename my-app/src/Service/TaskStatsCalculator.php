<?php
namespace App\Service;

use App\Repository\TaskRepository;

class TaskStatsCalculator
{
    private $repository;

    // 1. 利用 DI 注入 Repository
    public function __construct(TaskRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getUnfinishedCount(): int
    {
        return $this->repository->count(['completed' => false]);
    }
}
