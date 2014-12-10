<?php

/*
 * This file is part of the VinceType bundle.
 *
 * (c) Vincent Chalamon <http://www.vincent-chalamon.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Vince\Bundle\TypeBundle\Form\Transformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Document transformer
 *
 * @author Vincent Chalamon <vincentchalamon@gmail.com>
 */
class DocumentTransformer implements DataTransformerInterface
{

    /**
     * Web dir
     *
     * @var string
     */
    protected $webDir;

    /**
     * Destination dirname
     *
     * @var string
     */
    protected $destinationDirname;

    /**
     * Has to return string or UploadedFile
     *
     * @var boolean
     */
    protected $isString = false;

    /**
     * Original filename
     *
     * @var string
     */
    protected $originalFilename;

    /**
     * @param string  $webDir             Web dir
     * @param string  $destinationDirname Destination dir
     * @param boolean $manageString       Manage document as string instead of UploadedFile
     */
    public function __construct($webDir, $destinationDirname, $manageString = false)
    {
        $this->webDir             = $webDir;
        $this->destinationDirname = $destinationDirname;
        $this->isString           = $manageString;
    }

    /**
     * {@inheritdoc}
     */
    public function transform($value)
    {
        // Fix for Symfony 2.4
        if (null === $value) {
            return null;
        }
        $options = array('value' => $value);

        // Convert value to UploadedFile
        if ($this->isString) {
            $value = new UploadedFile(sprintf('%s/%s', $this->webDir, ltrim($value, '/')), pathinfo($value, PATHINFO_BASENAME));
        }
        $this->originalFilename = $this->webDir.$this->destinationDirname.'/'.$value->getClientOriginalName();
        $options['file'] = $value;

        return $options;
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform($value)
    {
        // Fix for Symfony 2.4
        if (null === $value) {
            return null;
        }

        // Delete file
        if ($value['delete'] && $this->originalFilename) {
            if (is_file($this->originalFilename)) {
                unlink($this->originalFilename);
            }

            return null;
        }

        // Upload file
        /** @var UploadedFile $file */
        $file = $value['file'];
        if (is_null($file)) {
            return $value['value'];
        }
        if ($this->isString) {
            if (!is_dir($this->webDir.$this->destinationDirname)) {
                mkdir($this->webDir.$this->destinationDirname, 0777, true);
            }
            $filename = sprintf('%s.%s', md5(rand()), $file->getClientOriginalExtension());
            $file->move($this->webDir.$this->destinationDirname, $filename);

            return sprintf($this->destinationDirname.'/%s', $filename);
        }

        return $file;
    }
}
