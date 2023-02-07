<?php

declare(strict_types=1);

namespace LupaSearch\Handler;

use GuzzleHttp\Exception\ClientException;
use LupaSearch\Exceptions\ApiException;
use LupaSearch\Exceptions\AuthenticationException;
use LupaSearch\Exceptions\BadRequestException;
use LupaSearch\Exceptions\NotFoundException;
use LupaSearch\Utils\JsonUtils;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Throwable;

use function is_string;

class RequestErrorHandler implements ErrorHandlerInterface
{
    public function handle(Throwable $throwable): void
    {
        switch ($throwable->getCode()) {
            case 400:
                throw new BadRequestException($this->parseMessage($throwable));
            case 401:
                throw new AuthenticationException($this->parseMessage($throwable));
            case 404:
                throw new NotFoundException($this->parseMessage($throwable));
            default:
                throw new ApiException($throwable->getMessage());
        }
    }

    public function parseMessage(Throwable $throwable): string
    {
        if ($throwable instanceof ClientException) {
            /** @var ResponseInterface $response */
            $response = $throwable->getResponse();
            $body = (string)$response->getBody();
            $json = JsonUtils::jsonDecode($body, true);

            return isset($json['errors']) ? implode(
                '. ',
                array_map(static function ($error) {
                    return is_string($error) ? $error : (isset($error['message']) ? $error['message'] : 'Unknown error');
                }, $json['errors'])
            ) : '';
        }

        return 'Unknown error: ' . $throwable->getMessage();
    }
}
