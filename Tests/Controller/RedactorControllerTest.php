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
 * Test Redactor controller
 *
 * @author Vincent Chalamon <vincentchalamon@gmail.com>
 */
class RedactorControllerTest extends WebTestCase
{

    /**
     * Test upload
     *
     * @author Vincent Chalamon <vincentchalamon@gmail.com>
     */
    public function testUpload()
    {
        $client = static::createClient();

        // Method not allowed
        $client->request('GET', '/redactor/upload');
        $this->assertEquals(405, $client->getResponse()->getStatusCode());

        // File required
        $client->request('POST', '/redactor/upload');
        $this->assertTrue($client->getResponse()->isOk());
        $this->assertEquals((object)array('error' => 'Aucun fichier n\'a été envoyé.'), json_decode($client->getResponse()->getContent()));

        // Upload file
        $filename = $client->getContainer()->getParameter('kernel.cache_dir').'/sample.png';
        $contents = file_get_contents(__DIR__.'/../../Resources/public/sample.png');
        file_put_contents($filename, $contents);
        $client->request('POST', '/redactor/upload', array(), array('file' => array(
                    'tmp_name' => $filename,
                    'name' => 'sample.png',
                    'type' => 'image/png',
                    'size' => 123,
                    'error' => UPLOAD_ERR_OK
                )
            )
        );
        $this->assertTrue($client->getResponse()->isOk());
        $filename = $client->getContainer()->getParameter('kernel.upload_dir').'/sample.png';
        $this->assertFileExists($filename);
        unlink($filename);
        $this->assertEquals((object)array(
                'filelink' => '/uploads/sample.png',
                'filename' => 'sample'
            ), json_decode($client->getResponse()->getContent()));
    }

    /**
     * Test list files
     *
     * @author Vincent Chalamon <vincentchalamon@gmail.com>
     */
    public function testListFiles()
    {
        $client = static::createClient();

        // Method not allowed
        $client->request('POST', '/redactor/list-files?paths[]=/uploads');
        $this->assertEquals(405, $client->getResponse()->getStatusCode());

        // Paths required
        $client->request('GET', '/redactor/list-files');
        $this->assertTrue($client->getResponse()->isNotFound());

        // Get files in path
        $path = $client->getContainer()->getParameter('kernel.upload_dir');
        copy(__DIR__.'/../../Resources/public/sample.png', $path.'/sample.png');
        $client->request('GET', '/redactor/list-files?paths[]=/uploads');
        $this->assertTrue($client->getResponse()->isOk());
        $this->assertEquals(array((object)array(
                'thumb'  => '/uploads/sample.png',
                'image'  => '/uploads/sample.png',
                'title'  => 'sample',
                'folder' => 'uploads'
            )), json_decode($client->getResponse()->getContent()));
        unlink($path.'/sample.png');
    }

}
