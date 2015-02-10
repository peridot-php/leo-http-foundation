<?php

namespace Peridot\Leo\HttpFoundation;

use Peridot\Leo\Assertion;
use Peridot\Leo\HttpFoundation\Matcher\AllowedMatcher;
use Peridot\Leo\HttpFoundation\Matcher\StatusMatcher;

/**
 * Class LeoHttpFoundation
 * @package Peridot\Leo\HttpFoundation
 */
class LeoHttpFoundation
{
    /**
     * Register http assertion methods.
     *
     * @param Assertion $assertion
     */
    public function __invoke(Assertion $assertion)
    {
        /**
         * Asserts that the allowed headers match the expected array of methods.
         */
        $assertion->addMethod('allow', function ($expected, $message = "") {
            $this->flag('message', $message);
            return new AllowedMatcher($expected);
        });

        /**
         * Asserts that the response has the expected status code.
         */
        $assertion->addMethod('status', function ($expected, $message = "") {
            $this->flag('message', $message);
            return new StatusMatcher($expected);
        });

        /**
         * Property converts response body to json object (or array) and sets it
         * as the new subject of the assertion chain.
         */
        $assertion->addProperty('json', function ($assoc = false, $depth = 512, $options = 0) {
            $parser = new JsonParser($this->getActual());
            return $this->setActual($parser->getJsonObject($assoc, $depth, $options));
        });
    }
}
