# Simple DTO library for PHP 8 constructor-promoted properties.

Supported:
- Dto populating
- Enum properties
- Array of Dto

Usage: extend Data class by your DTO.

Then just create DTO object via YourDto::from($data) where $data is your array with data.
This array must have same mapping as class fields (no 'data' at the root of array).

Example:
```php
final readonly class LoginDto extends Data 
{
    public function __construct(
        public ?string $username = null,
        public ?string $password = null,
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
```

Also supported nested data and enums:
```php
final readonly class ExampleDto extends Data
{

}
```

Will be continued.
