<?php

/*
 * This file is part of the VinceType bundle.
 *
 * (c) Vincent Chalamon <vincentchalamon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Vince\Bundle\TypeBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Description of HelpTypeExtension.php
 *
 * @author Vincent Chalamon <vincentchalamon@gmail.com>
 */
class HelpTypeExtension extends AbstractTypeExtension
{

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        if (isset($options['help'])) {
            $view->vars = array_replace($view->vars, array('help' => $options['help']));
        }
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setOptional(array('help'));
    }

    public function getExtendedType()
    {
        return 'form';
    }
}