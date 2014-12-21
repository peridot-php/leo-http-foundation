<?php
namespace Peridot\Leo\Http;

use Peridot\Leo\Assertion;
use Peridot\Leo\Http\Matcher\AllowedMatcher;

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
         * Asserts that the allow headers have matching values.
         */
        $assertion->addMethod('allow', function ($expected, $message = "") {
            $this->flag('message', $message);
            return new AllowedMatcher($expected);
        });
    }
} 
