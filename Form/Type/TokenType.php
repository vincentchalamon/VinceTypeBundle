<?php

/*
 * This file is part of the VinceType bundle.
 *
 * (c) Vincent Chalamon <http://www.vincent-chalamon.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Vince\Bundle\TypeBundle\Form\Type;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Vince\Bundle\TypeBundle\Form\Transformer\TokenTransformer;

/**
 * Form type token
 *
 * @author Vincent Chalamon <vincentchalamon@gmail.com>
 */
class TokenType extends AbstractType
{

    /**
     * Entity manager
     *
     * @var ObjectManager
     */
    protected $em;

    /**
     * Set object manager
     *
     * @author Vincent Chalamon <vincentchalamon@gmail.com>
     *
     * @param ObjectManager $em
     */
    public function setObjectManager(ObjectManager $em)
    {
        $this->em = $em;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        throw new \Exception('This type is not implemented yet !');
        $builder->addModelTransformer(new TokenTransformer($this->em, $options['class'], $options['tokenDelimiter'], $options['identifier'], $options['identifierMethod'], $options['renderMethod']));
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['queryParams'] = json_encode(array(
                'class' => $options['class'],
                'renderMethod' => $options['renderMethod'],
                'identifierMethod' => $options['identifierMethod'],
                'searchMethod' => $options['searchMethod']
            )
        );
        unset($options['class'], $options['renderMethod'], $options['identifierMethod'], $options['searchMethod']);
        $view->vars['options'] = json_encode(array_intersect_key($options, $this->getConfiguration()));
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setRequired(array('class'))
            ->setDefaults($this->getConfiguration());
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'token';
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'text';
    }

    /**
     * Get configuration
     *
     * @author Vincent Chalamon <vincentchalamon@gmail.com>
     *
     * @return array
     */
    protected function getConfiguration()
    {
        return array(
            'renderMethod' => '__toString',
            'identifierMethod' => 'getId',
            'searchMethod' => 'search',
            'searchDelay' => 300,
            'minChars' => 1,
            'animateDropdown' => true,
            'resultsLimit' => null,
            'tokenLimit' => null,
            'tokenDelimiter' => ',',
            'preventDuplicates' => true
        );
    }
}
