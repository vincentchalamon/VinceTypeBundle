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
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Form type masked
 *
 * @author Vincent Chalamon <vincentchalamon@gmail.com>
 */
class MaskedType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['mask'] = $options['mask'];
        unset($options['mask']);
        $view->vars['options'] = json_encode($options);
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired(array('mask'))
                 ->setDefaults(array('placeholder' => '_'));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'masked';
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'text';
    }
}