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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\DataTransformerInterface;

/**
 * Description of TokenTransformer
 *
 * @author Vincent Chalamon <vincentchalamon@gmail.com>
 */
class TokenTransformer implements DataTransformerInterface
{

    /**
     * EntityManager
     *
     * @var $em EntityManager
     */
    protected $em;

    protected $class, $delimiter, $identifier, $identifierMethod, $renderMethod;

    public function __construct(EntityManager $em, $class, $delimiter = ',', $identifier = 'id', $identifierMethod = 'getId', $renderMethod = '__toString')
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
     *
     * @author Vincent Chalamon <vincentchalamon@gmail.com>
     *
     * @param Collection $values
     *
     * @return string
     * @throws \InvalidArgumentException
     */
    public function transform($values)
    {
        /** @var Collection $values */
        if (!is_object($values) || !$values instanceof Collection) {
            throw new \InvalidArgumentException(sprintf('Token form type only accept Collection object, %s sent.', is_object($values) ? 'instance of '.get_class($values) : gettype($values)));
        }
        $identifierMethod = $this->identifierMethod;
        $renderMethod     = $this->renderMethod;

        return json_encode($values->map(function ($value) use ($identifierMethod, $renderMethod) {
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
     *
     * @author Vincent Chalamon <vincentchalamon@gmail.com>
     *
     * @param string $values
     *
     * @return ArrayCollection
     */
    public function reverseTransform($values)
    {
        // Values is empty
        if (!trim($values)) {
            return new ArrayCollection();
        }

        // Retrieve entities from their ids
        $builder = $this->em->getRepository($this->class)->createQueryBuilder('e');
        $builder->where($builder->expr()->in(sprintf('e.%s', $this->identifier), explode($this->delimiter, trim($values))));

        return new ArrayCollection($builder->getQuery()->execute());
    }
}