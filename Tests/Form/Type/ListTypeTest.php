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
 * Test ListType
 *
 * @author Vincent Chalamon <vincentchalamon@gmail.com>
 */
class ListTypeTest extends TypeTestCase
{
    /**
     * Test submit valid data
     *
     * @author Vincent Chalamon <vincentchalamon@gmail.com>
     */
    public function testSubmitValidData()
    {
        $form = $this->factory->create('list', array('test', 'toto', 'tata'));
        $this->assertEquals('test,toto,tata', $form->createView()->vars['value']);
        $form->submit('titi,tutu');
        $this->assertTrue($form->isSynchronized());
        $this->assertEquals(array('titi', 'tutu'), $form->getData());
    }

    /**
     * Test options
     *
     * @author Vincent Chalamon <vincentchalamon@gmail.com>
     */
    public function testOptions()
    {
        $form    = $this->factory->create('list', null, array('separator' => ';'));
        $options = json_decode($form->createView()->vars['options'], true);
        $this->assertEquals(';', $options['separator']);
    }
}
