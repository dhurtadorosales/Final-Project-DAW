<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Socio;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DepositoController extends Controller
{
    /**
     * @Route("/depositos/listar", name="depositos_listar")
     */
    public function indexAction()
    {
        /** @var EntityManager $em */
        $em=$this->getDoctrine()->getManager();

        $depositos = $em->createQueryBuilder()
            ->select('d')
            ->from('AppBundle:Deposito', 'd')
            ->getQuery()
            ->getResult();

        return $this->render('deposito/listar.html.twig', [
            'depositos' => $depositos
        ]);
    }
}
