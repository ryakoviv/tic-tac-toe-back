<?php

declare(strict_types=1);

namespace App\Exception;

use Phpro\ApiProblemBundle\Transformer\ExceptionTransformerInterface;
use Phpro\ApiProblem\ApiProblemInterface;
use Symfony\Component\HttpFoundation\Response;

class AppApiProblemExceptionTransformer implements ExceptionTransformerInterface
{
    /** @var array<string,int> */
    private static $exceptionToHttpCodeMap = [
        \App\Exception\NotFoundException::class => Response::HTTP_NOT_FOUND,
        \App\Exception\ConflictException::class => Response::HTTP_CONFLICT,
        \App\Exception\ServiceUnavailableException::class => Response::HTTP_SERVICE_UNAVAILABLE,
        \App\Exception\ForbiddenException::class => Response::HTTP_FORBIDDEN,
        \App\Exception\BadRequestException::class => Response::HTTP_BAD_REQUEST,
    ];

    public function transform(\Throwable $exception): ApiProblemInterface
    {
        foreach (self::$exceptionToHttpCodeMap as $exceptionClass => $httpCode) {
            if ($exception instanceof $exceptionClass) {
                return new HttpApiProblem(
                    $httpCode,
                    [
                        'reason' => $exception->getMessage()
                    ]
                );
            }
        }

        return new HttpApiProblem(
            Response::HTTP_INTERNAL_SERVER_ERROR,
            ['reason' => 'Something went wrong']
        );
    }

    public function accepts(\Throwable $exception): bool
    {
        foreach (self::$exceptionToHttpCodeMap as $exceptionClass => $httpCode) {
            if ($exception instanceof $exceptionClass) {
                return true;
            }
        }

        return false;
    }
}
