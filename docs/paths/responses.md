# Responses

In order to create response use this Artisan command:

```bash
php artisan openapi:make-response ListUsers
```

This will create `ResponseFactory` object which you may use to construct a response:

```php
class ListUsersResponse extends ResponseFactory
{
    public function build(): Response
    {
        return Response::ok()->description('Successful response');
    }
}
```

Finally, add `Response` attribute with factory name to your route:

```php
use Shanginn\LaravelOpenApi\Attributes as OpenApi;

class UserController extends Controller
{
    /**
     * List users.
    */
    #[OpenApi\Operation]
    #[OpenApi\Response(factory: ListUsersResponse::class)]
    public function index(User $user)
    {
        //
    }
}
```

## Reusable responses

Responses can be reusable. Adding `Shanginn\LaravelOpenApi\Contracts\Reusable` will indicate that it should be added to `components/responses` section and reference will be used instead of response definition.
This can be handy for validation errors object:

```php
use Shanginn\LaravelOpenApi\Contracts\Reusable;

class ErrorValidationResponse extends ResponseFactory implements Reusable
{
    public function build(): Response
    {
        $response = Schema::object()->properties(
            Schema::string('message')->example('The given data was invalid.'),
            Schema::object('errors')
                ->additionalProperties(
                    Schema::array()->items(Schema::string())
                )
                ->example(['field' => ['Something is wrong with this field!']])
        );

        return Response::create('ErrorValidation')
            ->description('Validation errors')
            ->content(
                MediaType::json()->schema($response)
            );
    }
}
```

And in controller's method:

```php
use Shanginn\LaravelOpenApi\Attributes as OpenApi;

class UserController extends Controller
{
    /**
     * Create user.
    */
    #[OpenApi\Operation]
    #[OpenApi\Response(factory: ErrorValidationResponse::class, statusCode: 422)]
    public function store(Request $request)
    {
        //
    }
}
```

## Multiple responses

You can use multiple responses on a single controller method (for example, success, not found, and validation errors).

Even if the schema defines a status code, you **must** supply the status code in the controller method attributes, or only one response will be included in the result.

Example:

```php
use Shanginn\LaravelOpenApi\Attributes as OpenApi;

class UserController extends Controller
{
    /**
     * Create user.
    */
    #[OpenApi\Operation]
    #[OpenApi\Response(factory: CreatedUserResponse::class, statusCode: 201)]
    #[OpenApi\Response(factory: ErrorUnauthenticatedResponse::class, statusCode: 401)]
    #[OpenApi\Response(factory: ErrorForbiddenResponse::class, statusCode: 401)]
    #[OpenApi\Response(factory: ErrorNotFoundResponse::class, statusCode: 404)]
    #[OpenApi\Response(factory: ErrorValidationResponse::class, statusCode: 422)]
    public function store(Request $request)
    {
        //
    }
}
```
