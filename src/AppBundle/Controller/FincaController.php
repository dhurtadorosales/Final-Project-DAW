<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Lote;
use AppBundle\Entity\Socio;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class FincaController extends Controller
{
    /**
     * @Route("/fincas/listar", name="fincas_listar")
     * @Security("is_granted('ROLE_ADMINISTRADOR')")
     */
    public function listarAction()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $fincas = $em->getRepository('AppBundle:Finca')
            ->findAll();

        return $this->render('finca/listar.html.twig', [
            'fincas' => $fincas
        ]);

    }

    /**
     * @Route("/fincas/listar/lote/{lote}", name="fincas_listar_lote")
     */
    public function listarPorLoteAction(Lote $lote)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $fincas = $em->getRepository('AppBundle:Finca')
            ->getFincasPorLote($lote);

        return $this->render('finca/listar.html.twig', [
            'fincas' => $fincas
        ]);
    }

    /**
     * @Route("/fincas/listar/propietario/{socio}", name="fincas_listar_propietario")
     * @Security("is_granted('ROLE_ADMINISTRADOR', 'ROLE_SOCIO')")
     */
    public function listarPorPropietarioAction(Socio $socio)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $fincas = $em->getRepository('AppBundle:Finca')
            ->getFincasPorPropietario($socio);

        return $this->render('finca/listar.html.twig', [
            'fincas' => $fincas
        ]);
    }

    /**
     * @Route("/fincas/listar/arrendatario/{socio}", name="fincas_listar_arrendatario")
     * @Security("is_granted('ROLE_ADMINISTRADOR', 'ROLE_SOCIO')")
     */
    public function listarPorArrendatarioAction(Socio $socio)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $fincas = $em->getRepository('AppBundle:Finca')
            ->getFincasPorArrendatario($socio);

        return $this->render('finca/listar.html.twig', [
            'fincas' => $fincas
        ]);
    }
}
