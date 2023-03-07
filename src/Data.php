<?php

declare(strict_types=1);

namespace Uvarats\Dto;

use Uvarats\Dto\Contract\Arrayable;
use Uvarats\Dto\Contract\DataInterface;
use Uvarats\Dto\Exception\ConstructorMissingException;
use Uvarats\Dto\Exception\IncorrectTypeException;
use Uvarats\Dto\Exception\NotTypedPropertyException;
use Uvarats\Dto\Exception\PropertyMissingException;
use Uvarats\Dto\Factory\DataFactory;

class Data implements DataInterface, Arrayable
{
    /**
     * @param array $data
     * @return Data
     * @throws ConstructorMissingException
     * @throws IncorrectTypeException
     * @throws NotTypedPropertyException
     * @throws PropertyMissingException
     * @throws \ReflectionException
     */
    public static function from(array $data): static
    {
        $factory = new DataFactory(static::class, $data);

        /** @var Data $object */
        $object = $factory->create();
        return $object;
    }


    /**
     * @param array $data
     * @return static[]
     * @throws ConstructorMissingException
     * @throws IncorrectTypeException
     * @throws NotTypedPropertyException
     * @throws PropertyMissingException
     * @throws \ReflectionException
     */
    public static function collection(array $data): array
    {
        $objects = [];

        foreach ($data as $objectData) {
            $objects[] = static::from($objectData);
        }

        return $objects;
    }

    public function toArray(): array
    {
        $properties = get_object_vars($this);

        $data = [];

        foreach ($properties as $key => $value) {
            $data[$key] = $this->resolveValue($value);
        }

        return $data;
    }

    private function resolveValue(mixed $value): mixed
    {
        if ($value instanceof \BackedEnum) {
            return $value->value;
        }

        if ($value instanceof Data) {
            return $value->toArray();
        }

        return $value;
    }
}