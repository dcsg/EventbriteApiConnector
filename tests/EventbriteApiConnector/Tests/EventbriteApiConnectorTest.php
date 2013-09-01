<?php

namespace EventbriteApiConnector\Tests;

use EventbriteApiConnector\Eventbrite;
use EventbriteApiConnector\HttpAdapter\HttpAdapterInterface;

/**
 * @author Daniel Gomes <me@danielcsgomes.com>
 */
class EventbriteApiConnectorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Eventbrite
     */
    protected $eventbrite;
    protected $appKey;
    protected $userKey;
    protected $eventId;

    protected function setUp()
    {
        if (!isset($_SERVER['APP_KEY'])) {
            $this->markTestSkipped('You need to configure the APP_KEY value in phpunit.xml');
        }

        $this->appKey = $_SERVER['APP_KEY'];

        if (isset($_SERVER['USER_KEY'])) {
            $this->userKey = $_SERVER['USER_KEY'];
        }

        if (isset($_SERVER['EVENT_ID'])) {
            $this->eventId = $_SERVER['EVENT_ID'];
        }

        $this->eventbrite = new Eventbrite(
            new MockHttpAdapter(),
            array(
                 'app_key' => $this->appKey,
                 'user_key' => $this->userKey
            )
        );

    }

    public function testPostWithValidData()
    {
        $content = array('events' => 'foobar');

        $this->assertEquals(json_encode($content), $this->eventbrite->post('dummy', $content));
    }

    public function testGetWithValidData()
    {
        $content = array('events' => 'foobar');

        $this->assertEquals(json_encode($content), $this->eventbrite->get('dummy', $content));

    }
}

class MockHttpAdapter implements HttpAdapterInterface
{
    public function getContent($url, array $headers = array())
    {
        return '{"events":"foobar"}';
    }

    public function postContent($url, $headers = array(), $content = '')
    {
        return '{"events":"foobar"}';
    }

    public function getName()
    {
        return 'httpAdpater';
    }
}
