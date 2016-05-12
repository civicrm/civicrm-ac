<?php

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Task controller.
 *
 * @Route("/contributors")
 */
class ContributorController extends Controller
{
    /**
     * Lists all Task entities.
     *
     * @Route("/", name="contributor_index")
     * @Method("GET")
     */
    public function indexAction(Request $request, $type = null, $subtype = null)
    {
        $params = $this->getParams($request);        
        $qb = $this->getDoctrine()->getManager()->createQueryBuilder();
        $qb->select(array('c.name', 'c.contactId', 'count(t.id) as taskCount', 'sum(t.value) as taskValue'))
        ->from('AppBundle:Task', 't')
        ->join('t.identifier', 'i')
        ->join('i.contributor', 'c')
        ->addGroupBy('c.id')
        ->addOrderBy('taskCount', 'DESC')
        ->addOrderBy('c.contactId', 'ASC')
        ->andWhere('t.date >= :since')
        ->andWhere('t.date < :until')
        ->setParameter('since', $params['since'])
        ->setParameter('until', $params['until']);

        if($params['type']){
            $qb->andWhere('t.type = :type')
            ->setParameter('type', $params['type']);
        }
        if($params['subtype']){
            $qb->andWhere('t.subtype = :subtype')
            ->setParameter('subtype', $params['subtype']);
        }

        $contributors = $qb->getQuery()->getResult();
        
        return $this->render('contributor/index.html.twig', array(
            'contributors' => $contributors,
        ));
    }

    /**
    * Lists all Task entities.
    *
    * @Route("/{contactId}", name="contributor_view")
    * @Method("GET")
    */
    public function viewAction(Request $request, $contactId)
    {
        $params = $this->getParams($request);        
        $contributor = $this->getDoctrine()->getManager()->getRepository('AppBundle:Contributor')->findOneByContactId($contactId);
        $qb = $this->getDoctrine()->getManager()->createQueryBuilder();

        $qb->select(array('t'))
        ->from('AppBundle:Task', 't')
        ->join('t.identifier', 'i')
        ->join('i.contributor', 'c')
        ->setMaxResults(30)
        ->andWhere('t.date >= :since')
        ->andWhere('t.date < :until')
        ->andWhere('c.contactId = :contactId')
        ->addOrderBy('t.date', 'DESC')
        ->setParameter('since', $params['since'])
        ->setParameter('until', $params['until'])
        ->setParameter('contactId', $contactId);

        if($params['type']){
            $qb->andWhere('t.type = :type')
            ->setParameter('type', $params['type']);
        }
        if($params['subtype']){
            $qb->andWhere('t.subtype = :subtype')
            ->setParameter('subtype', $params['subtype']);
        }

        $tasks = $qb->getQuery()->getResult();
        
        return $this->render('contributor/view.html.twig', array(
            'contributor' => $contributor,
            'tasks' => $tasks,
        ));
    }
    
    function getParams($request){
        $params['type'] = $request->query->get('type');
        $params['subtype'] = $request->query->get('subtype');
        $since = $request->query->get('since');
        $until = $request->query->get('until');
        $params['since'] = new \DateTime($since ? $since : '-1 year');
        $params['until'] = new \DateTime($until ? $until : 'now');
        return $params;
    }

}
