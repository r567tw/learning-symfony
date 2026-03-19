<?php
namespace App\EventListener;

use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;

#[AsEntityListener(event: Events::postPersist, method: 'postPersist', entity: Task::class)]
class TaskCreatedListener
{
    public function postPersist(Task $task): void
    {
        // 當 Task 被存入資料庫後，這裡會自動執行
        // 就像 Drupal 的 hook_entity_insert()
        // dump("耶！新任務「{$task->getName()}」被建立了，我來偷偷紀錄一下。");
    }
}
