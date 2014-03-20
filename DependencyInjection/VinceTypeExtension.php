<?php

/*
 * This file is part of the VinceType bundle.
 *
 * (c) Vincent Chalamon <vincentchalamon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Vince\Bundle\TypeBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class VinceTypeExtension extends Extension implements PrependExtensionInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $this->processConfiguration($configuration, $configs);

        $container->setParameter('twig.form.resources', array_merge(
                $container->getParameter('twig.form.resources'),
                array('VinceTypeBundle:Form:form_div_layout.html.twig')
            )
        );

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }

    /**
     * {@inheritDoc}
     */
    public function prepend(ContainerBuilder $container)
    {
        $bundles = $container->getParameter('kernel.bundles');

        // Configure Assetic if AsseticBundle is activated
        if (isset($bundles['AsseticBundle']) && $container->hasExtension('assetic')) {
            $container->prependExtensionConfig('assetic', array(
                    'bundles' => array('VinceTypeBundle'),
                    'assets' => array(
                        'vince_type_js' => array(
                            'inputs' => array(
                                'bundles/vincetype/datepicker/bootstrap-datepicker.js',
                                'bundles/vincetype/redactor/redactor.js',
                                'bundles/vincetype/masked/jquery.maskedinput.min.js',
                                'bundles/vincetype/token/jquery.tokeninput.js',
                                'bundles/vincetype/list/listInput.js'
                            ),
                            'filters' => $container->hasParameter('assetic.filter.yui_js.jar') ? array('?yui_js') : array(),
                            'output' => 'js/vince_type.js'
                        ),
                        'vince_type_css' => array(
                            'inputs' => array(
                                'bundles/vincetype/datepicker/bootstrap.datepicker.min.css',
                                'bundles/vincetype/datepicker/datepicker.css',
                                'bundles/vincetype/redactor/redactor.css',
                                'bundles/vincetype/token/token-input.css',
                                'bundles/vincetype/token/token-input-facebook.css',
                                'bundles/vincetype/list/listInput.css'
                            ),
                            'filters' => array_merge(array('cssrewrite'), $container->hasParameter('assetic.filter.yui_css.jar') ? array('?yui_css') : array()),
                            'output' => 'css/vince_type.css'
                        )
                    )
                )
            );
        }
    }
}
