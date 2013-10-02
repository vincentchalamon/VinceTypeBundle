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

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Description of RedactorType.php
 *
 * @author Vincent Chalamon <vincentchalamon@gmail.com>
 */
class RedactorType extends AbstractType
{

    protected $config = array();

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['options'] = json_encode(array_intersect_key(array_merge($options, array('imageGetJson' => '/app_dev.php/redactor/list-files/uploads')), array_merge($this->config, array('imageGetJson' => null))));
    }

    public function setConfiguration(array $config)
    {
        $this->config = $config;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array_merge($this->config, array('paths' => array('/uploads'))));
    }

    /**
     * Get current type name.
     *
     * @author Vincent CHALAMON <vincentchalamon@gmail.com>
     * @return string Current type name
     */
    public function getName()
    {
        return 'redactor';
    }

    /**
     * Define parent field type.
     *
     * @author Vincent CHALAMON <vincentchalamon@gmail.com>
     * @return string
     */
    public function getParent()
    {
        return 'textarea';
    }
}