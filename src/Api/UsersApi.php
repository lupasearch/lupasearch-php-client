<?php

declare(strict_types=1);

namespace LupaSearch\Api;

use GuzzleHttp\Utils;
use GuzzleHttp\Psr7\Query;
use LupaSearch\LupaClientInterface;

class UsersApi
{
    /**
     * @var LupaClientInterface
     */
    private $client;

    public function __construct(LupaClientInterface $client)
    {
        $this->client = $client;
    }

    public function getOrganizationUsers(string $organizationSlug, array $queryParams = []): array
    {
        $query = Query::build($queryParams);

        return $this->client->send(
            LupaClientInterface::METHOD_GET,
            LupaClientInterface::API_BASE_PATH . "/organizations/$organizationSlug/users" . ($query ? "?{$query}" : ''),
            true
        );
    }

    public function createOrganizationUser(string $organizationSlug, array $httpBody): array
    {
        return $this->client->send(
            LupaClientInterface::METHOD_POST,
            LupaClientInterface::API_BASE_PATH . "/organizations/$organizationSlug/users",
            true,
            Utils::jsonEncode($httpBody)
        );
    }

    public function updateOrganizationUser(string $organizationSlug, string $userId, array $httpBody): array
    {
        return $this->client->send(
            LupaClientInterface::METHOD_POST,
            LupaClientInterface::API_BASE_PATH . "/organizations/$organizationSlug/users/$userId",
            true,
            Utils::jsonEncode($httpBody)
        );
    }

    public function deleteOrganizationUser(string $organizationSlug, string $userId): array
    {
        return $this->client->send(
            LupaClientInterface::METHOD_DELETE,
            LupaClientInterface::API_BASE_PATH . "/organizations/$organizationSlug/users/$userId",
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
            LupaClientInterface::METHOD_GET,
            LupaClientInterface::API_BASE_PATH . '/users/me',
            true
        );
    }
}
