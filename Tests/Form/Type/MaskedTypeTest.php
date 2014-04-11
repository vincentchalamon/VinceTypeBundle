<?php

/*
 * This file is part of the VinceType bundle.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Vince\Bundle\TypeBundle\Tests\Form\Type;

use Vince\Bundle\TypeBundle\Component\Form\Test\TypeTestCase;

/**
 * Test MaskedType
 *
 * @author Vincent Chalamon <vincentchalamon@gmail.com>
 */
class MaskedTypeTest extends TypeTestCase
{

    /**
     * Test exception
     *
     * @expectedException \Symfony\Component\OptionsResolver\Exception\MissingOptionsException
     * @expectedExceptionMessage The required option "mask" is missing.
     *
     * @author Vincent Chalamon <vincentchalamon@gmail.com>
     */
    public function testException()
    {
        $this->factory->create('masked', null);
    }

    /**
     * Test submit valid data
     *
     * @author Vincent Chalamon <vincentchalamon@gmail.com>
     */
    public function testSubmitValidData()
    {
        $form = $this->factory->create('masked', '06 07 08 09 10', array('mask' => '99 99 99 99 99'));
        $this->assertEquals('06 07 08 09 10', $form->createView()->vars['value']);
        $form->submit('07 08 09 10 11');
        $this->assertTrue($form->isSynchronized());
        $this->assertEquals('07 08 09 10 11', $form->getData());
    }

    /**
     * Test options
     *
     * @author Vincent Chalamon <vincentchalamon@gmail.com>
     */
    public function testOptions()
    {
        $form    = $this->factory->create('masked', null, array('mask' => '99 99 99 99 99', 'placeholder' => '-'));
        $options = json_decode($form->createView()->vars['options'], true);
        $this->assertEquals('-', $options['placeholder']);
    }
}