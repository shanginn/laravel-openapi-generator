<?php

namespace Shanginn\LaravelOpenApi\Builders\Paths\Operation;

use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use Illuminate\Foundation\Http\FormRequest;
use Shanginn\LaravelOpenApi\Attributes\FormRequestBody as FormRequestBodyAttribute;
use Shanginn\LaravelOpenApi\Attributes\RequestBody as RequestBodyAttribute;
use Shanginn\LaravelOpenApi\Builders\Components\FormRequestBodiesBuilder;
use Shanginn\LaravelOpenApi\Contracts\Reusable;
use Shanginn\LaravelOpenApi\Factories\RequestBodyFactory;
use Shanginn\LaravelOpenApi\RouteInformation;

class RequestBodyBuilder
{
    public function build(RouteInformation $route): ?RequestBody
    {
        /** @var FormRequestBodyAttribute|null $formRequestBodyAttribute */
        $formRequestBodyAttribute = $route->actionAttributes
            ->first(static fn (object $attribute) => $attribute instanceof FormRequestBodyAttribute);

        if ($formRequestBodyAttribute !== null) {
            /** @var \ReflectionParameter|null $formRequestClass */
            $formRequestClass = collect($route->actionParameters)
                ->first(
                    static fn (\ReflectionParameter $parameter) => is_subclass_of(
                        $parameter->getType()->getName(),
                        FormRequest::class
                    )
                );

            if ($formRequestClass !== null) {
                $formRequestClassName = $formRequestClass->getType()->getName();

                return (new FormRequestBodiesBuilder(
                    new $formRequestClassName()
                ))->build();
            }
        }

        /** @var RequestBodyAttribute|null $requestBody */
        $requestBodyAttribute = $route->actionAttributes->first(
            static fn (object $attribute) => $attribute instanceof RequestBodyAttribute
        );

        if ($requestBodyAttribute) {
            /** @var RequestBodyFactory $requestBodyFactory */
            $requestBodyFactory = app($requestBodyAttribute->factory);

            $requestBody = $requestBodyFactory->build();

            if ($requestBodyFactory instanceof Reusable) {
                return RequestBody::ref('#/components/requestBodies/'.$requestBody->objectId);
            }

            return $requestBody;
        }

        return null;
    }
}
