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
     * @return JsonResponse|Response
     */
    public function uploadAction()
    {
        if (!$filename = $this->get('vince_type.manager.redactor')->uploadFile()) {
            return new JsonResponse(array(
                    'error' => $this->get('translator')->trans('redactor.messages.fileUploadError', array(), 'Vince'),
                )
            );
        }

        return new Response(json_encode(array(
            'filelink' => $filename,
            'filename' => pathinfo($filename, PATHINFO_FILENAME),
            ), JSON_UNESCAPED_SLASHES), 200, array(
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
        $files = $this->get('vince_type.manager.redactor')->listFiles($request->get('paths'));

        return new Response(json_encode($files, JSON_UNESCAPED_SLASHES), 200, array(
                'Content-Type' => 'application/json',
            )
        );
    }
}
