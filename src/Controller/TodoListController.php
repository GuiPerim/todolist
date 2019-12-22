<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TodoListController extends AbstractController
{
    /**
     * @Route("/", name="todo_list")
     */
    public function index()
    {
        return $this->render('todo_list/index.html.twig', [
            'controller_name' => 'TodoListController',
        ]);
    }

    /**
     * @Route("/create", name="create_task", methods={"post"})
     */
    public function create()
    {
        exit('to do: create a new task');
    }

    /**
     * @Route("/switch-status/{id}", name="switch_status")
     */
    public function switchStatus($id)
    {
        exit('to do: update the status of a task'.$id);
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete($id)
    {
        exit('to do: delete the task'.$id);
    }
}
