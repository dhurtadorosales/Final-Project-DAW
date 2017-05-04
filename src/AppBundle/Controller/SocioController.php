<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Socio;
use AppBundle\Form\Type\SocioType;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SocioController extends Controller
{
    /**
     * @Route("/socios/listar", name="socios_listar")
     * @Security("is_granted('ROLE_ADMINISTRADOR')")
     */
    public function listarAction()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $socios = $em->getRepository('AppBundle:Socio')
            ->findAll();

        return $this->render('socio/listar.html.twig', [
            'socios' => $socios
        ]);
    }

    /**
     * @Route("/socios/nuevo", name="socios_nuevo")
     * @Route("/socios/modificar/{socio}", name="socios_modificar")
     * @Security("is_granted('ROLE_ADMINISTRADOR')")
     */
    public function formClienteAction(Request $request, Socio $socio = null)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        if (null == $socio) {
            $socio = new Socio();
            $em->persist($socio);
        }

        //Obtenemos la fecha actual
        $fecha = new \DateTime('now');

        $form = $this->createForm(SocioType::class, $socio, [
            'fecha' => $fecha
        ]);
        $form->handleRequest($request);

        //Si es válido
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em->flush();
                $this->addFlash('estado', 'Empleado guardado con éxito');
                return $this->redirectToRoute('principal');
            }
            catch(\Exception $e) {
                $this->addFlash('error', 'No se han podido guardar el empleado');
            }
        }

        return $this->render('socio/form.html.twig', [
            'formulario' => $form->createView()
        ]);
    }
}
