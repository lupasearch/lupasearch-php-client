<?php

declare(strict_types=1);

namespace LupaSearch;

use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\ServerException;
use LupaSearch\Exceptions\AuthenticationException;
use LupaSearch\Exceptions\AuthorizationException;
use LupaSearch\Exceptions\MissingCredentialsException;
use LupaSearch\Exceptions\TooManyRetriesException;
use LupaSearch\Factories\HttpClientFactory;
use LupaSearch\Factories\HttpClientFactoryInterface;
use LupaSearch\Handlers\ErrorHandlerInterface;
use LupaSearch\Handlers\RequestErrorHandler;
use LupaSearch\Utils\JsonUtils;
use LupaSearch\Utils\JwtUtils;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;
use Throwable;

class LupaClient implements LupaClientInterface
{
    /**
     * @var HttpClientFactoryInterface|null
     */
    private $httpClientFactory;

    /**
     * @var ErrorHandlerInterface|null
     */
    private $errorHandler;

    /**
     * @var ClientInterface|null
     */
    private $httpClient;

    /**
     * @var string|null
     */
    private $jwtToken;

    /**
     * @var string|null
     */
    private $email;

    /**
     * @var string|null
     */
    private $password;

    /**
     * @var string|null
     */
    private $apiKey;

    public function __construct(
        ?HttpClientFactoryInterface $httpClientFactory = null,
        ?ErrorHandlerInterface $errorHandler = null
    ) {
        $this->httpClientFactory = $httpClientFactory ?? new HttpClientFactory();
        $this->errorHandler = $errorHandler ?? new RequestErrorHandler();
    }

    public function getHttpClient(): ClientInterface
    {
        if (null === $this->httpClient) {
            $this->setHttpClient($this->httpClientFactory->create());
        }

        return $this->httpClient;
    }

    public function setHttpClient(ClientInterface $httpClient): self
    {
        $this->httpClient = $httpClient;

        return $this;
    }

    public function setJwtToken(?string $jwtToken): self
    {
        $this->jwtToken = $jwtToken;

        return $this;
    }

    public function getJwtToken(): ?string
    {
        return $this->jwtToken;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function setApiKey(?string $apiKey): self
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    public function getApiKey(): ?string
    {
        return $this->apiKey;
    }

    public function getAuthorizationType(): string
    {
        if ($this->getApiKey()) {
            return self::AUTH_TYPE_API_KEY;
        }

        if ($this->getJwtToken() || ($this->email && $this->password)) {
            return self::AUTH_TYPE_JWT;
        }

        throw new AuthorizationException(
            'Failed to determine authorization type. Either set API key or JWT token (auth credentials) to continue.'
        );
    }

    public function withAuthorizationHeader(Request $request, string $authType): Request
    {
        switch ($authType) {
            case self::AUTH_TYPE_API_KEY:
                return $request->withHeader(self::HEADER_LUPA_API_KEY, $this->getApiKey());
            case self::AUTH_TYPE_JWT:
                $jwtToken = $this->getOrRefreshJwtToken();

                return $request->withHeader('Authorization', "Bearer {$jwtToken}");
        }

        return $request;
    }

    /**
     * @inheritDoc
     */
    public function send(
        string $method,
        string $uri,
        bool $requireAuthentication = false,
        ?string $httpBody = null
    ): array {
        $request = new Request($method, LupaClientInterface::API_BASE_PATH . $uri, self::DEFAULT_HEADERS, $httpBody);

        $attempts = 0;
        $e = null;
        do {
            $attempts++;
            if ($attempts > self::REQUEST_MAX_RETRIES) {
                throw new TooManyRetriesException(
                    'Request failed after ' . self::REQUEST_MAX_RETRIES . ' retries',
                    0,
                    $e
                );
            }

            if ($requireAuthentication) {
                $request = $this->withAuthorizationHeader($request, $this->getAuthorizationType());
            }

            try {
                $response = $this->getHttpClient()->send($request);

                return JsonUtils::jsonDecode($response->getBody()->getContents(), true);
            } catch (ConnectException|ServerException $e) {
                continue;
            } catch (ClientException $e) {
                if ($e->getCode() === 401 && $this->getAuthorizationType() === self::AUTH_TYPE_JWT) {
                    $this->setJwtToken(null);
                    continue;
                }
                $this->errorHandler->handle($e);
            } catch (Throwable $e) {
                $this->errorHandler->handle($e);
            }
        } while (true);
    }

    /**
     * @inheritDoc
     */
    public function authenticate(): string
    {
        if (!$this->email) {
            throw new MissingCredentialsException('Email is missing');
        }

        if (!$this->password) {
            throw new MissingCredentialsException('Password is missing');
        }

        $response = $this->userLogin([
            'email' => $this->email,
            'password' => $this->password,
        ]);

        if (empty($response['token'])) {
            throw new AuthenticationException('Authentication failed');
        }

        $this->setJwtToken($response['token']);

        return $response['token'];
    }

    /**
     * @inheritDoc
     */
    public function userLogin(array $credentials): array
    {
        return $this->send(self::METHOD_POST, '/users/login', false, JsonUtils::jsonEncode($credentials));
    }

    /**
     * @throws AuthenticationException
     * @throws MissingCredentialsException
     */
    protected function getOrRefreshJwtToken(): string
    {
        $jwtToken = $this->getJwtToken();
        if (!JwtUtils::isJwtTokenValid($jwtToken)) {
            $jwtToken = $this->authenticate();
        }

        return $jwtToken;
    }
}
