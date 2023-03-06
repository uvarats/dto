# Lightweight DTO library for PHP 8 constructor-promoted properties.

Initially this package was developed for internal use, but then I was decided to publish.


Install:

```
composer require uvarats/dto
```

Requirements: 
PHP 8.2

Supported:
- DTO populating
- Enum properties
- Array of DTO

# Usage: 

Just extend Data class by your DTO.

Then just create DTO object via YourDto::from($data) where $data is your array with data.
This array must have same mapping as class fields (no 'data' at the root of array).

Example:
```php
final class LoginDto extends Data 
{
    public function __construct(
        public readonly ?string $username = null,
        public readonly ?string $password = null,
    ) 
    {
    }
}
```

Then: 
```php
$data = [
    'username' => 'some_user',
    'password' => '123456'
];

$dto = LoginDto::from($data);

// Collection 

$data = [
    [
        'username' => 'some_user',
        'password' => '123456'
    ],
    [
        'username' => 'some_user',
        'password' => '123456'
    ],
];

$dtos = LoginDto::collection($data);
```

Also supported nested data and enums:
```php
enum State: string 
{
    case NEW = 'new';
    case UNDER_MODERATION = 'under_moderation';
    case PUBLISHED = 'published';
}

final class AuthorDto extends Data 
{
    public function __construct(
        public readonly string $userId,
        public readonly string $username,
    ) 
    {
    }
}

final class ExampleDto extends Data
{
    public function __construct(
        public readonly string $name,
        public readonly State $state,
        public readonly AuthorDto $author
    ) 
    {
    }
}
```

```php
$data = [
    'name' => 'Some name',
    'state' => 'new',
    'author' => [
        'userId' => '232',
        'username' => 'user',    
    ]
];
```

If not nullable property without default value does not present in array, an exception will be thrown.
Constructor properties must be strictly typed. Union and intersection are prohibited.

```php
final class TestDto extends Data
{
    public function __construct(
        public $name,                           // Exception
        public string|array $id,                // Exception
        public callable&iterable $caliterable   // Also exception
    ) 
    {
    }
}
```