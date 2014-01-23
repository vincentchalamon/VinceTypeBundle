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
 * Description of MaskedType.php
 *
 * @author Vincent Chalamon <vincentchalamon@gmail.com>
 */
class MaskedType extends AbstractType
{

    protected $config = array();

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['mask'] = $options['mask'];
        unset($options['mask']);
        $view->vars['options'] = json_encode(array_intersect_key($options, array_merge(array('mask' => null), $this->config)));
    }

    public function setConfiguration(array $config)
    {
        $this->config = $config;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired(array('mask'))->setDefaults($this->config);
    }

    /**
     * Get current type name.
     *
     * @author Vincent CHALAMON <vincentchalamon@gmail.com>
     * @return string Current type name
     */
    public function getName()
    {
        return 'masked';
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