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
     * Upload dir
     *
     * @var string
     */
    protected $uploadDir;

    /**
     * @param string $uploadDir Upload dir
     */
    public function __construct($uploadDir)
    {
        $this->uploadDir = $uploadDir;
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

        return new UploadedFile(sprintf('%s/%s', $this->uploadDir, pathinfo($value, PATHINFO_BASENAME)), pathinfo($value, PATHINFO_BASENAME));
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
        $value->move($this->uploadDir, $value->getClientOriginalName());

        return sprintf('/uploads/%s', $value->getClientOriginalName());
    }
}