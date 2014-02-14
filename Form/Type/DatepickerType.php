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
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Description of DatepickerType.php
 *
 * @author Vincent Chalamon <vincentchalamon@gmail.com>
 */
class DatepickerType extends AbstractType
{

    /**
     * Config
     *
     * @var array
     */
    protected $config = array();

    /**
     * Format
     *
     * @var string
     */
    protected $format = 'MM/dd/yyyy';

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['options'] = json_encode(array_intersect_key($options, $this->config));
    }

    /**
     * Set configuration
     *
     * @author Vincent Chalamon <vincentchalamon@gmail.com>
     *
     * @param array $config
     */
    public function setConfiguration(array $config)
    {
        $this->config = $config;
    }

    /**
     * Set translator
     *
     * @author Vincent Chalamon <vincentchalamon@gmail.com>
     *
     * @param TranslatorInterface $translator
     */
    public function setTranslator(TranslatorInterface $translator)
    {
        $this->format = $translator->trans('datepicker.format', array(), 'Vince');
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array_merge(array(
                    'widget' => 'single_text',
                    'format' => $this->format
                ), $this->config));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'datepicker';
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'date';
    }
}