<?php

namespace Vince\Bundle\TypeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class RedactorController extends Controller
{

    public function uploadAction()
    {
        if (!$this->getRequest()->files->has('file')) {
            return new JsonResponse(array(
                'error' => $this->get('translator')->trans('redactor.messages.fileUploadError', array(), 'Vince')
            ));
        }
        $file = $this->getRequest()->files->get('file');
        $path = $this->container->getParameter('kernel.web_dir').$this->container->getParameter('kernel.uploads_path');
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }
        $file->move(realpath($path), $file->getClientOriginalName());

        return new JsonResponse(array(
            'filelink' => sprintf('%s/%s', $this->container->getParameter('kernel.uploads_path'), $file->getClientOriginalName()),
            'filename' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)
        ));
    }
}
