<?php
use Peridot\Leo\Http\JsonParser;
use Symfony\Component\HttpFoundation\Response;

describe('JsonParser', function() {
    it('should throw an exception if parser constructed with non response', function() {
        expect(function() {
            $parser = new JsonParser('string');
        })->to->throw('InvalidArgumentException');
    });

    describe('->getJsonObject()', function() {
        beforeEach(function() {
            $this->response = new Response();
            $this->response->headers->set('content-type', 'application/json');
            $this->response->setContent(json_encode([
                'name' => 'brian',
                'age' => 28
            ]));
            $this->parser = new JsonParser($this->response);
        });

        it('should return a json object for the content', function() {
            $object = $this->parser->getJsonObject();
            expect($object)->to->have->property('name');
        });

        it('should throw an exception if the content type is not json', function() {
            $this->response->headers->set('content-type', 'text/html');
            expect([$this->parser, 'getJsonObject'])->to->throw('InvalidArgumentException');
        });

        it('should throw an exception for malformed json', function() {
            $this->response->setContent('{"name":"brian"');
            expect([$this->parser, 'getJsonObject'])->to->throw('InvalidArgumentException');
        });
    });
});
