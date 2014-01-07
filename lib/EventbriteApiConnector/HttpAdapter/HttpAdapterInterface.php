<?php
/**
 * This file is part of the EventbriteApiConnector package.
 *
 * (c) 2013-2014 Daniel Gomes <me@danielcsgomes.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EventbriteApiConnector\HttpAdapter;

/**
 * @author William Durand <william.durand1@gmail.com>
 * @author Daniel Gomes <me@danielcsgomes.com>
 *
 * @package EventbriteApiConnector
 */
interface HttpAdapterInterface
{
    /**
     * Returns the content fetched from a given URL using the GET method.
     *
     * @param string $url     The url
     * @param array  $headers HTTP headers
     *
     * @return string
     */
    public function getContent($url, array $headers = array());

    /**
     * Returns the content fetched from a given URL using the POST method.
     * @param string $url     The url
     * @param array  $headers HTTP headers
     * @param string $content Content to be sent
     *
     * @return string
     */
    public function postContent($url, $headers = array(), $content = '');

    /**
     * Returns the name of the HTTP Adapter.
     *
     * @return string
     */
    public function getName();
}
