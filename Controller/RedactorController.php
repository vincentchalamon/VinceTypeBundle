<?php

/*
 * This file is part of the VinceType bundle.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Vince\Bundle\TypeBundle\Controller;

use Sonata\CoreBundle\Exception\InvalidParameterException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
     * @return JsonResponse|Response
     */
    public function uploadAction(Request $request)
    {
        if (!$request->files->has('file')) {
            return new JsonResponse(array(
                    'error' => $this->get('translator')->trans('redactor.messages.fileUploadError', array(), 'Vince'),
                )
            );
        }
        $file   = $request->files->get('file');
        $upload = rtrim($this->container->getParameter('kernel.upload_dir'), '/');
        if (!is_dir($upload)) {
            mkdir($upload, 0777, true);
        }
        $file->move(realpath($upload), $file->getClientOriginalName());

        return new Response(json_encode(array(
                'filelink' => sprintf('/%s/%s', pathinfo($upload, PATHINFO_BASENAME), $file->getClientOriginalName()),
                'filename' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME), JSON_UNESCAPED_SLASHES, )), 200, array(
                'Content-Type' => 'application/json',
            )
        );
    }

    /**
     * List files in path
     *
     * @author Vincent Chalamon <vincentchalamon@gmail.com>
     *
     * @param Request $request
     *
     * @return Response
     * @throws NotFoundHttpException
     */
    public function listFilesAction(Request $request)
    {
        if (!$request->get('paths')) {
            throw $this->createNotFoundException();
        }
        $files  = array();
        $webDir = rtrim(realpath($this->container->getParameter('kernel.web_dir')), '/');
        foreach ($request->get('paths') as $path) {
            if (substr($path, 0, 1) != '/') {
                $path = sprintf('/%s', $path);
            }
            $realpath = realpath($webDir.$path);
            if ($realpath && strpos($realpath, $webDir) === 0) {
                $finder = Finder::create()->files()->name('/\.(?:gif|png|jpg|jpeg)$/i');
                foreach ($finder->in(realpath($webDir.$path)) as $img) {
                    /** @var SplFileInfo $img */
                    $folder  = str_ireplace($webDir, '', pathinfo($img->__toString(), PATHINFO_DIRNAME));
                    $files[] = array(
                        'thumb'  => $folder.'/'.$img->getFilename(),
                        'image'  => $folder.'/'.$img->getFilename(),
                        'title'  => pathinfo($img->__toString(), PATHINFO_FILENAME),
                        'folder' => str_ireplace('/', ' &gt; ', str_ireplace('\\', '>', trim($folder, '/'))),
                    );
                }
            } else {
                throw new InvalidParameterException('The provided path is either invalid or outside of the public directory. Maybe you forgot to set the "kernel.web_dir" parameter.');
            }
        }

        return new Response(json_encode($files, JSON_UNESCAPED_SLASHES), 200, array(
                'Content-Type' => 'application/json',
            )
        );
    }
}
