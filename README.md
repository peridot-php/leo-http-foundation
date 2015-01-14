#Leo Http Foundation

[Leo](http://peridot-php.github.io/leo/) assertions for use with [HttpFoundation](http://symfony.com/doc/current/components/http_foundation/introduction.html)

[![Build Status](https://travis-ci.org/peridot-php/leo-http-foundation.svg?branch=master)](https://travis-ci.org/peridot-php/leo-http-foundation)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/peridot-php/leo-http-foundation/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/peridot-php/leo-http-foundation/?branch=master)

This set of assertions is evolving as needed. Please feel free to submit pull requests and make
feature requests.

##Usage

You can add HttpFoundation behavior to Leo by extending the Leo `assertion` property.

```php
$assertion = Leo::assertion();
$assertion->extend(new LeoHttpFoundation());
```

##Assertions

###->allow(methods, [message])

* @param `array` $methods
* @param `string` $message [optional]

Checks that the Allowed header is present on the response and that it
contains **all** values passed in the `methods` array.

```php
expect($response)->to->allow(['POST', 'GET']);
expect($response)->to->not->allow(['GET]');
```

###->status(status, [message])

* @param `int` $status
* @param `string` $message [optional]

Asserts that the response status is equal to `status`.

```php
expect($response)->to->have->status(200);
expect($response)->to->not->have->status(400);
```

###->json

A language chain that parses the response body as json and sets it as the subject
of the assertion chain.

```php
expect($response)->json->to->have->property('name');
expect($response)->json->to->loosely->equal($expected);
```
