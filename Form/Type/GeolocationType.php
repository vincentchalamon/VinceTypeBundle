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
 * Form type geolocation
 *
 * @author Vincent Chalamon <vincentchalamon@gmail.com>
 */
class GeolocationType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['class'] = $options['class'];
        $view->vars['icon']  = $options['icon'];
        $view->vars['zoom']  = $options['zoom'];
        $view->vars['lat']   = $options['lat'];
        $view->vars['lng']   = $options['lng'];
        $view->vars['infoContent']   = $options['infoContent'];
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        // Default location: Paris
        $resolver->setDefaults(array(
                'icon' => null,
                'lat'  => 48.8534100,
                'lng'  => 2.3488000,
                'zoom' => 15,
                'infoContent' => '<h4 class="geolocation-info-name">###name###</h4>'
                    .'<p class="geolocation-info-address">###address###,<br />###zipcode### ###city###</p>'
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'entity_id';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'geolocation';
    }
}
