<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Lote;
use AppBundle\Entity\Socio;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class FincaController extends Controller
{
    /**
     * @Route("/socio/fincas/listar", name="fincas_listar")
     */
    public function listarAction()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $fincas = $em->getRepository('AppBundle:Finca')
            ->getFincas();

        return $this->render('finca/listar.html.twig', [
            'fincas' => $fincas
        ]);

    }

    /**
     * @Route("/fincas/listar/lotes/{lote}", name="fincas_listar_lote")
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
