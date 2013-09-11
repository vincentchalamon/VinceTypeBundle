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
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Description of DatepickerType.php
 *
 * @author Vincent Chalamon <vincentchalamon@gmail.com>
 */
class DatepickerType extends AbstractType
{

    const DAYS   = 0;
    const MONTHS = 1;
    const YEARS  = 2;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Transformer : \DateTime to string
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['options'] = json_encode(array_intersect_key($options, array(
            'weekStart'   => 0,
            'viewMode'    => self::DAYS,
            'minViewMode' => self::DAYS
        )));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'widget'      => 'single_text',
            'weekStart'   => 0,
            'viewMode'    => self::DAYS,
            'minViewMode' => self::DAYS
        ));
    }

    /**
     * Get current type name.
     *
     * @author Vincent CHALAMON <vincentchalamon@gmail.com>
     * @return string Current type name
     */
    public function getName()
    {
        return 'datepicker';
    }

    /**
     * Define parent field type.
     *
     * @author Vincent CHALAMON <vincentchalamon@gmail.com>
     * @return string
     */
    public function getParent()
    {
        return 'date';
    }
}