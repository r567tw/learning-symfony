<?php
namespace App\EventSubscriber;

use App\Service\TaskStatsCalculator; // 👈 引入
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class TaskCreatedSubscriber implements EventSubscriberInterface
{
    private $stats;

    // 在 Subscriber 裡也可以用 DI！
    public function __construct(TaskStatsCalculator $stats)
    {
        $this->stats = $stats;
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        if (!$event->isMainRequest()) return;

        $count = $this->stats->getUnfinishedCount();
        // 這裡我們用 dump 模擬 log，你會在 Profiler 看到它
        // dump("系統提示：目前還有 {$count} 個任務待辦");
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => 'onKernelRequest',
        ];
    }
}
