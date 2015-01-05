<?php

/*
 * This file is part of the VinceType bundle.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Vince\Bundle\TypeBundle\Tests\Form\Type;

use Symfony\Component\Routing\Router;
use Vince\Bundle\TypeBundle\Component\Form\Test\TypeTestCase;
use Vince\Bundle\TypeBundle\Form\Type\RedactorType;

/**
 * Test RedactorType
 *
 * @author Vincent Chalamon <vincentchalamon@gmail.com>
 */
class RedactorTypeTest extends TypeTestCase
{
    /**
     * Test submit valid data
     *
     * @author Vincent Chalamon <vincentchalamon@gmail.com>
     */
    public function testSubmitValidData()
    {
        $form    = $this->factory->create($this->getType(), '<p>Hello World!</p>');
        $this->assertEquals('<p>Hello World!</p>', $form->createView()->vars['value']);
        $form->submit('<p>Lorem ipsum dolor sit amet</p>');
        $this->assertTrue($form->isSynchronized());
        $this->assertEquals('<p>Lorem ipsum dolor sit amet</p>', $form->getData());
    }

    /**
     * Test options
     *
     * @author Vincent Chalamon <vincentchalamon@gmail.com>
     */
    public function testOptions()
    {
        $form    = $this->factory->create($this->getType(), null, array('autoresize' => false, 'path' => '/test'));
        $options = json_decode($form->createView()->vars['options'], true);
        $this->assertEquals('/test', $options['path']);
        $this->assertEquals('/redactor/list-files/test', $options['imageGetJson']);
        $this->assertEquals(false, $options['autoresize']);
    }

    /**
     * Generate router from mock
     *
     * @author Vincent Chalamon <vincentchalamon@gmail.com>
     * @return RedactorType
     */
    protected function getType()
    {
        $router = $this->getMockBuilder('\Symfony\Component\Routing\Router')
                       ->disableOriginalConstructor()->getMock();
        $router->expects($this->any())
               ->method('generate')
               ->will($this->returnCallback(function () {
                    $args = func_get_arg(1);

                    return '/redactor/list-files'.$args['path'];
                }));
        $type = new RedactorType();
        $type->setUploadDirName('/path/to/web', '/path/to/web/uploads');
        $type->setRouter($router);

        return $type;
    }
}
