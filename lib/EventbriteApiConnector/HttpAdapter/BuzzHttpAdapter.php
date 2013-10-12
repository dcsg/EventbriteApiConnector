<?php

/**
 * This file is part of the EventbriteApiConnector package.
 *
 * (c) Daniel Gomes <me@danielcsgomes.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EventbriteApiConnector\HttpAdapter;

use Buzz\Browser;

/**
 * @author William Durand <william.durand1@gmail.com>
 * @author Daniel Gomes <me@danielcsgomes.com>
 *
 * @package EventbriteApiConnector
 */
class BuzzHttpAdapter implements HttpAdapterInterface
{
    /**
     * @var Browser
     */
    protected $browser;

    /**
     * @param Browser $browser Browser object
     */
    public function __construct(Browser $browser = null)
    {
        $this->browser = null === $browser ? new Browser() : $browser;
    }

    /**
     * {@inheritDoc}
     */
    public function getContent($url, array $headers = array())
    {
        try {
            $response = $this->browser->get($url, $headers);
            $content = $response->getContent();
        } catch (\Exception $e) {
            $content = null;
        }

        return $content;
    }

    /**
     * @param string $url
     * @param array  $headers HTTP headers
     * @param string $content Content to be sent
     *
     * @return string
     */
    public function postContent($url, $headers = array(), $content = '')
    {
        try {
            $response = $this->browser->post($url, $headers, $content);
            $content = $response->getContent();
        } catch (\Exception $e) {
            $content = null;
        }

        return $content;
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'buzz';
    }
}
