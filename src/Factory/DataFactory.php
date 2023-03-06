<?php

declare(strict_types=1);

namespace Uvarats\Dto\Factory;

use ReflectionParameter;
use Uvarats\Dto\Data;
use Uvarats\Dto\Exception\ConstructorMissingException;
use Uvarats\Dto\Exception\IncorrectTypeException;
use Uvarats\Dto\Exception\NotTypedPropertyException;
use Uvarats\Dto\Exception\PropertyMissingException;

final readonly class DataFactory
{
    public function __construct(
        private string $class,
        private array $data
    )
    {
    }

    /**
     * @return object
     * @throws ConstructorMissingException
     * @throws IncorrectTypeException
     * @throws NotTypedPropertyException
     * @throws PropertyMissingException
     * @throws \ReflectionException
     */
    public function create(): object
    {
        return $this->innerCreate($this->data);
    }

    /**
     * @param array $data
     * @return object
     * @throws ConstructorMissingException
     * @throws IncorrectTypeException
     * @throws NotTypedPropertyException
     * @throws PropertyMissingException
     * @throws \ReflectionException
     */
    private function innerCreate(array $data): object
    {
        $class = new \ReflectionClass($this->class);
        $constructor = $class->getConstructor();

        if ($constructor === null) {
            throw new ConstructorMissingException();
        }

        $params = $this->getConstructorParams($constructor);

        return $class->newInstanceArgs($params);
    }

    /**
     * @throws PropertyMissingException
     * @throws IncorrectTypeException
     * @throws NotTypedPropertyException
     * @throws ConstructorMissingException
     */
    private function getConstructorParams(\ReflectionMethod $constructor): array
    {
        $parameters = $constructor->getParameters();
        $instanceParams = [];

        foreach ($parameters as $parameter) {
            $name = $parameter->getName();

            $instanceParams[$name] = $this->resolveParameter($parameter);
        }

        return $instanceParams;
    }

    /**
     * @throws NotTypedPropertyException
     * @throws ConstructorMissingException
     * @throws IncorrectTypeException
     * @throws PropertyMissingException
     */
    private function resolveParameter(ReflectionParameter $parameter): mixed
    {
        $name = $parameter->getName();
        $type = $parameter->getType();

        if ($type === null) {
            throw new NotTypedPropertyException($name);
        }

        if (!isset($this->data[$name])) {
            if ($parameter->isDefaultValueAvailable()) {
                return $parameter->getDefaultValue();
            }

            if ($parameter->allowsNull()) {
                return null;
            }

            throw new PropertyMissingException();
        }

        if (!$type instanceof \ReflectionNamedType) {
            throw new IncorrectTypeException();
        }

        $typeName = $type->getName();

        if (is_subclass_of($typeName, \BackedEnum::class)) {
            return $typeName::from($this->data[$name]);
        }

        if (is_subclass_of($typeName, Data::class)) {
            return $typeName::from($this->data[$name]);
        }

        return $this->data[$name];
    }
}