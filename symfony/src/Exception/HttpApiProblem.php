<?php

declare(strict_types=1);

namespace App\Exception;

use Phpro\ApiProblem\ApiProblemInterface;

class HttpApiProblem implements ApiProblemInterface
{
    /**
     * @var array
     */
    private $data;

    public function __construct(int $statusCode, array $data)
    {
        $this->data = array_merge(
            [
                'status' => $statusCode,
                'reason' => '',
            ],
            $data
        );
    }

    public function toArray(): array
    {
        return $this->data;
    }
}
