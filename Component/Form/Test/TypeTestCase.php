<?php

/*
 * This file is part of the VinceType bundle.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Vince\Bundle\TypeBundle\Component\Form\Test;

use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Test\TypeTestCase as BaseTypeTestCase;
use Symfony\Component\Form\PreloadedExtension;
use Vince\Bundle\TypeBundle\Form\Extension\HelpTypeExtension;
use Vince\Bundle\TypeBundle\Form\Extension\LocaleTypeExtension;
use Vince\Bundle\TypeBundle\Form\Type\DatepickerType;
use Vince\Bundle\TypeBundle\Form\Type\MaskedType;
use Vince\Bundle\TypeBundle\Form\Type\RedactorType;
use Vince\Bundle\TypeBundle\Form\Type\TokenType;
use Symfony\Component\Yaml\Yaml;

/**
 * Add features to form tests
 *
 * @author Vincent Chalamon <vincentchalamon@gmail.com>
 */
abstract class TypeTestCase extends BaseTypeTestCase
{

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->factory = Forms::createFormFactoryBuilder()
            ->addExtensions($this->getExtensions())
            ->addTypeExtensions(array(new HelpTypeExtension(), new LocaleTypeExtension()))
            ->getFormFactory();
    }

    /**
     * {@inheritdoc}
     */
    protected function getExtensions()
    {
        $types = array(
            'datepicker' => new DatepickerType(),
            'masked'     => new MaskedType(),
            'redactor'   => new RedactorType(),
            'token'      => new TokenType()
        );
        foreach ($types as $name => $type) {
            if (is_callable(array($type, 'setConfiguration'))) {
                call_user_func(array($types[$name], 'setConfiguration'), $this->getConfiguration($name));
            }
        }

        return array(new PreloadedExtension($types, array()));
    }

    /**
     * Get configuration
     *
     * @author Vincent Chalamon <vincentchalamon@gmail.com>
     *
     * @param string $name Configuration name
     *
     * @return array
     */
    protected function getConfiguration($name)
    {
        $configuration = Yaml::parse(rtrim(__DIR__, '/').'/../../../Resources/config/services.yml');

        return $configuration['parameters'][sprintf('vince.type.%s', $name)];
    }
}