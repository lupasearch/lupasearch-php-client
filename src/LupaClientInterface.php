<?php

namespace LupaSearch;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use LupaSearch\Exceptions\AuthenticationException;
use LupaSearch\Exceptions\MissingCredentialsException;
use LupaSearch\Exceptions\TooManyRetriesException;

interface LupaClientInterface
{
    const VERSION = '0.1.0';

    const API_BASE_PATH = 'https://api.lupasearch.com/v1';
    const USER_AGENT = 'LupaSearch API PHP Client, v' . self::VERSION;

    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const METHOD_PUT = 'PUT';
    const METHOD_DELETE = 'DELETE';

    const REQUEST_MAX_RETRIES = 3;

    const DEFAULT_HEADERS = [
        'Content-Type' => 'application/json',
        'Accept' => 'application/json',
        'User-Agent' => self::USER_AGENT,
    ];

    public function getHttpClient(): ClientInterface;

    public function setHttpClient(ClientInterface $httpClient): self;

    public function setJwtToken(?string $jwtToken): self;

    public function getJwtToken(): ?string;

    public function setEmail(string $email): self;

    public function setPassword(string $password): self;

    /**
     * @throws AuthenticationException
     * @throws GuzzleException
     * @throws MissingCredentialsException
     * @throws TooManyRetriesException
     */
    public function send(
        string $method,
        string $uri,
        bool $requireAuthentication = false,
        ?string $httpBody = null
    ): array;

    /**
     * @throws AuthenticationException
     * @throws MissingCredentialsException
     */
    public function authenticate(): string;

    /**
     * @throws AuthenticationException
     * @throws MissingCredentialsException
     * @throws TooManyRetriesException
     * @throws GuzzleException
     */
    public function userLogin(array $credentials): array;
}
