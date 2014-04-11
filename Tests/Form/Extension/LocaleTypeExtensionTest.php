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
 * Test LocaleTypeExtension
 *
 * @author Vincent Chalamon <vincentchalamon@gmail.com>
 */
class LocaleTypeExtensionTest extends TypeTestCase
{

    public function testInjectOption()
    {
        $form = $this->factory->create('text');
        $form->submit('Hello World!');
        $this->assertTrue($form->isSynchronized());
        $this->assertEquals('Hello World!', $form->getData());
        $this->assertTrue(in_array('locale', $form->createView()->vars));
        // todo-vince Try to inject locale
        //$this->assertNotNull($form->createView()->vars['locale']);
    }
}