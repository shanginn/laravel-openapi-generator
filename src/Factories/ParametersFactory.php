<?php

namespace Shanginn\LaravelOpenApi\Factories;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Parameter;
use Shanginn\LaravelOpenApi\Concerns\Referencable;

abstract class ParametersFactory
{
    use Referencable;

    /**
     * @return Parameter[]
     */
    abstract public function build(): array;
}
