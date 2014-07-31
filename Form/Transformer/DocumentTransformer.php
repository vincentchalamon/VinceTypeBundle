<?php

/*
 * This file is part of the VinceType bundle.
 *
 * (c) Vincent Chalamon <vincentchalamon@gmail.com>
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
     * @param string $webDir Web dir
     */
    public function __construct($webDir)
    {
        $this->webDir = $webDir;
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

        return new UploadedFile(sprintf('%s/%s', $this->webDir, $value), pathinfo($value, PATHINFO_BASENAME));
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform($value)
    {
        /** @var UploadedFile $value */
        // Fix for Symfony 2.4
        if (null === $value) {
            return null;
        }

        // Upload file
        // @todo-vince Puts 'uploads' as dynamic parameter
        $value->move($this->webDir.'/uploads', $value->getClientOriginalName());

        return sprintf('/uploads/%s', $value->getClientOriginalName());
    }
}