<?php

namespace Shanginn\LaravelOpenApi\Builders\Components;

use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationRuleParser;
use Shanginn\LaravelOpenApi\Factories\RequestBodyFactory;

class FormRequestBodiesBuilder extends RequestBodyFactory
{
    public function __construct(public readonly FormRequest $request)
    {
    }

    public function build(): RequestBody
    {
        $requestRules = (new ValidationRuleParser([]))
            ->explode(app()->call([$this->request, 'rules']))
            ->rules;

        $body = RequestBody::create();

        $object = Schema::object(get_class($this->request));
        $properties = [];
        $required = [];

        foreach ($requestRules as $attribute => $rules) {
            $property = Schema::string($attribute);
            if (in_array('required', $rules, true)) {
                $required[] = $attribute;
            }

            $properties[] = $property;
        }

        return $body->content(
            MediaType::json()->schema(
                $object
                    ->properties(...$properties)
                    ->required(...$required)
            )
        );
    }
}
