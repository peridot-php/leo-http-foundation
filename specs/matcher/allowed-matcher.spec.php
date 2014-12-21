<?php
use Peridot\Leo\HttpFoundation\Matcher\AllowedMatcher;
use Symfony\Component\HttpFoundation\Response;

describe('AllowedMatcher', function() {
    beforeEach(function() {
        $this->matcher = new AllowedMatcher(['POST', 'GET']);
    });

    describe('->match()', function() {
        it('should throw an exception if expected value is not an array', function() {
            expect(function() {
                $matcher = new AllowedMatcher('ham');
                $matcher->match(new Response());
            })->to->throw('InvalidArgumentException');
        });

        it('should throw an exception if actual value is not a response', function() {
            expect([$this->matcher, 'match'])->with('ham')
                ->to->throw('InvalidArgumentException');
        });

        it('should throw an exception if allowed header is missing', function() {
            $response = new Response();
            expect([$this->matcher, 'match'])->with($response)
                ->to->throw('InvalidArgumentException', 'Allowed header not found');
        });

        it('should return true if headers match', function() {
            $response = new Response();
            $response->headers->set('allowed', 'get, post');
            $result = $this->matcher->match($response);
            expect($result->isMatch())->to->be->true;
        });

        it('should return false if headers do not match', function() {
            $response = new Response();
            $response->headers->set('allowed', 'get, post, patch');
            $result = $this->matcher->match($response);
            expect($result->isMatch())->to->be->false;
        });
    });
});
