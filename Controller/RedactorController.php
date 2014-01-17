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
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

/**
 * Files features for redactor
 *
 * @author Vincent Chalamon <vincent@ylly.fr>
 */
class RedactorController extends Controller
{

    /**
     * Upload file to user public directory
     *
     * @author Vincent Chalamon <vincent@ylly.fr>
     * @return JsonResponse
     */
    public function uploadAction()
    {
        if (!$this->getRequest()->files->has('file')) {
            return new JsonResponse(array(
                'error' => $this->get('translator')->trans('redactor.messages.fileUploadError', array(), 'Vince')
            ));
        }
        $file   = $this->getRequest()->files->get('file');
        $web    = rtrim($this->container->getParameter('kernel.web_dir'), '/');
        $upload = rtrim($this->container->getParameter('kernel.uploads_path'), '/');
        if (!is_dir($web.$upload)) {
            mkdir($web.$upload, 0777, true);
        }
        $file->move(realpath($web.$upload), $file->getClientOriginalName());

        return new JsonResponse(array(
            'filelink' => sprintf('%s/%s', $upload, $file->getClientOriginalName()),
            'filename' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)
        ));
    }

    /**
     * List files in paths
     *
     * @author Vincent Chalamon <vincent@ylly.fr>
     *
     * @param string $paths List of paths
     *
     * @return JsonResponse
     */
    public function listFilesAction($paths)
    {
        $files  = array();
        $paths  = explode('/', $paths);
        $webDir = rtrim($this->container->getParameter('kernel.web_dir'), '/');
        foreach ($paths as $path) {
            if (!substr($path, 0, 1) != '/') {
                $path = sprintf('/%s', $path);
            }
            if (realpath($webDir.$path)) {
                $finder = Finder::create()->files()->name('/\.(?:gif|png|jpg|jpeg)$/i');
                foreach ($finder->in(realpath($webDir.$path)) as $img) {
                    /** @var SplFileInfo $img */
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
