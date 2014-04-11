<?php

/*
 * This file is part of the VinceType bundle.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Vince\Bundle\TypeBundle\Tests\Form\Extension;

use Vince\Bundle\TypeBundle\Component\Form\Test\TypeTestCase;

/**
 * Test HelpTypeExtension
 *
 * @author Vincent Chalamon <vincentchalamon@gmail.com>
 */
class HelpTypeExtensionTest extends TypeTestCase
{

    public function testInjectOption()
    {
        $form = $this->factory->create('text', null, array('help' => 'Lorem ipsum'));
        $form->submit('Hello World!');
        $this->assertTrue($form->isSynchronized());
        $this->assertEquals('Hello World!', $form->getData());
        $this->assertTrue(in_array('help', $form->createView()->vars));
        $this->assertEquals('Lorem ipsum', $form->createView()->vars['help']);
    }
}