<?php

namespace LupaSearch\Api;

use LupaSearch\LupaClient;
use GuzzleHttp\Psr7\Query;

use function json_encode;

class UsersApi
{
    private $client;

    public function __construct(LupaClient $client)
    {
        $this->client = $client;
    }

    public function getOrganizationUsers(
        string $organizationSlug,
        array $queryParams = []
    ): array {
        $query = Query::build($queryParams);

        return $this->client->send(
            LupaClient::METHOD_GET,
            LupaClient::API_BASE_PATH .
                "/organizations/$organizationSlug/users" .
                ($query ? "?{$query}" : ''),
            true
        );
    }

    public function createOrganizationUser(
        string $organizationSlug,
        array $httpBody
    ): array {
        return $this->client->send(
            LupaClient::METHOD_POST,
            LupaClient::API_BASE_PATH .
                "/organizations/$organizationSlug/users",
            true,
            json_encode($httpBody)
        );
    }

    public function updateOrganizationUser(
        string $organizationSlug,
        string $userId,
        array $httpBody
    ): array {
        return $this->client->send(
            LupaClient::METHOD_POST,
            LupaClient::API_BASE_PATH .
                "/organizations/$organizationSlug/users/$userId",
            true,
            json_encode($httpBody)
        );
    }

    public function deleteOrganizationUser(
        string $organizationSlug,
        string $userId
    ): array {
        return $this->client->send(
            LupaClient::METHOD_DELETE,
            LupaClient::API_BASE_PATH .
                "/organizations/$organizationSlug/users/$userId",
            true
        );
    }

    public function userLogin(array $credentials): array
    {
        return $this->client->userLogin($credentials);
    }

    public function myInfo(): array
    {
        return $this->client->send(
            LupaClient::METHOD_GET,
            LupaClient::API_BASE_PATH . '/users/me',
            true
        );
    }
}
