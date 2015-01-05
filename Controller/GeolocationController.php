<?php

/*
 * This file is part of the VinceType bundle.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Vince\Bundle\TypeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use JMS\Serializer\SerializationContext;

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
        // Fix for FOSRestBundle use
        if ($this->container->has('jms_serializer')) {
            return new Response($this->get('jms_serializer')->serialize($objects, 'json', SerializationContext::create()->setGroups(array('Default'))));
        }

        return new JsonResponse($objects);
    }
}
