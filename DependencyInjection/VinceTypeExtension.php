<?php

/*
 * This file is part of the VinceType bundle.
 *
 * (c) Vincent Chalamon <http://www.vincent-chalamon.fr>
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
        $config = $this->processConfiguration($configuration, $configs);

        if ($config['autoload']) {
            $container->setParameter('twig.form.resources', array_merge(
                    $container->getParameter('twig.form.resources'),
                    array('VinceTypeBundle:Form:form_div_layout.html.twig')
                )
            );
        }
        $container->setParameter('kernel.web_dir', $container->getParameter('kernel.root_dir').'/../web');
        $container->setParameter('kernel.upload_dir', $container->getParameter('kernel.web_dir').'/uploads');

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
                                'bundles/vincetype/autosize/jquery.autosize.min.js',
                                'bundles/vincetype/datepicker/bootstrap-datepicker.js',
                                'bundles/vincetype/datepicker/langs/*',
                                'bundles/vincetype/geolocation/jquery.geocomplete.min.js',
                                'bundles/vincetype/geolocation/markerclusterer.min.js',
                                'bundles/vincetype/list/listInput.js',
                                'bundles/vincetype/masked/jquery.maskedinput.min.js',
                                'bundles/vincetype/redactor/redactor.js',
                                'bundles/vincetype/redactor/plugins/*/*.js',
                                'bundles/vincetype/redactor/langs/*',
                            ),
                            'output' => 'js/vince_type.min.js',
                        ),
                        'vince_type_css' => array(
                            'inputs' => array(
                                'bundles/vincetype/datepicker/bootstrap.datepicker.min.css',
                                'bundles/vincetype/datepicker/datepicker.css',
                                'bundles/vincetype/document/document.css',
                                'bundles/vincetype/geolocation/geolocation.css',
                                'bundles/vincetype/list/listInput.css',
                                'bundles/vincetype/redactor/redactor.css',
                                'bundles/vincetype/redactor/plugins/*/*.css',
                            ),
                            'output' => 'css/vince_type.min.css',
                            'filters' => array('cssrewrite'),
                        ),
                    ),
                )
            );
        }

        // Configure FOSJsRouting if FOSJsRoutingBundle is activated
        if (isset($bundles['FOSJsRoutingBundle']) && $container->hasExtension('fos_js_routing')) {
            $container->prependExtensionConfig('fos_js_routing', array(
                    'routes_to_expose' => array('redactor-upload'),
                )
            );
        }
    }
}
