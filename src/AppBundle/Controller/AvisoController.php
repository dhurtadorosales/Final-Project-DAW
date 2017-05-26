<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Aceite;
use AppBundle\Entity\Aviso;
use AppBundle\Entity\Lote;
use AppBundle\Entity\Temporada;
use AppBundle\Form\Model\ListaAceites;
use AppBundle\Form\Type\AceiteNuevoType;
use AppBundle\Form\Type\ListaAceitesType;
use AppBundle\Service\TemporadaActual;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;

class AvisoController extends Controller
{
    /**
     * @Route("/avisos/listar", name="avisos_listar")
     * @Security("is_granted('ROLE_ENCARGADO')")
     */
    public function indexAction()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        //Obtención de la temporada en vigor
        $temporadaActual = new TemporadaActual($em);
        $temporada = $temporadaActual->temporadaActualAction();

        //Obtención de los avisos de esta temporada
        $avisos = $em->getRepository('AppBundle:Aviso')
            ->getAvisosTemporada($temporada);

        return $this->render('aviso/listar.html.twig', [
            'avisos' => $avisos
        ]);
    }

    /**
     * @Route("/avisos/eliminar/{aviso}", name="avisos_eliminar")
     * @Security("is_granted('ROLE_ENCARGADO')")
     */
    public function eliminarAction(Aviso $aviso)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        try {
            $em->remove($aviso);
            $em->flush();
            $this->addFlash('estado', 'Aviso solucionado');
        }
        catch(Exception $e) {
            $this->addFlash('error', 'No se han podido eliminar');
        }

        return $this->redirectToRoute('avisos_listar');
    }
}
