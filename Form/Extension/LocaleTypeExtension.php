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
use Vince\Bundle\TypeBundle\Listener\LocaleListener;

/**
 * Form extension to inject `locale` parameter
 *
 * @author Vincent Chalamon <vincentchalamon@gmail.com>
 */
class LocaleTypeExtension extends AbstractTypeExtension
{

    /**
     * Locale
     *
     * @var string
     */
    protected $locale;

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars = array_replace($view->vars, array('locale' => $this->locale));
    }

    /**
     * Set locale
     *
     * @author Vincent Chalamon <vincentchalamon@gmail.com>
     *
     * @param LocaleListener $listener
     */
    public function setLocale(LocaleListener $listener)
    {
        $this->locale = $listener->getLocale();
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return 'form';
    }
}
