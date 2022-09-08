<?php

namespace Shanginn\LaravelOpenApi\Attributes;

use Attribute;
use Illuminate\Foundation\Http\FormRequest;
use InvalidArgumentException;
use Ramsey\Uuid\Uuid;
use Shanginn\LaravelOpenApi\Builders\Components\FormRequestBodiesBuilder;
use Shanginn\LaravelOpenApi\Factories\RequestBodyFactory;

#[Attribute(Attribute::TARGET_METHOD)]
class FormRequestBody
{
//    public function __construct()
//    {
//        $this->factory = Uuid::uuid4()->toString();
//
//        if (!is_subclass_of($formRequestClassName, FormRequest::class)) {
//            throw new \InvalidArgumentException(
//                sprintf(
//                    'Class %s must be a subclass of %s',
//                    $formRequestClassName,
//                    FormRequest::class
//                )
//            );
//        }
//
//        app()->bind(
//            $this->factory,
//            fn () => new FormRequestBodiesBuilder(new $formRequestClassName())
//        );
//    }
}
