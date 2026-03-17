<?php
namespace App\Controller;

use App\Entity\Task;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TaskController extends AbstractController
{
    #[Route('/task/create', name: 'app_task_create')]
    public function create(EntityManagerInterface $entityManager): Response
    {
        $task = new Task();
        $task->setName('學習 Drupal');
        $task->setCompleted(false);

        // 告訴 Doctrine 我想存這個物件
        $entityManager->persist($task);
        // 真正執行 SQL 寫入資料庫
        $entityManager->flush();

        return new Response('已建立任務，ID 為：' . $task->getId());
    }

    #[Route('/tasks', name: 'app_task_list')]
    public function list(TaskRepository $taskRepository): Response
    {
        $tasks = $taskRepository->findAll();
        return $this->render('task/list.html.twig', [
            'tasks' => $tasks,
        ]);
    }

    #[Route('/tasks/{id}', name: 'app_task_show')]
    public function show(Task $task): Response
    {
        return $this->render('task/show.html.twig', [
            'task' => $task,
        ]);
    }
}
