<?php
namespace Peridot\Leo\Http\Matcher;

use Peridot\Leo\Matcher\Template\ArrayTemplate;
use Peridot\Leo\Matcher\Template\TemplateInterface;

class AllowedMatcher extends AbstractResponseMatcher
{
    /**
     * The diff between expected and actual allowed values.
     *
     * @var array
     */
    protected $diff = [];

    /**
     * The actual methods included in the Allowed header.
     *
     * @var array
     */
    protected $actual = [];

    /**
     * Return a default TemplateInterface if none was set.
     *
     * @return TemplateInterface
     */
    public function getDefaultTemplate()
    {
        $expectedMethods = implode(', ', $this->expected);
        $actualMethods = implode(', ', $this->actual);

        $template = new ArrayTemplate([
            'default' => 'Expected response to allow {{expected_methods}}, got {{actual_methods}}',
            'negated' => 'Expected response not to allow {{expected_methods}}'
        ]);

        return $template->setTemplateVars(['expected_methods' => $expectedMethods, 'actual_methods' => $actualMethods]);
    }

    /**
     * Uppercase the string and trim whitespace.
     *
     * @param $string
     * @return string
     */
    public function toHttpMethod($string)
    {
        $string = strtoupper($string);
        return trim($string);
    }

    /**
     * Check response headers for an allowed header and make sure
     * the actual value is allowed.
     *
     * @param array $actual the http method(s) expected to be allowed.
     * @return bool
     */
    protected function doMatch($actual)
    {
        if (!is_array($this->expected)) {
            throw new \InvalidArgumentException("AllowedMatcher requires an array of expected values");
        }

        $response = $this->getResponse($actual);
        if (! $response->headers->has('allowed')) {
            throw new \InvalidArgumentException("Allowed header not found");
        }

        $this->actual = array_map([$this, 'toHttpMethod'], explode(',', $response->headers->get('allowed')));
        $this->expected = array_map([$this, 'toHttpMethod'], $this->expected);

        $this->diff = array_diff($this->actual, $this->expected);

        return empty($this->diff);
    }
}
