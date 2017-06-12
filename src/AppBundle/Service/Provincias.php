<?php

namespace AppBundle\Service;

use AppBundle\Entity\Socio;
use AppBundle\Entity\Temporada;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class Provincias extends Controller
{

    public function provinciasAction()
    {
        $provincias = [
            'Álava' => 'Álava',
            'Albacete' => 'Albacete',
            'Alicante' => 'Alicante',
            'Almería' => 'Almería',
            'Asturias' => 'Asturias',
            'Ávila' => 'Ávila',
            'Badajoz' => 'Badajoz',
            'Barcelona' => 'Barcelona',
            'Burgos' => 'Burgos',
            'Cáceres' => 'Cáceres',
            'Cádiz' => 'Cádiz',
            'Cantabria' => 'Cantabria',
            'Castellón' => 'Castellón',
            'Ciudad Real' => 'Ciudad Real',
            'Córdoba' => 'Córdoba',
            'Cuenca' => 'Cuenca',
            'Gerona' => 'Gerona',
            'Granada' => 'Granada',
            'Guadalajara' => 'Guadalajara',
            'Guipúzcoa' => 'Guipúzcoa',
            'Huelva' => 'Huelva',
            'Huesca' => 'Huesca',
            'Islas Baleares' => 'Islas Baleares',
            'Jaén' => 'Jaén',
            'La Coruña' => 'La Coruña',
            'La Rioja' => 'La Rioja',
            'Las Palmas' => 'Las Palmas',
            'León' => 'León',
            'Lérida' => 'Lérida',
            'Lugo' => 'Lugo',
            'Madrid' => 'Madrid',
            'Málaga' => 'Málaga',
            'Murcia' => 'Murcia',
            'Navarra' => 'Navarra',
            'Orense' => 'Orense',
            'Palencia' => 'Palencia',
            'Pontevedra' => 'Pontevedra',
            'Salamanca' => 'Salamanca',
            'Santa Cruz de Tenerife' => 'Santa Cruz de Tenerife',
            'Segovia' => 'Segovia',
            'Sevilla' => 'Sevilla',
            'Soria' => 'Soria',
            'Tarragona' => 'Tarragona',
            'Teruel' => 'Teruel',
            'Toledo' => 'Toledo',
            'Valencia' => 'Valencia',
            'Valladolid' => 'Valladolid',
            'Vizcaya' => 'Vizcaya',
            'Zamora' => 'Zamora',
            'Zaragoza' => 'Zaragoza'
        ];

        return $provincias;
    }
}