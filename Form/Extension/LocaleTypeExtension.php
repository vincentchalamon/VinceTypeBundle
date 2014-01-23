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

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

/**
 * Description of LocaleTypeExtension.php
 *
 * @author Vincent Chalamon <vincentchalamon@gmail.com>
 */
class LocaleTypeExtension extends AbstractTypeExtension
{

    protected $locale;

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars = array_replace($view->vars, array('locale' => $this->locale));
    }

    public function setContainer(ContainerInterface $container)
    {
        $this->locale = $container->get('request')->getLocale();
    }

    public function getExtendedType()
    {
        return 'form';
    }
}