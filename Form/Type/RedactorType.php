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

use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
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

    protected $config = array(), $webDir;

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $paths = $options['paths'];
        unset($options['paths']);
        foreach ($paths as $path) {
            if (!substr($path, 0, 1) != '/') {
                $path = sprintf('/%s', $path);
            }
            if (realpath($this->webDir.$path)) {
                $finder = Finder::create()->files()->name('/\.(?:gif|png|jpg|jpeg)$/i');
                foreach ($finder->in(realpath($this->webDir.$path)) as $img) {
                    /** @var $img SplFileInfo */
                    $paths[] = array(
                        //'thumb'  => substr($img->getRealPath(), strlen(realpath($this->webDir))),
                        'image'  => substr($img->getRealPath(), strlen(realpath($this->webDir))),
                        'title'  => $img->getFilename(),
                        'folder' => $path
                    );
                }
            }
        }
        if (count($paths)) {
            $options['imageGetJson'] = $paths;
        }
        $view->vars['options'] = json_encode(array_intersect_key($options, $this->config));
    }

    public function setConfiguration(array $config)
    {
        $this->config = $config;
    }

    public function setWebDir($webDir)
    {
        $this->webDir = $webDir;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array_merge($this->config, array('paths' => array('/uploads'))));
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