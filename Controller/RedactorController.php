<?php

namespace Vince\Bundle\TypeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

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

    public function listFilesAction($paths)
    {
        $files  = array();
        $paths  = explode('/', $paths);
        $webDir = $this->container->getParameter('kernel.web_dir');
        foreach ($paths as $path) {
            if (!substr($path, 0, 1) != '/') {
                $path = sprintf('/%s', $path);
            }
            if (realpath($webDir.$path)) {
                $finder = Finder::create()->files()->name('/\.(?:gif|png|jpg|jpeg)$/i');
                foreach ($finder->in(realpath($webDir.$path)) as $img) {
                    /** @var $img SplFileInfo */
                    $files[] = array(
                        'thumb'  => substr($img->getRealPath(), strlen(realpath($webDir))),
                        'image'  => substr($img->getRealPath(), strlen(realpath($webDir))),
                        'title'  => pathinfo($img->getRealPath(), PATHINFO_FILENAME),
                        'folder' => pathinfo($path, PATHINFO_BASENAME)
                    );
                }
            }
        }

        return new JsonResponse($files);
    }
}
