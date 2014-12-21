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

    describe('->status()', function() {
        it('should throw an exception if the response has an unexpected status code', function() {
            expect(function() {
                $response = new Response();
                $response->setStatusCode(400);
                expect($response)->to->have->status(200);
            })->to->throw('Exception', 'Expected status code 200, got 400');
        });

        it('should allow a user message', function() {
            expect(function() {
                $response = new Response();
                $response->setStatusCode(400);
                expect($response)->to->have->status(200, 'wrong status');
            })->to->throw('Exception', 'wrong status');
        });

        context('when negated', function() {
            it('should throw an exception if status code matches', function() {
                expect(function() {
                    $response = new Response();
                    $response->setStatusCode(200);
                    expect($response)->to->not->have->status(200);
                })->to->throw('Exception', 'Expected status code to not be 200');
            });
        });
    });
});
