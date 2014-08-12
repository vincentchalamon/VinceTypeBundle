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
use Vince\Bundle\TypeBundle\Form\Transformer\DocumentTransformer;

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
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer(new DocumentTransformer($this->webDir, $options['destination']));
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['filename'] = null;
        $view->vars['is_image'] = false;
        $filename = sprintf('%s/%s', $this->webDir, $form->getData());
        if (is_file($filename)) {
            $view->vars['filename'] = pathinfo($form->getData(), PATHINFO_BASENAME);
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            if (in_array(strtolower(finfo_file($finfo, $filename)), array(
                    'image/gif',
                    'image/jpeg',
                    'image/pjpeg', // Special for IE
                    'image/png',
                    'image/x-png' // Special for IE
                )
            )
            ) {
                $view->vars['is_image'] = true;
                $view->vars['filename'] = $form->getData();
            }
            finfo_close($finfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setOptional(array('filename'))
                 ->setDefaults(array('destination' => '/uploads'));
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
