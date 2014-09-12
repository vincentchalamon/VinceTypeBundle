<?php

/*
 * This file is part of the VinceType bundle.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Vince\Bundle\TypeBundle\Controller;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * List objects for geolocation
 *
 * @author Vincent Chalamon <vincentchalamon@gmail.com>
 */
class GeolocationController extends Controller
{

    /**
     * List objects for geolocation
     *
     * @author Vincent Chalamon <vincentchalamon@gmail.com>
     *
     * @param Request $request
     *
     * @return JsonResponse
     * @throws \InvalidArgumentException
     */
    public function listAction(Request $request)
    {
        $objects = $this->get('doctrine.orm.default_entity_manager')->getRepository($request->get('class'))->findAll();

        return new JsonResponse($objects);
    }
}
