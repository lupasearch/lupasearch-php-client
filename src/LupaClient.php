<?php

namespace LupaSearch;

use LupaSearch\Exceptions\AuthenticationFailedException;
use LupaSearch\Exceptions\MissingCredentials;
use LupaSearch\Utils\JwtUtils;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;
use Throwable;
use function json_encode;

class LupaClient
{
    const VERSION = "0.1.0";

    const API_BASE_PATH = "https://api.lupasearch.com/v1";
    const USER_AGENT = "LupaSearch API PHP Client, v" . self::VERSION;

    const METHOD_GET = "GET";
    const METHOD_POST = "POST";
    const METHOD_PUT = "PUT";
    const METHOD_DELETE = "DELETE";

    const DEFAULT_HEADERS = [
        "Content-Type" => "application/json",
        "Accept" => "application/json",
        "User-Agent" => self::USER_AGENT,
    ];

    private $httpClient = null;
    private $jwtToken = null;

    private $email = null;
    private $password = null;

    private function getHttpClient(): Client
    {
        if (null === $this->httpClient) {
            $this->setHttpClient(new Client());
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

    public function send(
        string $method,
        string $uri,
        bool $requireAuthentication = false,
        ?string $httpBody = null
    ): array {
        $request = new Request($method, $uri, self::DEFAULT_HEADERS, $httpBody);

        if ($requireAuthentication) {
            $jwtToken = $this->getJwtToken();
            if (!JwtUtils::isJwtTokenValid($jwtToken)) {
                $jwtToken = $this->authenticate();
            }
            $request = $request->withHeader(
                "Authorization",
                "Bearer $jwtToken"
            );
        }

        try {
            $response = $this->getHttpClient()->send($request);
        } catch (Throwable $e) {
            if ($e instanceof ClientException) {
                switch ($e->getCode()) {
                    case 401:
                        $this->setJwtToken(null);
                        break;
                }
            }
            throw $e;
        }

        return json_decode($response->getBody(), true);
    }

    public function authenticate(): string
    {
        if (!$this->email) {
            throw new MissingCredentials("Email is missing");
        }

        if (!$this->password) {
            throw new MissingCredentials("Password is missing");
        }

        $response = $this->userLogin([
            "email" => $this->email,
            "password" => $this->password,
        ]);

        if (isset($response["token"])) {
            $this->setJwtToken($response["token"]);
        } else {
            throw new AuthenticationFailedException("Authentication failed");
        }

        return $response["token"];
    }

    public function userLogin(array $credentials): array
    {
        return $this->send(
            self::METHOD_POST,
            self::API_BASE_PATH . "/users/login",
            false,
            json_encode($credentials)
        );
    }
}
