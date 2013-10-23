<?php

namespace EventbriteApiConnector\Tests;

use EventbriteApiConnector\Eventbrite;
use EventbriteApiConnector\Tests\HttpAdapter\MockHttpAdapter;

/**
 * @author Daniel Gomes <me@danielcsgomes.com>
 */
class EventbriteApiConnectorTest extends TestCase
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
        $this->eventbrite = new Eventbrite(
            $this->getAdapterMock(),
            array(
                 'app_key' => 'API KEY',
                 'user_key' => 'USER KEY'
            )
        );

    }

    /**
     * @expectedException \Exception
     */
    public function testConstructWithoutRequiredKeys()
    {
        new Eventbrite($this->getAdapterMock(), array());
    }

    public function testGetContentWithValidJsonResponse()
    {
        $this->mockGetMethod($this->once(), '{"foo":"bar"}');

        $response = $this->eventbrite->get('foo', array('bar'));

        $this->assertEquals('{"foo":"bar"}', $response);
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Error decoding JSON.
     */
    public function testGetContentWithInvalidJsonResponse()
    {
        $this->mockGetMethod($this->once(), 'foo');

        $this->eventbrite->get('foo', array('bar'));
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage test
     */
    public function testGetContentWithValidJsonResponseButWithErrors()
    {
        $this->mockGetMethod($this->once(), '{"error":{"error_message": "test"}}');

        $this->eventbrite->get('foo', array('bar'));
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage No results found.
     */
    public function testGetContentWithValidJsonResponseButEmptyData()
    {
        $this->mockGetMethod($this->once(), '');

        $this->eventbrite->get('foo', array('bar'));
    }

    public function testGetContentWithXmlOutput()
    {
        $content = '<a></a>';
        $this->mockGetMethod($this->once(), $content);

        $response = $this->eventbrite->get(
            'foo',
            array('bar'),
            array(
                 'output_format' => 'xml'
            )
        );

        $this->assertEquals($content, $response);
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage test
     */
    public function testGetContentWithXmlOutputWithError()
    {
        $this->mockGetMethod(
            $this->once(),
            '<a><error_type>1</error_type><error_message>test</error_message></a>'
        );

        $this->eventbrite->get(
            'foo',
            array('bar'),
            array(
                 'output_format' => 'xml'
            )
        );
    }

    public function testPostContent()
    {
        $this->mockPostMethod($this->once(), '{"foo":"bar"}');


        $response = $this->eventbrite->post('foo', array('bar'));

        $this->assertEquals('{"foo":"bar"}', $response);
    }
}
