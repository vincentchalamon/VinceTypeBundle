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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;

/**
 * Token transformer
 *
 * @author Vincent Chalamon <vincentchalamon@gmail.com>
 */
class TokenTransformer implements DataTransformerInterface
{
    /**
     * ObjectManager
     *
     * @var ObjectManager
     */
    protected $em;

    /**
     * Class
     *
     * @var string
     */
    protected $class;

    /**
     * Delimiter
     *
     * @var string
     */
    protected $delimiter;

    /**
     * Identifier
     *
     * @var string
     */
    protected $identifier;

    /**
     * Identifier method
     *
     * @var string
     */
    protected $identifierMethod;

    /**
     * Render method
     *
     * @var string
     */
    protected $renderMethod;

    /**
     * @param ObjectManager $em
     * @param string        $class
     * @param string        $delimiter
     * @param string        $identifier
     * @param string        $identifierMethod
     * @param string        $renderMethod
     */
    public function __construct(ObjectManager $em, $class, $delimiter = ',', $identifier = 'id', $identifierMethod = 'getId', $renderMethod = '__toString')
    {
        $this->em               = $em;
        $this->class            = $class;
        $this->delimiter        = $delimiter;
        $this->identifier       = $identifier;
        $this->identifierMethod = $identifierMethod;
        $this->renderMethod     = $renderMethod;
    }

    /**
     * {@inheritdoc}
     */
    public function transform($value)
    {
        // Fix for Symfony 2.4
        if (null === $value) {
            return;
        }

        /** @var Collection $value */
        if (!is_object($value) || !$value instanceof Collection) {
            throw new \InvalidArgumentException(sprintf('Token form type only accept Collection object, %s sent.', is_object($value) ? 'instance of '.get_class($value) : gettype($value)));
        }
        $identifierMethod = $this->identifierMethod;
        $renderMethod     = $this->renderMethod;

        return json_encode($value->map(function ($value) use ($identifierMethod, $renderMethod) {
                if (!is_callable(array($value, $identifierMethod))) {
                    throw new \Exception(sprintf('You must implement a %s method on your %s entity.', $identifierMethod, get_class($value)));
                }
                if (!is_callable(array($value, $renderMethod))) {
                    throw new \Exception(sprintf('You must implement a %s method on your %s entity.', $renderMethod, get_class($value)));
                }

                return array('id' => call_user_func(array($value, $identifierMethod)), 'name' => call_user_func(array($value, $renderMethod)));
            })->toArray());
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform($value)
    {
        // Value is empty
        if (!trim($value)) {
            return new ArrayCollection();
        }

        // Retrieve entities from their ids
        $builder = $this->em->getRepository($this->class)->createQueryBuilder('e');
        $builder->where($builder->expr()->in(sprintf('e.%s', $this->identifier), explode($this->delimiter, trim($value))));

        return new ArrayCollection($builder->getQuery()->execute());
    }
}
