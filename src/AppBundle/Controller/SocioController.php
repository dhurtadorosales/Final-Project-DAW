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

        //Obtenemos la fecha actual
        $fecha = new \DateTime('now');

        //Obtención del usuario correspondiente al socio
        //$usuario = new Usuario();
        //$usuario->setSocio($socio);

        $usuario= $socio->getUsuario();

        //Obtención de la temporada actual
        $temporadaActual = new TemporadaActual($em);
        $temporada = $temporadaActual->temporadaActualAction();

        if (null == $socio) {
            $socio = new Socio();
            $em->persist($socio);

            $form = $this->createForm(SocioType::class, $socio, [
                'fecha' => $fecha,
                'usuario' => $usuario
            ]);
            $form->handleRequest($request);

            //Si es válido
            if ($form->isSubmitted() && $form->isValid()) {
                try {

                    //Crear nuevo usuario


                    //Crear la liquidación del socio
                    $liquidacion = new  Liquidacion();
                    $liquidacion
                        ->setTemporada($temporada)
                        ->setFecha($fecha)
                        ->setIva(0.1)
                        ->setRetencion(0.02)
                        ->setSocio($socio);
                    $em->flush();
                    $this->addFlash('estado', 'Socio guardado con éxito');
                    return $this->redirectToRoute('principal');
                } catch (\Exception $e) {
                    $this->addFlash('error', 'No se ha podido guardar el socio');
                }
            }
        }
        else {
            $form = $this->createForm(SocioType::class, $socio, [
                'fecha' => $fecha,
                'usuario' => $usuario
            ]);
            $form->handleRequest($request);

            //Si es válido
            if ($form->isSubmitted() && $form->isValid()) {
                try {
                    $em->flush();
                    $this->addFlash('estado', 'Socio guardado con éxito');
                    return $this->redirectToRoute('principal');
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
