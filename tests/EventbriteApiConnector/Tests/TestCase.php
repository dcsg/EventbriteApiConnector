<?php

namespace EventbriteApiConnector\Tests;

use EventbriteApiConnector\HttpAdapter\HttpAdapterInterface;

/**
 * @author William Durand <william.durand1@gmail.com>
 */
abstract class TestCase extends \PHPUnit_Framework_TestCase
{

    /**
     * @var HttpAdapterInterface
     */
    protected $adapterMock;

    /**
     * @return HttpAdapterInterface
     */
    protected function getAdapterMock()
    {
        if (!isset($this->adapterMock)) {
            $this->adapterMock = $this->getMock('\EventbriteApiConnector\HttpAdapter\HttpAdapterInterface');
        }

        return $this->adapterMock;
    }

    /**
     * @param mixed $expects
     * @param mixed $result
     */
    protected function mockGetMethod($expects = null, $result)
    {
        if (null === $expects) {
            $expects = $this->once();
        }

        $this->adapterMock
            ->expects($expects)
            ->method('getContent')
            ->will($this->returnValue($result));
    }

    /**
     * @param mixed $expects
     * @param mixed $result
     */
    protected function mockPostMethod($expects = null, $result)
    {
        if (null === $expects) {
            $expects = $this->once();
        }

        $this->adapterMock
            ->expects($expects)
            ->method('postContent')
            ->will($this->returnValue($result));
    }
}
