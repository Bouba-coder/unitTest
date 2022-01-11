<?php

namespace App\Controller;

use App\Entity\Tasks;
use App\Form\TasksType;
use App\Repository\TasksRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/task')]
class TasksController extends AbstractController
{
    #[Route('/', name: 'tasks_index', methods: ['GET'])]
    public function index(TasksRepository $tasksRepository): Response
    {
        return $this->render('task/index.html.twig', [
            'task' => $tasksRepository->findAll(),
        ]);
    }


    #check item addTime
    public function checkAddTime($tasksTimeStart, $getTaskTime)
    {
        $dteEnd   = new \DateTime($tasksTimeStart);
        $dteDiff  = $getTaskTime->diff($dteEnd);
        return $dteDiff->format("%I");
    }

    //custom getItems by id_users
    public function getItem(int $id_users, ProductRepository $itemRepository): Response
    {
        $item = $itemRepository
        ->where('id_users', $id_users);
        return $this->getId()->matching($item);
    }
    //Custom add item function
    public function addItem($name, $content, $id_users)
    {
        //$task = new Tasks();
        //ManagerRegistry $doctrine;
        $task = new Tasks();
        $task->setName($name);
        $task->setIdUsers($id_users);
        $task->setContent($content);
        $task->setCreateDate(new \DateTime('@'.strtotime('now')));
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($task);
        // Executing queries
        $entityManager->flush();

        $take = $this->getDoctrine()->getRepository(Tasks::class)->find($id_users);
        return $take->getName();
    }



    #[Route('/new', name: 'tasks_new', methods: ['GET','POST'])]
    public function new(Request $request): Response
    {
        $task = new Tasks();
        $form = $this->createForm(TasksType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($task);
            $entityManager->flush();

            return $this->redirectToRoute('tasks_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('task/new.html.twig', [
            'task' => $task,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'tasks_show', methods: ['GET'])]
    public function show(Tasks $task): Response
    {
        return $this->render('task/show.html.twig', [
            'task' => $task,
        ]);
    }

    #[Route('/{id}/edit', name: 'tasks_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Tasks $task): Response
    {
        $form = $this->createForm(TasksType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tasks_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('task/edit.html.twig', [
            'task' => $task,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'tasks_delete', methods: ['POST'])]
    public function delete(Request $request, Tasks $task): Response
    {
        if ($this->isCsrfTokenValid('delete'.$task->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($task);
            $entityManager->flush();
        }

        return $this->redirectToRoute('tasks_index', [], Response::HTTP_SEE_OTHER);
    }
}
