<?php

use Peridot\Leo\HttpFoundation\JsonParser;
use Symfony\Component\HttpFoundation\Response;

describe('JsonParser', function() {
    it('should throw an exception if parser constructed with non-response', function() {
        expect(function() {
            new JsonParser('string');
        })->to->throw('InvalidArgumentException');
    });

    describe('->getJsonObject()', function() {
        beforeEach(function() {
            $this->data = [
                'name' => 'brian',
                'age' => 28
            ];

            $this->response = new Response();
            $this->response->headers->set('content-type', 'application/json');
            $this->response->setContent(json_encode($this->data));
            $this->parser = new JsonParser($this->response);
        });

        it('should return a json object for the content', function() {
            $object = $this->parser->getJsonObject(false, 512, 0);
            expect($object)->to->have->property('name');
        });

        it('should throw an exception if the content type is not json', function() {
            $this->response->headers->set('content-type', 'text/html');
            $parser = new JsonParser($this->response);
            expect(function() use ($parser) {
                $parser->getJsonObject(false, 512, 0);
            })->to->throw('InvalidArgumentException');
        });

        it('should throw an exception for malformed json', function() {
            $this->response->setContent('{"name":"brian"');
            $parser = new JsonParser($this->response);
            expect(function() use ($parser) {
                $parser->getJsonObject(false, 512, 0);
            })->to->throw('InvalidArgumentException');
        });

        it('should return an associative array if the $assoc parameter is set to true', function () {
            $this->parser = new JsonParser($this->response);
            $array = $this->parser->getJsonObject(true, 512, 0);
            expect($array)->to->equal($this->data);
        });

        it('should throw an exception if the maximum stack depth is exceeded', function () {
            $this->data['name'] = ['first' => 'austin', 'last' => 'morris'];
            $this->response->setContent(json_encode($this->data));
            $parser = new JsonParser($this->response);
            expect(function() use ($parser) {
                $parser->getJsonObject(true, 2, 0);
            })->to->throw('InvalidArgumentException');
        });

        it('should honor the $options parameter', function () {
            $this->response->setContent('{"name":"brian","age":987345989834753984759837459837459837422}');
            $this->parser = new JsonParser($this->response);
            $array = $this->parser->getJsonObject(true, 512, JSON_BIGINT_AS_STRING);
            expect($array['age'])->to->a('string');
        });
    });
});
