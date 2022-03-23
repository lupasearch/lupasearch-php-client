<?php

declare(strict_types=1);

namespace LupaSearch;

use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Utils;
use LupaSearch\Exceptions\AuthenticationException;
use LupaSearch\Exceptions\MissingCredentialsException;
use LupaSearch\Exceptions\TooManyRetriesException;
use LupaSearch\Factories\HttpClientFactory;
use LupaSearch\Factories\HttpClientFactoryInterface;
use LupaSearch\Utils\JwtUtils;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;

class LupaClient implements LupaClientInterface
{
    /**
     * @var HttpClientFactoryInterface|null
     */
    private $httpClientFactory;

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

    public function __construct(HttpClientFactoryInterface $httpClientFactory = null)
    {
        $this->httpClientFactory = $httpClientFactory ?? new HttpClientFactory();
    }

    public function getHttpClient(): Client
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
                $jwtToken = $this->getOrRefreshJwtToken();
                $request = $request->withHeader('Authorization', "Bearer $jwtToken");
            }

            try {
                $response = $this->getHttpClient()->send($request);

                return Utils::jsonDecode($response->getBody(), true);
            } catch (ConnectException $e) {
                continue;
            } catch (ClientException $e) {
                if ($e->getCode() === 401) {
                    $this->setJwtToken(null);
                    continue;
                }
                throw $e;
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

    public function userLogin(array $credentials): array
    {
        return $this->send(
            self::METHOD_POST,
            self::API_BASE_PATH . '/users/login',
            false,
            Utils::jsonEncode($credentials)
        );
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
