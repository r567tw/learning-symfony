<?php

namespace App\Controller;

use App\Entity\Task;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\TaskType;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use App\Service\TaskStatsCalculator;

class TaskController extends AbstractController
{
    #[Route('/tasks/new', name: 'app_task_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // 這裡就是「魔術」發生的地方：$task 已經被自動填滿了表單資料！
            $entityManager->persist($task);
            $entityManager->flush();

            return $this->redirectToRoute('app_task_list');
        }

        return $this->render('task/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    // #[Route('/task/create', name: 'app_task_create')]
    // public function create(EntityManagerInterface $entityManager): Response
    // {
    //     $task = new Task();
    //     $task->setName('學習 Drupal');
    //     $task->setCompleted(false);

    //     // 告訴 Doctrine 我想存這個物件
    //     $entityManager->persist($task);
    //     // 真正執行 SQL 寫入資料庫
    //     $entityManager->flush();

    //     return new Response('已建立任務，ID 為：' . $task->getId());
    // }
    #[Route('/tasks', name: 'app_task_list')]
    // #[IsGranted('ROLE_ADMIN')] // 👈 只有具備 ROLE_USER 的登入者能看
    public function list(TaskRepository $repo, TaskStatsCalculator $stats): Response
    {
        return $this->render('task/list.html.twig', [
            'tasks' => $repo->findAll(),
            'unfinished_count' => $stats->getUnfinishedCount(), // 👈 使用我們的 Service
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
