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
 * Search results for token completion
 *
 * @author Vincent Chalamon <vincentchalamon@gmail.com>
 */
class TokenController extends Controller
{

    /**
     * Search results for token completion
     *
     * @author Vincent Chalamon <vincentchalamon@gmail.com>
     *
     * @param Request $request
     *
     * @return JsonResponse
     * @throws \InvalidArgumentException
     */
    public function searchAction(Request $request)
    {
        $em = $this->get('doctrine.orm.default_entity_manager');
        if (!is_callable(array($em->getRepository($request->get('class')), $request->get('searchMethod')))) {
            throw new \InvalidArgumentException(sprintf('Method %s is not callable in %s repository.', $request->get('searchMethod'), $request->get('class')));
        }

        return new JsonResponse($this->parse($em, $request));
    }

    /**
     * Parse results for inputToken
     *
     * @author Vincent Chalamon <vincentchalamon@gmail.com>
     *
     * @param ObjectManager $entityManager
     * @param Request       $request
     *
     * @return array
     */
    protected function parse(ObjectManager $entityManager, Request $request)
    {
        $results = call_user_func(array($entityManager->getRepository($request->get('class')), $request->get('searchMethod')), $request->get('query'));
        $tokens  = array();
        foreach ($results as $result) {
            $tokens[] = array(
                'id'   => call_user_func(array($result, $request->get('identifierMethod'))),
                'name' => call_user_func(array($result, $request->get('renderMethod')))
            );
        }

        return $tokens;
    }
}
