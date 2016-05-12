<?php

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Task;

/**
 * Task controller.
 *
 * @Route("/tasks")
 */
class TaskController extends Controller
{
    /**
     * Lists all Task entities.
     *
     * @Route("/", name="task_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tasks = $this->getDoctrine()->getManager()
        ->createQuery('SELECT t FROM AppBundle:Task t ORDER BY t.date DESC')
        ->setMaxResults(1000)
        ->getResult();

        return $this->render('task/index.html.twig', array(
            'tasks' => $tasks,
        ));
    }

    /**
     * Finds and displays a Task entity.
     *
     * @Route("/{id}", name="task_view")
     * @Method("GET")
     */
    public function showAction(Task $task)
    {

        return $this->render('task/view.html.twig', array(
            'task' => $task,
        ));
    }
}
