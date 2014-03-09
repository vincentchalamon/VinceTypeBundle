<?php

/*
 * This file is part of the VinceType bundle.
 *
 * (c) Vincent Chalamon <vincentchalamon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Vince\Bundle\TypeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Vince\Bundle\TypeBundle\Form\Transformer\TokenTransformer;

/**
 * Form type token
 *
 * @author Vincent Chalamon <vincentchalamon@gmail.com>
 */
class TokenType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer(new TokenTransformer($options['em'], $options['entity'], $options['tokenDelimiter'], $options['identifier'], $options['identifierMethod'], $options['renderMethod']));
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['entity']       = $options['entity'];
        $view->vars['searchMethod'] = $options['searchMethod'];
        unset($options['entity'], $options['searchMethod'], $options['renderMethod'], $options['identifier'], $options['identifierMethod']);
        $view->vars['options'] = json_encode(array_intersect_key($options, $this->getConfiguration()));
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setRequired(array('entity', 'em'))
            ->setAllowedTypes(array('em' => 'Doctrine\Common\Persistence\ObjectManager'))
            ->setDefaults(array_merge(array(
                        'renderMethod'     => '__toString',
                        'identifierMethod' => 'getId',
                        'identifier'       => 'id'
                    ), $this->getConfiguration()));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'token';
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'text';
    }

    /**
     * Get configuration
     *
     * @author Vincent Chalamon <vincentchalamon@gmail.com>
     *
     * @return array
     */
    protected function getConfiguration()
    {
        return array(
            'searchMethod' => 'search',
            'searchDelay' => 300,
            'minChars' => 1,
            'animateDropdown' => true,
            'resultsLimit' => null,
            'tokenLimit' => null,
            'tokenDelimiter' => ',',
            'preventDuplicates' => true
        );
    }
}