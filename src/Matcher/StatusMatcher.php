<?php
namespace Peridot\Leo\HttpFoundation\Matcher;

use Peridot\Leo\Matcher\Template\ArrayTemplate;
use Peridot\Leo\Matcher\Template\TemplateInterface;

class StatusMatcher extends AbstractResponseMatcher
{
    /**
     * @var int
     */
    protected $actualStatusCode;

    /**
     * Return a default TemplateInterface if none was set.
     *
     * @return TemplateInterface
     */
    public function getDefaultTemplate()
    {
        $template = new ArrayTemplate([
            'default' => 'Expected status code {{expected}}, got {{actual_status}}',
            'negated' => 'Expected status code to not be {{expected}}'
        ]);

        return $template->setTemplateVars(['actual_status' => $this->actualStatusCode]);
    }

    /**
     * Match that the response has the expected status code.
     *
     * @param mixed $actual
     * @return bool
     */
    protected function doMatch($actual)
    {
        $response = $this->getResponse($actual);
        $this->actualStatusCode = $response->getStatusCode();
        return $this->actualStatusCode === $this->expected;
    }
}
