<?php
namespace Peridot\Leo\HttpFoundation\Matcher;

use Peridot\Leo\Matcher\AbstractMatcher;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractResponseMatcher extends AbstractMatcher
{
    /**
     * Validate that the expected value is an HttpFoundation\Response before returning it.
     *
     * @return Response
     */
    protected function getResponse($actual)
    {
        if (! $actual instanceof Response) {
            throw new \InvalidArgumentException('HttpFoundation\Response required for expected value');
        }
        return $actual;
    }
}
