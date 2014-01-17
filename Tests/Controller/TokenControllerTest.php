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
 * Test TokenController
 *
 * @author Vincent Chalamon <vincent@ylly.fr>
 */
class TokenControllerTest extends WebTestCase
{

    /**
     * Test search
     *
     * @author Vincent Chalamon <vincent@ylly.fr>
     */
    public function testSearch()
    {
        $this->markTestIncomplete();
        $client = static::createClient();

        $crawler = $client->request('GET', '/search');
    }

}
