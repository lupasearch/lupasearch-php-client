<?php

namespace LupaSearch;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use LupaSearch\Exceptions\ApiException;
use LupaSearch\Exceptions\AuthenticationException;
use LupaSearch\Exceptions\AuthorizationException;
use LupaSearch\Exceptions\MissingCredentialsException;
use LupaSearch\Exceptions\TooManyRetriesException;

interface LupaClientInterface
{
    const VERSION = '0.5.0';

    const API_BASE_PATH = 'https://api.lupasearch.com/v1';
    const USER_AGENT = 'LupaSearch API PHP Client, v' . self::VERSION;

    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const METHOD_PUT = 'PUT';
    const METHOD_PATCH = 'PATCH';
    const METHOD_DELETE = 'DELETE';

    const REQUEST_MAX_RETRIES = 3;

    const DEFAULT_HEADERS = [
        'Content-Type' => 'application/json',
        'Accept' => 'application/json',
        'User-Agent' => self::USER_AGENT,
    ];

    const HEADER_LUPA_API_KEY = 'X-Lupa-API-Key';

    const AUTH_TYPE_JWT = 'jwt';
    const AUTH_TYPE_API_KEY = 'apiKey';

    public function getHttpClient(): ClientInterface;

    public function setHttpClient(ClientInterface $httpClient): self;

    public function setJwtToken(?string $jwtToken): self;

    public function getJwtToken(): ?string;

    public function setEmail(string $email): self;

    public function setPassword(string $password): self;

    public function setApiKey(?string $apiKey): self;

    public function getApiKey(): ?string;

    /**
     * @throws AuthorizationException
     * @return string
     */
    public function getAuthorizationType(): string;

    /**
     * @throws ApiException
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

    /**
     * @throws AuthenticationException
     * @throws MissingCredentialsException
     */
    public function withAuthorizationHeader(Request $request, string $authType): Request;
}
