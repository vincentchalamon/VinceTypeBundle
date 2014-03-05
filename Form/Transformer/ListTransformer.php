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

/**
 * List transformer
 *
 * @author Vincent Chalamon <vincentchalamon@gmail.com>
 */
class ListTransformer implements DataTransformerInterface
{

    /**
     * Separator
     *
     * @var string
     */
    protected $separator;

    /**
     * @param string $separator
     */
    public function __construct($separator)
    {
        $this->separator = $separator;
    }

    /**
     * {@inheritdoc}
     */
    public function transform($values)
    {
        /** @var array $values */
        if (!is_array($values)) {
            throw new \InvalidArgumentException(sprintf('Token form type only accept array, %s sent.', is_object($values) ? 'instance of '.get_class($values) : gettype($values)));
        }

        return implode($this->separator, $values);
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform($values)
    {
        $values = explode($this->separator, $values);
        foreach ($values as $key => $value) {
            if (!trim($value)) {
                unset($values[$key]);
            }
        }

        return $values ?: array();
    }
}