<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Aceite;
use AppBundle\Entity\Aceituna;
use AppBundle\Entity\Cliente;
use AppBundle\Entity\Envase;
use AppBundle\Entity\Finca;
use AppBundle\Entity\Lote;
use AppBundle\Entity\Porcentaje;
use AppBundle\Entity\Procedencia;
use AppBundle\Entity\Producto;
use AppBundle\Entity\Socio;
use AppBundle\Entity\Temporada;
use AppBundle\Entity\Tipo;
use AppBundle\Entity\Usuario;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Tests\Fixtures\ContainerAwareFixture;


class DatosIniciales extends ContainerAwareFixture implements FixtureInterface
{

    /**
     * @var ContainerInterface
     */
    public $container;

    public function load(ObjectManager $manager)
    {
        //Temporada
        $temporadaAuxiliar = new Temporada();
        $temporadaAuxiliar
            ->setDenominacion('00/00');
        $manager->persist($temporadaAuxiliar);

        //Aceite
        $aceites = [
            [0, "Aceite Virgen Extra", 0.916, 3.80],
            [0, "Aceite Virgen", 0.916, 3.75],
            [0, "Aceite Lampante", 0.916, 3.68]
        ];

        $aceites2 = [];
        foreach ($aceites as $item) {
            $aceite = new Aceite();
            $aceite
                ->setDenominacion($item[1])
                ->setDensidadKgLitro($item[2])
                ->setPrecioKg($item[3]);

            $manager->persist($aceite);
            array_push($aceites2, $aceite);
        }

        //Aceituna
        $variedades = [
            [0, "Alberquina"],
            [0, "Gordal"],
            [0, "Hojiblanca"],
            [0, "Lechín"],
            [0, "Picual"],
        ];
        $variedades2 = [];

        foreach ($variedades as $item) {
            $variedad = new Aceituna();
            $variedad
                ->setDenominacion($item[1]);

            $manager->persist($variedad);
            array_push($variedades2, $variedad);
        }

        //Socio
        $socios = [
            [0, "2017-03-27", true],
            [0, "2017-03-27", true],
            [0, "2017-03-27", true]
        ];
        $socios2 = [];

        foreach ($socios as $item) {
            $socio = new Socio();
            $socio
                ->setFechaAlta(new \DateTime($item[1]))
                ->setActivo($item[2]);

            $manager->persist($socio);
            array_push($socios2, $socio);
        }

        //Usuario
        $usuarios = [
            [0, "75111567F", "Diego", "Hurtado Rosales", "C/ España, 23", "23320", "Torreperogil",
                "Jaén", "651378790", "dhurtadorosales@gmail.com", 0.10, true, true, true, false, false, false, true, $socios2[0]],
            [0, "26354843H", "Valentín", "González Molina", "C/ Cervantes, 9", "23700", "Linares",
                "Jaén", "625782462", null, 0.10, false, false, false, false, false, false, true, $socios2[1]],
            [0, "29478215Z", "Luis", "López Martínez", "C/ Rafael Alberti, 15-2ºB", "23700", "Linares",
                "Jaén", "614783565", null, 0.10, false, false, false, false, false, false, true, $socios2[2]],
            [0, "26983645J", "Joaquín", "Hernández Mota", "C/ Picasso, 26", "23700", "Linares",
                "Jaén", "614783835", null, 0.10, false, true, true, false, false, false, false, null],
            [0, "26471698H", "Pedro", "Román López", "C/ Lope de Vega, 34", "23700", "Linares",
                "Jaén", "618785365", null, 0.10, false, true, false, true, false, false, false, null],
            [0, "26456123A", "Antonio", "Martínez Huertas", "C/ Ramón y Cajal, 83","23700", "Linares",
                "Jaén", "614783565", null, 0.10, false, true, false, false, true, false, false, null],
            [0, "A23548796", "Koipe, S.A.", null, "Ctra/ Arjona, s/n", "24740", "Andújar",
                "Jaén", "953510065", "atencion.cliente@koipe.com", 0.07, false, false, false, false, false, true, false, null],
            [0, "A23548756", "Carbonell, S.A.", null, "C/ Marie Curie, 20", "28521", "Rivas Vaciamacrid",
                "Madrid", "902202107", "atencion.cliente@carbonell.com", 0.05, false, false, false, false, false, true, false, null],
            [0, "B41584732", "Grupo Ybarra, S.L.", null, "Ctra/ Isla Menorca, s/n", "41703", "Dos Hermanas",
                "Sevilla", "902014555", "consumidor@grupoybarra.com", 0.06, false, false, false, false, false, true, false, null],
            [0, "A23846985", "Coosur, S.A.", null, "Ctra/ La Carolina, s/n", "23220", "Vilches",
                "Jaén", "953631165", "info@coosur.com", 0, false, false, false, false, false, true, false, null]

        ];
        $usuarios2 = [];

        foreach ($usuarios as $item) {
            $usuario = new Usuario();
            $usuario
                ->setNif($item[1])
                ->setClave($this->container->get('security.password_encoder')->encodePassword($usuario, $item[1]))
                ->setNombre($item[2])
                ->setApellidos($item[3])
                ->setDireccion($item[4])
                ->setCodigoPostal($item[5])
                ->setLocalidad($item[6])
                ->setProvincia($item[7])
                ->setTelefono($item[8])
                ->setEmail($item[9])
                ->setDescuento($item[10])
                ->setAdministrador($item[11])
                ->setEmpleado($item[12])
                ->setComercial($item[13])
                ->setDependiente($item[14])
                ->setEncargado($item[15])
                ->setCliente($item[16])
                ->setRolSocio($item[17]);

            $manager->persist($usuario);
            array_push($usuarios2, $usuario);
        }

        //Asignación socios
        for ($i = 0; $i < sizeof($socios2); $i++) {
            $usuarios2[$i]
                ->setSocio($socios2[$i]);

            $manager->persist($usuarios2[$i]);;
        }

        //Finca
        $fincas = [
            [0, "Cañada de los Prados", "23", "88", "A", "016", "00078", "0000", "XK", 200, true, 0.30, 0.70, $variedades2[4], $socios2[0], $socios2[1]],
            [0, "Fuente del Ciervo", "13", "77", "A", "018", "00040", "0001", "FP", 300, true, 1, 0, $variedades2[4], $socios2[0], null],
            [0, "Montesina", "13", "77", "A", "018", "00041", "0002", "FP", 600, true, 1, 0, $variedades2[4], $socios2[2], null]
        ];

        foreach ($fincas as $item) {
            $finca = new Finca();
            $finca
                ->setDenominacion($item[1])
                ->setProvincia($item[2])
                ->setMunicipio($item[3])
                ->setSector($item[4])
                ->setPoligono($item[5])
                ->setParcela($item[6])
                ->setIdInmueble($item[7])
                ->setCaracterControl($item[8])
                ->setNumPlantas($item[9])
                ->setRegadio($item[10])
                ->setPartPropietario($item[11])
                ->setPartArrend($item[12])
                ->setVariedad($item[13])
                ->setPropietario($item[14])
                ->setArrendatario($item[15]);

            $manager->persist($finca);
        }

        //Procedencia
        $procedencias = [
            [0, "vuelo", 0.05],
            [0, "suelo", 0.0]
        ];

        foreach ($procedencias as $item) {
            $procedencia = new Procedencia();
            $procedencia
                ->setDenominacion($item[1])
                ->setBonificacion($item[2]);

            $manager->persist($procedencia);
        }

        //Porcentajes
        $porcentajes = [
            [0, "iva", 0.21],
            [0, "iva reducido", 0.10],
            [0, "retencion", 0.02],
            [0, "índice corrector", 0.02]
        ];

        foreach ($porcentajes as $item) {
            $porcentaje = new Porcentaje();
            $porcentaje
                ->setDenominacion($item[1])
                ->setCantidad($item[2]);

            $manager->persist($porcentaje);
        }

        //Envase
        $envases = [
            [0, "botella pvc 1L", 0.15],
            [0, "bidón pvc 5L", 0.10],
            [0, "botella vidrio 1L", 0.20]
        ];

        $envases2 = [];
        foreach ($envases as $item) {
            $envase = new Envase();
            $envase
                ->setDenominacion($item[1])
                ->setIncremento($item[2]);

            $manager->persist($envase);
            array_push($envases2, $envase);
        }

        //Lote
        $cantidad = 0;

        $lotes2 = [];
        foreach ($aceites2 as $item) {
            $lote = new Lote();
            $lote
                ->setNumero(0)
                ->setTemporada($temporadaAuxiliar)
                ->setCantidad($cantidad)
                ->setStock($cantidad)
                ->setAceite($item);

            $manager->persist($lote);
            array_push($lotes2, $lote);
        }

        //Producto
        $productos = [
            [0, 0, 3.80, $lotes2[0] , $envases2[0]],
            [0, 0, 3.75, $lotes2[1] , $envases2[0]],
            [0, 0, 3.48, $lotes2[2] , $envases2[0]],
            [0, 0, 3.60, $lotes2[0] , $envases2[1]],
            [0, 0, 3.25, $lotes2[1] , $envases2[1]],
            [0, 0, 3.30, $lotes2[2] , $envases2[1]],
            [0, 0, 3.68, $lotes2[0] , $envases2[2]],
            [0, 0, 3.43, $lotes2[1] , $envases2[2]],
            [0, 0, 3.59, $lotes2[2] , $envases2[2]],
        ];

        foreach ($productos as $item) {
        $producto = new Producto();
        $producto
            ->setStock($item[1])
            ->setPrecio($item[2])
            ->addLote($item[3])
            ->setEnvase($item[4]);

        $manager->persist($producto);
    }

        $manager->flush();
    }

    /**
     * Sets the container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}