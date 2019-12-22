<?php

namespace App\Controller;

use App\Entity\Tasks;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TodoListController extends AbstractController
{
    /**
     * @Route("/", name="todo_list")
     */
    public function index()
    {
        $tasks = $this->getDoctrine()->getRepository(Tasks::class)->findBy([], ['id' => 'DESC']);

        return $this->render('todo_list/index.html.twig', [
            'tasks' => $tasks,
        ]);
    }

    /**
     * @Route("/create", name="create_task", methods={"post"})
     */
    public function create(Request $request)
    {
        //Recuperamos o valor enviado através do método POST
        $title = $request->request->get('title');

        //Se o valor enviado for nulo, redirecionamos para á página inicial
        if (empty($title)) {
            $this->addFlash(
                'warning',
                'Informe um título válido para a tarefa'
            );
        }
        else {
            try {
                //Criamos o gerenciador da entidade
                $entityManager = $this->getDoctrine()->getManager();

                //Criamos o objeto tasks e setamos seus valores
                $tasks = new Tasks;
                $tasks->setTitle($title);
                $tasks->setStatus(0);

                //Persistimos as informação na base de dados
                $entityManager->persist($tasks);
                $entityManager->flush();

                $this->addFlash(
                    'success',
                    'Tarefa cadastrada!'
                );
            }
            catch(DBALException $e){
                $this->addFlash(
                    'error',
                    $e->getMessage()
                );
            }
            catch(\Exception $e){
                $this->addFlash(
                    'error',
                    $e->getMessage()
                );
            }
        }

        return $this->redirectToRoute('todo_list');
    }

    /**
     * @Route("/switch-status/{id}", name="switch_status")
     */
    public function switchStatus($id)
    {
        try {
            //Criamos o gerenciador da entidade
            $entityManager = $this->getDoctrine()->getManager();
            $task = $entityManager->getRepository(Tasks::class)->find($id);
            $task->setStatus(!$task->getStatus());
            $entityManager->flush();
            $this->addFlash(
                'success',
                'Tarefa atualizada!'
            );
        }
        catch(DBALException $e){
            $this->addFlash(
                'error',
                $e->getMessage()
            );
        }
        catch(\Exception $e){
            $this->addFlash(
                'error',
                $e->getMessage()
            );
        }

        return $this->redirectToRoute('todo_list');
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete($id)
    {
        exit('to do: delete the task'.$id);
    }
}
