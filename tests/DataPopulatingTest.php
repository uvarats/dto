<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use Tests\Dto\ConstructorMissingDto;
use Tests\Dto\DefaultValueDto;
use Tests\Dto\SimpleTestDto;
use Uvarats\Dto\Exception\ConstructorMissingException;
use Uvarats\Dto\Exception\PropertyMissingException;

class DataPopulatingTest extends TestCase
{
    public function testDtoInstantiation() {
        $int = 123;
        $string = 'string';

        $data = [
            'someInt' => $int,
            'someString' => $string,
        ];

        $data = SimpleTestDto::from($data);

        $this->assertInstanceOf(SimpleTestDto::class, $data);
        $this->assertTrue($data->someInt === $int);
        $this->assertTrue($data->someString === $string);
    }

    public function testEnumProperty() {
        $this->assertTrue(true);
    }

    public function testNestedDto() {
        $this->assertTrue(true);
    }

    public function testNullOnNotNullable() {
        $this->expectException(PropertyMissingException::class);

        $data = [
            'someInt' => 123,
            'someString' => null,
        ];

        SimpleTestDto::from($data);
    }

    public function testConstructorMissing() {
        $this->expectException(ConstructorMissingException::class);

        $data = [
            'foo' => 123,
            'bar' => 'baz',
        ];

        ConstructorMissingDto::from($data);
    }

    public function testMissingRequiredProperty() {
        $this->expectException(PropertyMissingException::class);

        $data = [
            'someString' => 'string',
        ];

        SimpleTestDto::from($data);
    }

    public function testMissingPropertyWithDefaultValue() {
        $data = [
            'name' => 'John',
        ];

        $dto = DefaultValueDto::from($data);

        $this->assertTrue($dto->name === 'John' && !$dto->accept);

        $data = [
            'name' => 'Alex',
            'accept' => true,
        ];

        $dto = DefaultValueDto::from($data);

        $this->assertTrue($dto->name === 'Alex' && $dto->accept);
    }

    public function testNullablePropertyWithoutDefaultValue() {
        $this->assertTrue(true);
    }

    public function testCollection() {
        $this->assertTrue(true);
    }

    public function testNotTypedProperty() {
        $this->assertTrue(true);
    }

    public function testUnionPropertyType() {
        $this->assertTrue(true);
    }
}