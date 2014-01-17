<?php

/*
 * This file is part of the VinceType bundle.
 *
 * (c) Vincent Chalamon <vincentchalamon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Vince\Bundle\TypeBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Test RedactorController
 *
 * @author Vincent Chalamon <vincent@ylly.fr>
 */
class RedactorControllerTest extends WebTestCase
{

    /**
     * Test upload
     *
     * @author Vincent Chalamon <vincent@ylly.fr>
     */
    public function testUpload()
    {
        $this->markTestIncomplete();
        $client = static::createClient();

        $crawler = $client->request('GET', '/upload');
    }

}
