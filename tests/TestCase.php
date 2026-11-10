<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();

        if (config('database.default') === 'sqlite' || DB::connection()->getDriverName() === 'sqlite') {
            $pdo = DB::connection()->getPdo();
            if ($pdo instanceof \PDO && method_exists($pdo, 'sqliteCreateFunction')) {
                $pdo->sqliteCreateFunction('MONTH', function ($date) {
                    return $date ? (int) date('m', strtotime($date)) : null;
                });
                $pdo->sqliteCreateFunction('YEAR', function ($date) {
                    return $date ? (int) date('Y', strtotime($date)) : null;
                });
            }
        }
    }
}
