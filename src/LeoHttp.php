<?php
namespace Peridot\Leo\Http;

use Peridot\Leo\Assertion;
use Peridot\Leo\Http\Matcher\AllowedMatcher;
use Peridot\Leo\Http\Matcher\StatusMatcher;

class LeoHttp
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
    }
} 
