<?php

declare(strict_types=1);

namespace Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class FunctionalTest extends KernelTestCase
{
    protected TestHelper $testHelper;

    protected function setUp(): void
    {
        $this->testHelper = static::getContainer()->get('test.test_helper');
        $this->testHelper->clearDatabase();

        parent::setUp();
    }

    protected function tearDown(): void
    {
        $this->testHelper->clearDatabase();

        parent::tearDown();
    }
}
