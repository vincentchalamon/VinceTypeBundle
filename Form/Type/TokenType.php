<?php

/*
 * This file is part of the VinceTypeBundle.
 *
 * (c) Vincent Chalamon <vincentchalamon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Vince\Bundle\TypeBundle\Form\Type;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Vince\Bundle\TypeBundle\Form\Transformer\TokenTransformer;

/**
 * Description of TokenType.php
 *
 * @author Vincent Chalamon <vincentchalamon@gmail.com>
 */
class TokenType extends AbstractType
{

    /** @var $em EntityManager */
    protected $em;

    protected $config = array();

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addViewTransformer(new TokenTransformer($this->em, $options['entity'], $options['tokenDelimiter'], $options['identifier'], $options['identifierMethod'], $options['renderMethod']));
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['entity']       = $options['entity'];
        $view->vars['searchMethod'] = $options['searchMethod'];
        unset($options['entity'], $options['searchMethod'], $options['renderMethod'], $options['identifier'], $options['identifierMethod']);
        $view->vars['options'] = json_encode(array_intersect_key($options, $this->config));
    }

    public function setConfiguration(array $config)
    {
        $this->config = $config;
    }

    public function setEntityManager(EntityManager $em)
    {
        $this->em = $em;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired(array('entity'))
                 ->setDefaults(array_merge(array(
                        'renderMethod'     => '__toString',
                        'identifierMethod' => 'getId',
                        'identifier'       => 'id'
                    ), $this->config));
    }

    /**
     * Get current type name.
     *
     * @author Vincent CHALAMON <vincentchalamon@gmail.com>
     * @return string Current type name
     */
    public function getName()
    {
        return 'token';
    }

    /**
     * Define parent field type.
     *
     * @author Vincent CHALAMON <vincentchalamon@gmail.com>
     * @return string
     */
    public function getParent()
    {
        return 'text';
    }
}