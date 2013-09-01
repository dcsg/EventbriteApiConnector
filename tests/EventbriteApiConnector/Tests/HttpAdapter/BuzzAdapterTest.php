<?php

namespace EventbriteApiConnector\Tests\HttpAdapter;

use EventbriteApiConnector\HttpAdapter\BuzzHttpAdapter;

/**
 * @author William Durand <william.durand1@gmail.com>
 * @author Daniel Gomes <me@danielcsgomes.com>
 */
class BuzzHttpAdapterTest extends \PHPUnit_Framework_TestCase
{
    protected $buzz;

    protected function setUp()
    {
        if (!class_exists('Buzz\Browser')) {
            $this->markTestSkipped('Buzz library has to be installed');
        }

        $this->buzz = new BuzzHttpAdapter();
    }

    public function testGetNullContent()
    {
        $this->assertNull($this->buzz->getContent(null));
    }

    public function testGetFalseContent()
    {
        $this->assertNull($this->buzz->getContent(false));
    }

    public function testGetName()
    {
        $this->assertEquals('buzz', $this->buzz->getName());
    }

    public function testGetContentWithCustomBrowser()
    {
        $content = 'foobar content';
        $browser = $this->getBrowserMock($content);

        $buzz = new BuzzHttpAdapter($browser);
        $this->assertEquals($content, $buzz->getContent('http://www.example.com'));
    }

    protected function getBrowserMock($content, $method = 'get')
    {
        $mock = $this->getMock('Buzz\Browser');
        $mock
            ->expects($this->once())
            ->method($method)
            ->will($this->returnValue($this->getResponseMock($content)));

        return $mock;
    }

    protected function getResponseMock($content, $method = 'get')
    {
        $mock = $this->getMock('Buzz\Message\Response');
        $mock
            ->expects($this->once())
            ->method($method . 'Content')
            ->will($this->returnValue($content));

        return $mock;
    }

    public function testPostNullContent()
    {
        $this->assertNull($this->buzz->postContent(null));
    }

    public function testPostFalseContent()
    {
        $this->assertNull($this->buzz->postContent(false));
    }

    public function testPostContentWithCustomBrowser()
    {
        $content = array('data' => 'foobar content');
        $browser = $this->getBrowserMock($content, 'post');

        $buzz = new BuzzHttpAdapter($browser, 'post');

        $response = $buzz->postContent('http://httpbin.org/post', array(), http_build_query($content));
        $this->assertEquals($content, $response);
    }
}
