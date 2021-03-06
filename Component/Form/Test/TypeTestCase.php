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
use Vince\Bundle\TypeBundle\Form\Type\DocumentType;
use Vince\Bundle\TypeBundle\Form\Type\GeolocationType;
use Vince\Bundle\TypeBundle\Form\Type\ListType;
use Vince\Bundle\TypeBundle\Form\Type\MaskedType;
use Vince\Bundle\TypeBundle\Form\Type\RedactorType;

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
            'datepicker'    => new DatepickerType(),
            'document'      => new DocumentType(),
            'geolocation'   => new GeolocationType(),
            'list'          => new ListType(),
            'masked'        => new MaskedType(),
            'redactor'      => new RedactorType(),
        );

        return array(new PreloadedExtension($types, array()));
    }
}
