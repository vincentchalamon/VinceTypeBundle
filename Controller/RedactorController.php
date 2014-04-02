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
use Symfony\Component\HttpFoundation\Request;

/**
 * Files features for redactor
 *
 * @author Vincent Chalamon <vincentchalamon@gmail.com>
 */
class RedactorController extends Controller
{

    /**
     * Upload file to user public directory
     *
     * @author Vincent Chalamon <vincentchalamon@gmail.com>
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function uploadAction(Request $request)
    {
        if (!$request->files->has('file')) {
            return new JsonResponse(array(
                    'error' => $this->get('translator')->trans('redactor.messages.fileUploadError', array(), 'Vince')
                )
            );
        }
        $file   = $request->files->get('file');
        $upload = rtrim($this->container->getParameter('kernel.upload_dir'), '/');
        if (!is_dir($upload)) {
            mkdir($upload, 0777, true);
        }
        $file->move(realpath($upload), $file->getClientOriginalName());

        return new JsonResponse(array(
                'filelink' => sprintf('/%s/%s', pathinfo($upload, PATHINFO_BASENAME), $file->getClientOriginalName()),
                'filename' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)
            )
        );
    }

    /**
     * List files in path
     *
     * @author Vincent Chalamon <vincentchalamon@gmail.com>
     *
     * @param string $path Path
     *
     * @return JsonResponse
     */
    public function listFilesAction($path)
    {
        $files     = array();
        $uploadDir = rtrim($this->container->getParameter('kernel.upload_dir'), '/');
        if (!substr($path, 0, 1) != '/') {
            $path = sprintf('/%s', $path);
        }
        if (realpath($uploadDir.$path)) {
            $finder = Finder::create()->files()->name('/\.(?:gif|png|jpg|jpeg)$/i');
            foreach ($finder->in(realpath($uploadDir.$path)) as $img) {
                /** @var SplFileInfo $img */
                $files[] = array(
                    'thumb'  => $path.'/'.$img->getFilename(),
                    'image'  => $path.'/'.$img->getFilename(),
                    'title'  => pathinfo($img->getRealPath(), PATHINFO_FILENAME),
                    'folder' => pathinfo($path, PATHINFO_BASENAME)
                );
            }
        }

        return new JsonResponse($files);
    }
}
