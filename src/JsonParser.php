<?php
namespace Peridot\Leo\HttpFoundation;

use Symfony\Component\HttpFoundation\Response;

class JsonParser
{
    /**
     * @var Response
     */
    protected $response;

    /**
     * @var string
     */
    private static $jsonResponse = '/json/';

    /**
     * @param $response
     */
    public function __construct($response)
    {
        if (! $response instanceof Response) {
            throw new \InvalidArgumentException('JsonParser requires an HttpFoundation\Response');
        }
        $this->response = $response;
    }

    /**
     * Return an object from a decoded response body.
     *
     * @return object
     */
    public function getJsonObject()
    {
        if (! preg_match(static::$jsonResponse, $this->response->headers->get('content-type'))) {
            throw new \InvalidArgumentException("JsonParser requires response with json content type");
        }

        $object = json_decode($this->response->getContent());

        $error = json_last_error();
        if (JSON_ERROR_NONE !== $error) {
            throw new \InvalidArgumentException($this->transformError($error));
        }

        return $object;
    }

    /**
     * Get json decode error as human readable message.
     *
     * @param $error
     * @return string
     */
    protected function transformError($error)
    {
        switch ($error) {
            case JSON_ERROR_DEPTH:
                return 'Maximum stack depth exceeded.';

            case JSON_ERROR_STATE_MISMATCH:
                return 'Underflow or the modes mismatch.';

            case JSON_ERROR_CTRL_CHAR:
                return 'Unexpected control character found.';

            case JSON_ERROR_SYNTAX:
                return 'Syntax error, malformed JSON.';

            case JSON_ERROR_UTF8:
                return 'Malformed UTF-8 characters, possibly incorrectly encoded.';

            default:
                return 'Unknown error.';
        }
    }
} 
