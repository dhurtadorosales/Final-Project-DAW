<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Aceite;
use AppBundle\Entity\Lote;
use AppBundle\Entity\Temporada;
use AppBundle\Form\Type\LoteType;
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
    public function listarLotesAction(Temporada $temporada = null)
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

        return $this->render('lote/listar.html.twig', [
            'lotes' => $lotes,
            'temporada' => $temporada
        ]);
    }

    /**
     * @Route("/lotes/asignacion", name="lotes_asignacion")
     * @Security("is_granted('ROLE_ENCARGADO')")
     */
    public function listarLotesAsignacionAction()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        //Obtención temporada actual
        $temporadaActual = new TemporadaActual($em);
        $temporada = $temporadaActual->temporadaActualAction();

        //Obtención de los lotes de esta temporada
        $lotes = $em->getRepository('AppBundle:Lote')
            ->getLotesTemporadaNoNulos($temporada);

        //Obtención de las calidades de aceite
        $aceites = $em->getRepository('AppBundle:Aceite')
            ->findAll();

        return $this->render('lote/asignacion.html.twig', [
            'lotes' => $lotes,
            'aceites' => $aceites,
            'temporada' => $temporada
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
     * @Route("/lotes/aceite/asignar/{aceite}/{lote}", name="lotes_aceite_asignar")
     * @Security("is_granted('ROLE_ENCARGADO')")
     */
    public function aceiteAsignarAction(Aceite $aceite, Lote $lote)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        //Asigna el aceite al lote
        $em->persist($lote);
        $lote
            ->setAceite($aceite);
        $em->flush();
        $mensaje = 'Aceite asignado correctamente';
        return $this->render('producto/confirma.html.twig', [
            'mensaje' => $mensaje
        ]);
    }

    /**
     * @Route("/modificar/lote/{id}", name="modificar_lote")
     */
    public function formLoteAction(Request $request, Lote $lote)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(LoteType::class, $lote);
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
            'lote' => $lote,
            'formulario' => $form->createView()
        ]);
    }
}
