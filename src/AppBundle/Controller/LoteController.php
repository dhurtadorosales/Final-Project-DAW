<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Aceite;
use AppBundle\Entity\Lote;
use AppBundle\Entity\Temporada;
use AppBundle\Form\Model\ListaLotes;
use AppBundle\Form\Type\ListaLotesType;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Service\TemporadaActual;
use Symfony\Component\HttpFoundation\Request;

class LoteController extends Controller
{
    /**
     * @Route("/lotes/listar", name="lotes_listar")
     * @Route("/lotes/listar/{temporada}", name="lotes_listar_temporada")
     * @Security("is_granted('ROLE_ADMINISTRADOR') or is_granted('ROLE_EMPLEADO')")
     */
    public function listarLotesAction(Request $request, Temporada $temporada = null)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        //Si no recibe ninguna temporada se obtendrá la actual
        if (null === $temporada) {
            //Creamos una instancia del servicio
            $temporadaActual = new TemporadaActual($em);
            $temporada = $temporadaActual->temporadaActualAction();
        }

        $lotes = $em->getRepository('AppBundle:Lote')
            ->getLotesTemporada($temporada);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $lotes,
            $request->query->getInt('page', 1), 4
        );

        return $this->render('lote/listar.html.twig', [
            'lotes' => $lotes,
            'temporada' => $temporada,
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/lotes/listar/lote/{lote}", name="lotes_listar_lote")
     * @Security("is_granted('ROLE_ADMINISTRADOR') or is_granted('ROLE_EMPLEADO')")
     */
    public function listarLotesLoteAction(Lote $lote)
    {
        /** @var EntityManager $em */
        $em=$this->getDoctrine()->getManager();

        $resultados = $em->getRepository('AppBundle:Lote')
            ->getLoteUnico();

        return $this->render('lote/detalle.html.twig', [
            'resultados' => $resultados
        ]);
    }

    /**
     * @Route("/modificar/lote", name="modificar_lote")
     * @Security("is_granted('ROLE_ENCARGADO')")
     */
    public function formLoteAction(Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        //Obtención temporada actual
        $temporadaActual = new TemporadaActual($em);
        $temporada = $temporadaActual->temporadaActualAction();

        //Creación de un objeto de la clase ListaLotes
        $lista = new ListaLotes();

        //Obtención de los lotes de esta temporada que contienen aceite
        $lotes = $em->getRepository('AppBundle:Lote')
            ->getLotesTemporadaNoNulos($temporada);

        //Añadimos los lotes a la lista de lotes
        foreach ($lotes as $lote) {
            $lista->getLotes()->add($lote);
        }

        //Ejecución de formulario
        $form = $this->createForm(ListaLotesType::class, $lista);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em->flush();
                $this->addFlash('estado', 'Cambios guardados con éxito');
                return $this->redirectToRoute('principal');
            }
            catch(\Exception $e) {
                $this->addFlash('error', 'No se han podido guardar los cambios');
            }
        }

        return $this->render('lote/form.html.twig', [
            'lista' => $lista,
            'formulario' => $form->createView()
        ]);
    }

    /**
     * @Route("/lotes/temporadas/listar", name="lotes_temporadas_listar")
     * @Security("is_granted('ROLE_ADMINISTRADOR') or is_granted('ROLE_EMPLEADO')")
     */
    public function listarTemporadasAction()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $temporadas = $em->getRepository('AppBundle:Temporada')
            ->getTemporadas();

        return $this->render('lote/principal.html.twig', [
            'temporadas' => $temporadas
        ]);
    }
}
