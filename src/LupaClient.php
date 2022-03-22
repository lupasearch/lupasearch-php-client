<?php

namespace LupaSearch;

use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\GuzzleException;
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

use function json_encode;

class LupaClient
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
        'User-Agent' => self::USER_AGENT
    ];

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

    public function __construct(
        HttpClientFactoryInterface $httpClientFactory = null
    ) {
        $this->httpClientFactory =
            $httpClientFactory ?? new HttpClientFactory();
    }

    private function getHttpClient(): Client
    {
        if (null === $this->httpClient) {
            $this->setHttpClient($this->httpClientFactory->create());
        }

        return $this->httpClient;
    }

    private function setHttpClient(ClientInterface $httpClient): self
    {
        $this->httpClient = $httpClient;

        return $this;
    }

    private function setJwtToken(?string $jwtToken): self
    {
        $this->jwtToken = $jwtToken;

        return $this;
    }

    private function getJwtToken(): ?string
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
     * @param string $method
     * @param string $uri
     * @param bool $requireAuthentication
     * @param string|null $httpBody
     * @return array
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
    ): array {
        $request = new Request($method, $uri, self::DEFAULT_HEADERS, $httpBody);

        $attempts = 0;
        $e = null;
        do {
            $attempts++;
            if ($attempts > self::REQUEST_MAX_RETRIES) {
                throw new TooManyRetriesException(
                    'Request failed after ' .
                        self::REQUEST_MAX_RETRIES .
                        ' retries',
                    0,
                    $e
                );
            }

            if ($requireAuthentication) {
                $jwtToken = $this->getJwtToken();
                if (!JwtUtils::isJwtTokenValid($jwtToken)) {
                    $jwtToken = $this->authenticate();
                }

                $request = $request->withHeader(
                    'Authorization',
                    "Bearer $jwtToken"
                );
            }

            try {
                $response = $this->getHttpClient()->send($request);

                return json_decode($response->getBody(), true);
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
     * @return string
     * @throws AuthenticationException
     * @throws MissingCredentialsException
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
            'password' => $this->password
        ]);

        if (isset($response['token'])) {
            $this->setJwtToken($response['token']);
        } else {
            throw new AuthenticationException('Authentication failed');
        }

        return $response['token'];
    }

    public function userLogin(array $credentials): array
    {
        return $this->send(
            self::METHOD_POST,
            self::API_BASE_PATH . '/users/login',
            false,
            json_encode($credentials)
        );
    }
}
