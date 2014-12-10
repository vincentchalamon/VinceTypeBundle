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
    public function transform($value)
    {
        // Fix for Symfony 2.4
        if (null === $value) {
            return null;
        }

        /** @var array $values */
        if (!is_array($value)) {
            throw new \InvalidArgumentException(sprintf('List form type only accept array, %s sent.', is_object($value) ? 'instance of '.get_class($value) : gettype($value)));
        }

        return implode($this->separator, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform($value)
    {
        $value = explode($this->separator, trim($value));
        foreach ($value as $key => $val) {
            if (!trim($val)) {
                unset($value[$key]);
            }
        }

        return $value;
    }
}
