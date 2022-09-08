<?php

namespace Shanginn\LaravelOpenApi\Factories;

use GoldSpecDigital\ObjectOrientedOAS\Objects\SecurityScheme;

abstract class SecuritySchemeFactory
{
    abstract public function build(): SecurityScheme;
}
