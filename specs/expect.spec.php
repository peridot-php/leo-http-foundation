<?php
use Symfony\Component\HttpFoundation\Response;

describe('LeoHttp expectations', function() {
    describe('->allow()', function() {
        it('should throw an exception if actual does not match expected', function() {
            expect(function() {
                $response = new Response();
                $response->headers->set('allowed', 'post, get, patch');
                expect($response)->to->allow(['POST', 'GET']);
            })->to->throw('Exception', 'Expected response to allow "POST, GET", got "POST, GET, PATCH"');
        });

        it('should allow a custom user message', function() {
            expect(function() {
                $response = new Response();
                $response->headers->set('allowed', 'post, get, patch');
                expect($response)->to->allow(['POST', 'GET'], 'wrong header value');
            })->to->throw('Exception', 'wrong header value');
        });

        context('when negated', function() {
            it('should throw an exception if any methods are found', function() {
                expect(function() {
                    $response = new Response();
                    $response->headers->set('allowed', 'post, get');
                    expect($response)->to->not->allow(['POST', 'GET']);
                })->to->throw('Exception', 'Expected response not to allow "POST, GET"');
            });
        });
    });
});
