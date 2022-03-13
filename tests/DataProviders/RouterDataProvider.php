<?php

declare(strict_types=1);

namespace Tests\DataProviders;

class RouterDataProvider
{
    public function routeNotFoundCases(): array
    {
        return [
            ['/users', 'POST'],
            ['/users/delete', 'GET']
        ];
    }
}
