<?php

/**
 * This file is applied CC0 <http://creativecommons.org/publicdomain/zero/1.0/>
 */

namespace Societo\GroupBundle\Tests\Controller;

use Societo\BaseBundle\Test\WebTestCase;

class AssociationalGroupController extends WebTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->loadFixtures(array(
            'Societo\GroupBundle\Tests\Fixtures\LoadAccountData',
            'Societo\GroupBundle\Tests\Fixtures\LoadGroupData',
        ));
    }

    public function getCsrfToken($client)
    {
        $client->request('GET', '/test/csrf');
        return $client->getResponse()->getContent();
    }

    public function getPostParameters($client)
    {
        return array('form' => array(
            '_token' => $this->getCsrfToken($client),
        ));
    }

    public function testJoin()
    {
        $client = static::createClient(array('root_config' => __DIR__.'/../config/config.php'));
        $em = $client->getContainer()->get('doctrine.orm.entity_manager');
        $account = $em->find('SocietoAuthenticationBundle:Account', 2);
        $this->login($client, $account);

        $client->request('POST', '/group/1/join', $this->getPostParameters($client));
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

    public function testDuplicateJoin()
    {
        $client = static::createClient(array('root_config' => __DIR__.'/../config/config.php'));
        $em = $client->getContainer()->get('doctrine.orm.entity_manager');
        $account = $em->find('SocietoAuthenticationBundle:Account', 1);
        $this->login($client, $account);

        $client->request('POST', '/group/1/join', $this->getPostParameters($client));
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }
}
