<?php

namespace Vince\Bundle\TypeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class TokenController extends Controller
{

    public function searchAction()
    {
        $repository = $this->get('doctrine.orm.entity_manager')->getRepository($this->getRequest()->get('entity'));
        if (!is_callable(array($repository, $this->getRequest()->get('method')))) {
            throw new \InvalidArgumentException(sprintf('Method %s is not callable in %s repository.', $this->getRequest()->get('method'), $this->getRequest()->get('entity')));
        }

        return new JsonResponse(call_user_func(array($repository, $this->getRequest()->get('method')), $this->getRequest()->get('query')));
    }
}
