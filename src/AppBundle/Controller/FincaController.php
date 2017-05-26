<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Finca;
use AppBundle\Entity\Lote;
use AppBundle\Entity\Socio;
use AppBundle\Form\Type\FincaModificarType;
use AppBundle\Form\Type\FincaType;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;

class FincaController extends Controller
{
    /**
     * @Route("/fincas/listar", name="fincas_listar")
     * @Security("is_granted('ROLE_ADMINISTRADOR')")
     */
    public function listarAction(Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $fincas = $em->getRepository('AppBundle:Finca')
            ->getFincas();

        //Variable auxiliar
        $lote = false;
        $propietario = false;
        $arrendatario = false;

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $fincas,
            $request->query->getInt('page', 1), 4
        );

        return $this->render('finca/listar.html.twig', [
            'fincas' => $fincas,
            'lote' => $lote,
            'propietario' => $propietario,
            'arrendatario' => $arrendatario,
            'pagination' => $pagination
        ]);

    }

    /**
     * @Route("/fincas/listar/lote/{lote}", name="fincas_listar_lote")
     * @Security("is_granted('ROLE_ADMINISTRADOR') or is_granted('ROLE_EMPLEADO') or is_granted('ROLE_SOCIO')")
     */
    public function listarPorLoteAction(Request $request, Lote $lote)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $fincas = $em->getRepository('AppBundle:Finca')
            ->getFincasPorLote($lote);

        //Variable auxiliar
        $propietario = false;
        $arrendatario = false;

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $fincas,
            $request->query->getInt('page', 1), 4
        );

        return $this->render('finca/listar.html.twig', [
            'fincas' => $fincas,
            'lote' => $lote,
            'propietario' => $propietario,
            'arrendatario' => $arrendatario,
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/fincas/listar/propietario/{socio}", name="fincas_listar_propietario")
     * @Security("is_granted('ROLE_ADMINISTRADOR') or user.getNif() == socio.getUsuario().getNif()")
     */
    public function listarPorPropietarioAction(Request $request, Socio $socio)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $fincas = $em->getRepository('AppBundle:Finca')
            ->getFincasPorPropietario($socio);

        //Variable auxiliar
        $lote = false;
        $arrendatario = false;

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $fincas,
            $request->query->getInt('page', 1), 4
        );

        return $this->render('finca/listar.html.twig', [
            'fincas' => $fincas,
            'lote' => $lote,
            'propietario' => $socio,
            'arrendatario' => $arrendatario,
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/fincas/listar/arrendatario/{socio}", name="fincas_listar_arrendatario")
     * @Security("is_granted('ROLE_ADMINISTRADOR') or user.getNif() == socio.getUsuario().getNif()")
     */
    public function listarPorArrendatarioAction(Request $request, Socio $socio)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $fincas = $em->getRepository('AppBundle:Finca')
            ->getFincasPorArrendatario($socio);

        //Variable auxiliar
        $lote = false;
        $propietario = false;

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $fincas,
            $request->query->getInt('page', 1), 4
        );

        return $this->render('finca/virgen_extra.html.twig', [
            'fincas' => $fincas,
            'lote' => $lote,
            'propietario' => $propietario,
            'arrendatario' => $socio,
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/fincas/buscar", name="fincas_buscar")
     * @Security("is_granted('ROLE_ADMINISTRADOR')")
     */
    public function buscarFincasAction(Request $request)
    {
        //Variable auxiliar
        $lote = false;
        $propietario = false;
        $arrendatario = false;

        if ('' === $request) {
            return $this->listarAction($request);
        }
        else {
            /** @var EntityManager $em */
            $em = $this->getDoctrine()->getManager();
            $fincas = $em->getRepository('AppBundle:Finca')
                ->buscarFincas($request->get('buscar'));

            $paginator = $this->get('knp_paginator');
            $pagination = $paginator->paginate(
                $fincas,
                $request->query->getInt('page', 1), 4
            );
        }

        return $this->render('finca/virgen_extra.html.twig', [
            'fincas' => $fincas,
            'lote' => $lote,
            'propietario' => $propietario,
            'arrendatario' => $arrendatario,
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/fincas/nueva", name="fincas_nueva")
     * @Route("/fincas/modificar/{finca}", name="fincas_modificar")
     * @Security("is_granted('ROLE_ADMINISTRADOR')")
     */
    public function formAction(Request $request, Finca $finca = null)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        if (null == $finca) {
            $finca = new Finca();
            $em->persist($finca);

            $form = $this->createForm(FincaType::class, $finca);

        }
        else {
            $form = $this->createForm(FincaModificarType::class, $finca);
        }
        $form->handleRequest($request);

        //Si es válido
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                if ($form['partArrend']->getData() != 0 and $form['arrendatario']->getData() == null) {
                    $this->addFlash('error', 'El arrendatario no puede ser nulo si su participación es mayor que 0');
                }
                else {
                    if ($form['partPropietario']->getData() == 1) {
                        $finca
                            ->setPartArrend(0)
                            ->setArrendatario(null)
                            ->setActiva(true);
                    }
                    $em->flush();
                    $this->addFlash('estado', 'Finca guardada con éxito');
                    return $this->redirectToRoute('fincas_listar');
                }
            }
            catch(\Exception $e) {
                $this->addFlash('error', 'No se ha podido guardar la finca');
            }
        }

        return $this->render('finca/form.html.twig', [
            'formulario' => $form->createView(),
            'finca' => $finca
        ]);
    }

    /**
     * @Route("/fincas/eliminar/{finca}", name="fincas_eliminar", methods={"GET"})
     * @Security("is_granted('ROLE_ADMINISTRADOR')")
     */
    public function borrarAction(Finca $finca)
    {
        return $this->render('finca/confirma.html.twig', [
            'finca' => $finca
        ]);
    }

    /**
     * @Route("/fincas/eliminar/{finca}", name="confirmar_fincas_eliminar", methods={"POST"})
     * @Security("is_granted('ROLE_ADMINISTRADOR')")
     */
    public function confirmarBorradoAction(Finca $finca)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        try {
            $finca->setActiva(false);
            $em->flush();
            $this->addFlash('estado', 'Finca eliminada con éxito');
        }
        catch(Exception $e) {
            $this->addFlash('error', 'No se ha podido eliminar la finca');
        }

        return $this->redirectToRoute('fincas_listar');
    }
}
