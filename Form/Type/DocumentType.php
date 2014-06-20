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
     * Upload dir
     *
     * @var string
     */
    protected $uploadDir;

    /**
     * Set upload dir
     *
     * @author Vincent Chalamon <vincentchalamon@gmail.com>
     *
     * @param string $uploadDir
     */
    public function setUploadDir($uploadDir)
    {
        $this->uploadDir = $uploadDir;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer(new DocumentTransformer($this->uploadDir));
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['filename'] = $form->getData();
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $view->vars['is_image'] = in_array(strtolower(finfo_file($finfo, sprintf('%s/%s', $this->uploadDir, pathinfo($form->getData(), PATHINFO_BASENAME)))), array(
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