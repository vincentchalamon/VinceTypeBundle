<?php

/*
 * This file is part of the VinceType bundle.
 *
 * (c) Vincent Chalamon <http://www.vincent-chalamon.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Vince\Bundle\TypeBundle\Twig\Extension;

/**
 * Twig form extension
 *
 * @author Vincent Chalamon <vincentchalamon@gmail.com>
 */
class FormExtension extends \Twig_Extension
{
    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            'form_javascript'  => new \Twig_Function_Node('Symfony\Bridge\Twig\Node\SearchAndRenderBlockNode', array('is_safe' => array('html'))),
            'form_stylesheet'  => new \Twig_Function_Node('Symfony\Bridge\Twig\Node\SearchAndRenderBlockNode', array('is_safe' => array('html'))),
            'form_javascripts' => new \Twig_Function_Node('Symfony\Bridge\Twig\Node\RenderBlockNode', array('is_safe' => array('html'))),
            'form_stylesheets' => new \Twig_Function_Node('Symfony\Bridge\Twig\Node\RenderBlockNode', array('is_safe' => array('html'))),
            'form_help'        => new \Twig_Function_Node('Symfony\Bridge\Twig\Node\SearchAndRenderBlockNode', array('is_safe' => array('html'))),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Vince_type_form';
    }
}
