<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Liquidacion;
use AppBundle\Entity\Socio;
use AppBundle\Entity\Usuario;
use AppBundle\Form\Type\SocioType;
use AppBundle\Service\TemporadaActual;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
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
            ->getSocios();

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
        $em2 = $this->getDoctrine()->getManager();
        $em3 = $this->getDoctrine()->getManager();

        //Obtenemos la fecha actual
        $fecha = new \DateTime('now');

        //Obtención de la temporada actual
        $temporadaActual = new TemporadaActual($em);
        $temporada = $temporadaActual->temporadaActualAction();

        if (null == $socio) {
            //Nuevo socio
            $socio = new Socio();
            $em->persist($socio);

            //Nuevo usuario que debe ser asignado al nuevo socio
            $usuario = new Usuario();
            $socio->setUsuario($usuario);
            $em2->persist($usuario);

            $form = $this->createForm(SocioType::class, $socio);
            $form->handleRequest($request);

            //Si es válido
            if ($form->isSubmitted() && $form->isValid()) {
                try {
                    //Asignación fecha de alta y activo
                    $socio
                        ->setFechaAlta($fecha)
                        ->setActivo(true);

                    //Asignación de la clave. Será la misma que su nif
                    $socio
                        ->getUsuario()->setClave($form['nif']->getData());

                    //Crear la liquidación del socio
                    $liquidacion = new  Liquidacion();
                    $em3->persist($liquidacion);
                    $liquidacion
                        ->setTemporada($temporada)
                        ->setFecha($fecha)
                        ->setIva(0.1)
                        ->setRetencion(0.02)
                        ->setSocio($socio);
                    $em->flush();
                   // $em2->flush();
                    //$em3->flush();
                    $this->addFlash('estado', 'Socio guardado con éxito');
                    return $this->redirectToRoute('socios_listar');
                } catch (\Exception $e) {
                    $this->addFlash('error', 'No se ha podido guardar el socio');
                }
            }
        }
        else {
            $form = $this->createForm(SocioType::class, $socio);
            $form->handleRequest($request);

            //Si es válido
            if ($form->isSubmitted() && $form->isValid()) {
                try {
                    $em->flush();
                    $this->addFlash('estado', 'Socio guardado con éxito');
                    return $this->redirectToRoute('socios_listar');
                } catch (\Exception $e) {
                    $this->addFlash('error', 'No se ha podido guardar el socio');
                }
            }
        }

        return $this->render('socio/form.html.twig', [
            'formulario' => $form->createView()
        ]);
    }

    /**
     * @Route("/socios/eliminar/{socio}", name="socios_eliminar", methods={"GET"})
     * @Security("is_granted('ROLE_ADMINISTRADOR')")
     */
    public function borrarAction(Socio $socio)
    {
        return $this->render('socio/confirma.html.twig', [
            'socio' => $socio
        ]);
    }

    /**
     * @Route("/socios/eliminar/{socio}", name="confirmar_socios_eliminar", methods={"POST"})
     * @Security("is_granted('ROLE_ADMINISTRADOR')")
     */
    public function confirmarBorradoAction(Socio $socio)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        try {
            //Obtenemos el usuario correspondiente al socio
            $usuario = $socio->getUsuario();

            //Desactivamos al socio y al usuario si no es el administrador
            if ($usuario->getAdministrador() == true) {
                $this->addFlash('error', 'No se puede dar de baja a este empleado ya que es el administrador');
            }
            else {
                $socio->setActivo(false);
                $socio->setFechaBaja(new \DateTime('now'));
                $usuario->setActivo(false);
                $em->flush();
                $this->addFlash('estado', 'Socio eliminado con éxito');
            }
        }
        catch(Exception $e) {
            $this->addFlash('error', 'No se ha podido eliminar el socio');
        }

        return $this->redirectToRoute('socios_listar');
    }
}
