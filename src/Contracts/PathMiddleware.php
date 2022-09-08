<?php

namespace Shanginn\LaravelOpenApi\Contracts;

use GoldSpecDigital\ObjectOrientedOAS\Objects\PathItem;
use Shanginn\LaravelOpenApi\RouteInformation;

interface PathMiddleware
{
    public function before(RouteInformation $routeInformation): void;

    public function after(PathItem $pathItem): PathItem;
}
