<?php

/*
 * This file is part of the VinceType bundle.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Vince\Bundle\TypeBundle\Manager;
use Symfony\Component\Finder\Finder;
use Sonata\CoreBundle\Exception\InvalidParameterException;
use Symfony\Component\HttpFoundation\Request;

/**
 * Manager for RedactorController
 * Manage files (upload & list)
 *
 * @author Vincent Chalamon <vincentchalamon@gmail.com>
 */
class RedactorManager
{

    /**
     * Web dir
     *
     * @var string
     */
    protected $webDir;

    /**
     * Upload dir
     *
     * @var string
     */
    protected $uploadDir;

    /**
     * Request
     *
     * @var Request
     */
    protected $request;

    /**
     * Set webDir
     *
     * @author Vincent Chalamon <vincentchalamon@gmail.com>
     *
     * @param string $webDir
     *
     * @return RedactorManager
     */
    public function setWebDir($webDir)
    {
        $this->webDir = $webDir;

        return $this;
    }

    /**
     * Set uploadDir
     *
     * @author Vincent Chalamon <vincentchalamon@gmail.com>
     *
     * @param string $uploadDir
     *
     * @return RedactorManager
     */
    public function setUploadDir($uploadDir)
    {
        $this->uploadDir = $uploadDir;

        return $this;
    }

    /**
     * Set request
     *
     * @author Vincent Chalamon <vincentchalamon@gmail.com>
     *
     * @param Request $request
     *
     * @return RedactorManager
     */
    public function setRequest($request)
    {
        $this->request = $request;

        return $this;
    }

    public function uploadFile()
    {
        if (!$this->request->files->has('file')) {
            return false;
        }
        $file   = $this->request->files->get('file');
        $upload = rtrim($this->uploadDir, '/');
        if (!is_dir($upload)) {
            mkdir($upload, 0777, true);
        }
        $file->move(realpath($upload), $file->getClientOriginalName());

        return sprintf('/%s/%s', pathinfo($upload, PATHINFO_BASENAME),
            pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
    }

    /**
     * List files in a list of paths
     *
     * @author Vincent Chalamon <vincentchalamon@gmail.com>
     * @param array $paths List of paths to explore
     * @return array
     */
    public function listFiles(array $paths)
    {
        $files  = array();
        $webDir = rtrim(realpath($this->webDir), '/');
        foreach ($paths as $path) {
            if (substr($path, 0, 1) != '/') {
                $path = sprintf('/%s', $path);
            }
            $realpath = realpath($webDir.$path);
            if ($realpath && strpos($realpath, $webDir) === 0) {
                $finder = Finder::create()->files()->name('/\.(?:gif|png|jpg|jpeg)$/i');
                foreach ($finder->in(realpath($webDir.$path)) as $img) {
                    /** @var \SplFileInfo $img */
                    $folder  = str_ireplace($webDir, '', pathinfo($img->__toString(), PATHINFO_DIRNAME));
                    $files[] = array(
                        'thumb'  => $folder.'/'.$img->getFilename(),
                        'image'  => $folder.'/'.$img->getFilename(),
                        'title'  => pathinfo($img->__toString(), PATHINFO_FILENAME),
                        'folder' => str_ireplace('/', ' &gt; ', str_ireplace('\\', '>', trim($folder, '/'))),
                    );
                }
            } else {
                throw new InvalidParameterException(
                    'The provided path is either invalid or outside of the public directory. '.
                    'Maybe you forgot to set the "kernel.web_dir" parameter.'
                );
            }
        }

        return $files;
    }
}
