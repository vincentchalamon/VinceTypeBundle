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
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Form type document
 *
 * @author Vincent Chalamon <vincentchalamon@gmail.com>
 */
class DocumentType extends AbstractType
{

    /**
     * Web dir
     *
     * @var string
     */
    protected $webDir;

    /**
     * Set web dir
     *
     * @author Vincent Chalamon <vincentchalamon@gmail.com>
     *
     * @param string $webDir
     */
    public function setWebDir($webDir)
    {
        $this->webDir = $webDir;
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['filename'] = !$form->getData() ? null : pathinfo($form->getData(), PATHINFO_BASENAME);
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $view->vars['is_image'] = !$form->getData() ? false : in_array(strtolower(finfo_file($finfo, sprintf('%s/%s', $this->webDir, $form->getData()))), array(
                'image/gif',
                'image/jpeg',
                'image/pjpeg', // Special for IE
                'image/png',
                'image/x-png' // Special for IE
            )
        );
        finfo_close($finfo);
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setOptional(array('filename'));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'document';
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'file';
    }
}