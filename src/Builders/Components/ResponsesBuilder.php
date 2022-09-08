<?php

namespace Shanginn\LaravelOpenApi\Builders\Components;

use Shanginn\LaravelOpenApi\Contracts\Reusable;
use Shanginn\LaravelOpenApi\Factories\ResponseFactory;
use Shanginn\LaravelOpenApi\Generator;

class ResponsesBuilder extends Builder
{
    public function build(string $collection = Generator::COLLECTION_DEFAULT): array
    {
        return $this->getAllClasses($collection)
            ->filter(static function ($class) {
                return
                    is_a($class, ResponseFactory::class, true) &&
                    is_a($class, Reusable::class, true);
            })
            ->map(static function ($class) {
                /** @var ResponseFactory $instance */
                $instance = app($class);

                return $instance->build();
            })
            ->values()
            ->toArray();
    }
}
