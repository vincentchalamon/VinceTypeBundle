<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Vincent Chalamon <vincentchalamon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Vince\Bundle\TypeBundle\Twig\Extension;

class FormExtension extends \Twig_Extension
{

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            'form_help' => new \Twig_Function_Node('Symfony\Bridge\Twig\Node\SearchAndRenderBlockNode', array('is_safe' => array('html'))),
            'form_javascript' => new \Twig_Function_Node('Symfony\Bridge\Twig\Node\SearchAndRenderBlockNode', array('is_safe' => array('html'))),
            'form_sources' => new \Twig_Function_Node('Symfony\Bridge\Twig\Node\SearchAndRenderBlockNode', array('is_safe' => array('html'))),
            'form_stylesheet' => new \Twig_Function_Node('Symfony\Bridge\Twig\Node\SearchAndRenderBlockNode', array('is_safe' => array('html'))),
            'form_javascripts' => new \Twig_Function_Node('Symfony\Bridge\Twig\Node\RenderBlockNode', array('is_safe' => array('html'))),
            'form_stylesheets' => new \Twig_Function_Node('Symfony\Bridge\Twig\Node\RenderBlockNode', array('is_safe' => array('html')))
        );
    }

    /**
     * Get twig extension name
     *
     * @author Vincent CHALAMON <vincentchalamon@gmail.com>
     * @return string Twig extension name
     */
    public function getName()
    {
        return 'Vince_admin_form';
    }
}