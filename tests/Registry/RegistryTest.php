<?php

namespace TheCodingMachine\GraphQL\Controllers\Registry;

use GraphQL\Type\Definition\ObjectType;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use TheCodingMachine\GraphQL\Controllers\AbstractQueryProviderTest;
use TheCodingMachine\GraphQL\Controllers\Fixtures\TestType;
use TheCodingMachine\GraphQL\Controllers\Security\AuthorizationServiceInterface;

class RegistryTest extends AbstractQueryProviderTest
{
    private function getContainer(): ContainerInterface
    {
        return new class implements ContainerInterface {
            public function get($id)
            {
                return 'foo';
            }

            public function has($id)
            {
                return $id === 'foo';
            }
        };
    }

    public function testFromContainer()
    {
        $registry = $this->buildRegistry($this->getContainer());

        $this->assertTrue($registry->has('foo'));
        $this->assertFalse($registry->has('bar'));

        $this->assertSame('foo', $registry->get('foo'));
    }

    public function testInstantiate()
    {
        $registry = $this->buildRegistry($this->getContainer());

        $this->assertTrue($registry->has(TestType::class));
        $type = $registry->get(TestType::class);
        $this->assertInstanceOf(ObjectType::class, $type);
        $this->assertSame('Test', $type->name);
        $this->assertSame($type, $registry->get(TestType::class));
        $this->assertTrue($registry->has(TestType::class));
    }

    public function testNotFound()
    {
        $registry = $this->buildRegistry($this->getContainer());
        $this->expectException(NotFoundException::class);
        $registry->get('notfound');
    }

    /*public function testGetAuthorization()
    {
        $authorizationService = $this->createMock(AuthorizationServiceInterface::class);
        $registry = new Registry($this->getContainer(), $authorizationService);

        $this->assertSame($authorizationService, $registry->getAuthorizationService());

        $registry = new Registry($this->getContainer());

        $this->assertNull($registry->getAuthorizationService());
    }*/
}