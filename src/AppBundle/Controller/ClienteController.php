<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Cliente;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ClienteController extends Controller
{
    /**
     * @Route("/clientes/listar", name="clientes_listar")
     */
    public function indexAction()
    {
        /** @var EntityManager $em */
        $em=$this->getDoctrine()->getManager();

        $clientes = $em->createQueryBuilder()
            ->select('c')
            ->from('AppBundle:Cliente', 'c')
            ->getQuery()
            ->getResult();

        return $this->render('cliente/listar.html.twig', [
            'clientes' => $clientes,
        ]);
    }

    /**
     * @Route("/clientes/insertar", name="clientes_insertar")
     */
    public function insertarAction()
    {
        $clientes = [
            [0, "A23548796", "Koipe, S.A.", "", "Ctra/ Arjona", "s/n", "", "", "", "", "24740", "Andújar", "Jaén", "953510065", "atencion.cliente@koipe.com", 10],
            [0, "A23548756", "Carbonell, S.A.", "", "C/ Marie Curie", "20", "", "", "", "", "28521", "Rivas Vaciamacrid", "Madrid", "902202107", "atencion.cliente@carbonell.com", 15],
            [0, "B41584732", "Grupo Ybarra, S.L.", "", "Ctra/ Isla Menorca", "s/n", "", "", "", "", "41703", "Dos Hermanas", "Sevilla", "902014555", "consumidor@grupoybarra.com", 10],
            [0, "A23846985", "Coosur, S.A.", "", "Ctra/ La Carolina", "s/n", "", "", "", "", "23220", "Vilches", "Jaén", "953631165", "info@coosur.com", 0]
        ];

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        foreach ($clientes as $item) {
            $cliente = new Cliente();
            $em->persist($cliente);
            $cliente
                ->setNif($item[1])
                ->setNombre($item[2])
                ->setApellidos($item[3])
                ->setCalle($item[4])
                ->setNumero($item[5])
                ->setBloque($item[6])
                ->setEscalera($item[7])
                ->setPiso($item[8])
                ->setLetra($item[9])
                ->setCodigoPostal($item[10])
                ->setLocalidad($item[11])
                ->setProvincia($item[12])
                ->setTelefono($item[13])
                ->setEmail($item[14])
                ->setDescuento(15);

            $em->flush();
        }
        $mensaje = 'Clientes insertados correctamente';

        return $this->render('cliente/operaciones.html.twig', [
            'mensaje' => $mensaje
        ]);
    }
}
