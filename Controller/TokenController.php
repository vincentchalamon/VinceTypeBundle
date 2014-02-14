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
     * @return JsonResponse
     * @throws \InvalidArgumentException
     */
    public function searchAction()
    {
        $repository = $this->get('doctrine.orm.default_entity_manager')->getRepository($this->getRequest()->get('entity'));
        if (!is_callable(array($repository, $this->getRequest()->get('method')))) {
            throw new \InvalidArgumentException(sprintf('Method %s is not callable in %s repository.', $this->getRequest()->get('method'), $this->getRequest()->get('entity')));
        }

        return new JsonResponse(call_user_func(array($repository, $this->getRequest()->get('method')), $this->getRequest()->get('query')));
    }
}
