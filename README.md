Eventbrite API Connector
========================

[![Build Status](https://travis-ci.org/danielcsgomes/EventbriteApiConnector.png?branch=master)](https://travis-ci.org/danielcsgomes/EventbriteApiConnector) [![Latest Stable Version](https://poser.pugx.org/danielcsgomes/eventbrite-api-connector/v/stable.png)](https://packagist.org/packages/danielcsgomes/eventbrite-api-connector) [![Total Downloads](https://poser.pugx.org/danielcsgomes/eventbrite-api-connector/downloads.png)](https://packagist.org/packages/danielcsgomes/eventbrite-api-connector)

Eventbrite Api Connector is a lightweight PHP 5.3 library for issuing the Eventbrite API.

### Instalation

#### Composer

```json
"require": {
    ...
    "danielcsgomes/eventbrite-api-connector": "dev-master"
}
```

### Usage

```php
$apiKeys = array(
    'app_key' => 'YOUR APP KEY'
);

$params = array(
    'keywords' => 'php'
);

$eventbrite = new Eventbrite(new BuzzHttpAdapter(), $apiKeys);
$results = $eventbrite->get('event_search', $params);
```

### TODO

 * Implement more HTTP Adapters
 * Implement OAuth2.
 * Add more tests.
 * Add documentation.

### Credits

 * [Daniel Gomes](https://github.com/danielcsgomes)
 * Http Adapters inspired by [Geocoder PHP Library](https://github.com/geocoder-php/Geocoder)

### License

**Eventbrite API Connector** is released under the MIT License. See the bundled LICENSE file for details.
