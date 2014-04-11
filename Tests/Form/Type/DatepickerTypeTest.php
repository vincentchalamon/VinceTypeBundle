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
 * Test DatepickerType
 *
 * @author Vincent Chalamon <vincentchalamon@gmail.com>
 */
class DatepickerTypeTest extends TypeTestCase
{

    /**
     * Test submit valid data
     *
     * @author Vincent Chalamon <vincentchalamon@gmail.com>
     */
    public function testSubmitValidData()
    {
        $form = $this->factory->create('datepicker', new \DateTime());
        $this->assertEquals(date('m/d/Y'), $form->createView()->vars['value']);
        $form->submit(date('m/d/Y', strtotime('yesterday')));
        $this->assertTrue($form->isSynchronized());
        $this->assertEquals(new \DateTime('yesterday'), $form->getData());
    }

    /**
     * Test options
     *
     * @author Vincent Chalamon <vincentchalamon@gmail.com>
     */
    public function testOptions()
    {
        $form    = $this->factory->create('datepicker', null, array('autoclose' => false, 'weekStart' => 1));
        $options = json_decode($form->createView()->vars['options'], true);
        $this->assertEquals(false, $options['autoclose']);
        $this->assertEquals(1, $options['weekStart']);
    }
}