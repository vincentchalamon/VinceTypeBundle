<?php

/*
 * This file is part of the Symfony package.
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
 * Description of RedactorType.php
 *
 * @author Vincent Chalamon <vincentchalamon@gmail.com>
 */
class RedactorType extends AbstractType
{

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars = array_replace($view->vars, array(
            'options' => json_encode($options)
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'lang'              => 'fr',
            'direction'         => 'ltr',
            'toolbarExternal'   => false,
            'buttons'           => array(
                'html', '|', 'formatting', '|', 'bold', 'italic', 'deleted', '|',
                'unorderedlist', 'orderedlist', 'outdent', 'indent', '|',
                'image', 'video', 'file', 'table', 'link', '|',
                'fontcolor', 'backcolor', '|', 'alignment', '|', 'horizontalrule'
            ),
            'buttonsAdd'        => array(),
            'formattingTags'    => array('p', 'blockquote', 'pre', 'h1', 'h2', 'h3', 'h4'),
            'buttonSource'      => true,
            'iframe'            => false,
            'fullpage'          => false,
            'css'               => false,
            'focus'             => false,
            'shortcuts'         => true,
            'autoresize'        => true,
            'cleanup'           => true,
            'toolbarFixed'      => false,
            'toolbarFixedTopOffset' => 0,
            'toolbarFixedBox'   => false,
            'paragraphy'        => true,
            'convertLinks'      => true,
            'convertDivs'       => true,
            'autosave'          => false,
            'autosaveInterval'  => 60,
            'imageGetJson'      => false,
            'imageUpload'       => false,
            'fileUpload'        => false,
            'uploadFields'      => false,
            'modalOverlay'      => true,
            'tabindex'          => false,
            'minHeight'         => false,
            'observeImages'     => true,
            'colors'            => array(
                '#ffffff', '#000000', '#eeece1', '#1f497d', '#4f81bd', '#c0504d', '#9bbb59', '#8064a2', '#4bacc6', '#f79646', '#ffff00',
                '#f2f2f2', '#7f7f7f', '#ddd9c3', '#c6d9f0', '#dbe5f1', '#f2dcdb', '#ebf1dd', '#e5e0ec', '#dbeef3', '#fdeada', '#fff2ca',
                '#d8d8d8', '#595959', '#c4bd97', '#8db3e2', '#b8cce4', '#e5b9b7', '#d7e3bc', '#ccc1d9', '#b7dde8', '#fbd5b5', '#ffe694',
                '#bfbfbf', '#3f3f3f', '#938953', '#548dd4', '#95b3d7', '#d99694', '#c3d69b', '#b2a2c7', '#b7dde8', '#fac08f', '#f2c314',
                '#a5a5a5', '#262626', '#494429', '#17365d', '#366092', '#953734', '#76923c', '#5f497a', '#92cddc', '#e36c09', '#c09100',
                '#7f7f7f', '#0c0c0c', '#1d1b10', '#0f243e', '#244061', '#632423', '#4f6128', '#3f3151', '#31859b', '#974806', '#7f6000'
            ),
            'air'               => false,
            'airButtons'        => array('formatting', '|', 'bold', 'italic', 'deleted', '|', 'unorderedlist', 'orderedlist', 'outdent', 'indent', '|', 'fontcolor', 'backcolor'),
            'wym'               => false,
            'mobile'            => true,
            'linkProtocol'      => 'http://',
            'placeholder'       => false,
            'linebreaks'        => false,
            'allowedTags'       => false,
            'deniedTags'        => array('html', 'head', 'link', 'body', 'meta', 'script', 'style', 'applet'),
            'boldTag'           => 'strong',
            'italicTag'         => 'em',
            'linkEmail'         => false,
            'linkAnchor'        => false,
            'formattingPre'     => false,
            'phpTags'           => false,
            'visual'            => true,
            's3'                => false,
            'activeButtonsAdd'  => false
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
        return 'redactor';
    }

    /**
     * Define parent field type.
     *
     * @author Vincent CHALAMON <vincentchalamon@gmail.com>
     * @return string
     */
    public function getParent()
    {
        return 'textarea';
    }
}