<?php

/*
 * This file is part of the VinceType bundle.
 *
 * (c) Vincent Chalamon <http://www.vincent-chalamon.fr>
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
 * Form type datepicker
 *
 * @author Vincent Chalamon <vincentchalamon@gmail.com>
 */
class DatepickerType extends AbstractType
{
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
        $view->vars['options'] = json_encode(array_intersect_key($options, $this->getConfiguration()));
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
                    'format' => $this->format,
                ), $this->getConfiguration()));
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
            'weekStart' => 0,
            'calendarWeeks' => false,
            'daysOfWeekDisabled' => array(),
            'autoclose' => true,
            'startView' => 0,
            'minViewMode' => 0,
            'todayBtn' => false,
            'todayHighlight' => true,
            'clearBtn' => false,
            'keyboardNavigation' => true,
            'forceParse' => true,
            'orientation' => 'auto',
        );
    }
}
