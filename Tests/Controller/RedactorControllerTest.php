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
        $client = static::createClient();

        // Method not allowed
        $client->request('GET', '/redactor/upload');
        $this->assertEquals(405, $client->getResponse()->getStatusCode());

        // File required
        $client->request('POST', '/redactor/upload');
        $this->assertTrue($client->getResponse()->isSuccessful());
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
            )));
        $this->assertTrue($client->getResponse()->isSuccessful());
        $filename = $client->getContainer()->getParameter('kernel.web_dir').$client->getContainer()->getParameter('kernel.uploads_path').'/sample.png';
        $this->assertFileExists($filename);
        unlink($filename);
        $this->assertEquals((object)array(
                'filelink' => $client->getContainer()->getParameter('kernel.uploads_path').'/sample.png',
                'filename' => 'sample'
            ), json_decode($client->getResponse()->getContent()));
    }

    /**
     * Test list files
     *
     * @author Vincent Chalamon <vincent@ylly.fr>
     */
    public function testListFiles()
    {
        $client = static::createClient();

        // Method not allowed
        $client->request('POST', '/redactor/list-files/bundles/vincetype');
        $this->assertEquals(405, $client->getResponse()->getStatusCode());

        // Get files in path
        $client->request('GET', '/redactor/list-files/bundles/vincetype');
        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertEquals(array((object)array(
                'thumb'  => '/bundles/vincetype/sample.png',
                'image'  => '/bundles/vincetype/sample.png',
                'title'  => 'sample',
                'folder' => 'vincetype'
            )), json_decode($client->getResponse()->getContent()));
    }

}
