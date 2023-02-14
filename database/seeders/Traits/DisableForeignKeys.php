<?php

namespace Database\Seeders\Traits;

use Illuminate\Support\Facades\DB;

trait DisableForeignKeys
{
    /**
     * @var array
     */
    private $commands = [
        'mysql' => [
            'enable' => 'SET FOREIGN_KEY_CHECKS=1;',
            'disable' => 'SET FOREIGN_KEY_CHECKS=0;',
        ],
        'sqlite' => [
            'enable' => 'PRAGMA foreign_keys = ON;',
            'disable' => 'PRAGMA foreign_keys = OFF;',
        ],
        'sqlsrv' => [
            'enable' => 'EXEC sp_msforeachtable @command1="print \'?\'", @command2="ALTER TABLE ? WITH CHECK CHECK CONSTRAINT all";',
            'disable' => 'EXEC sp_msforeachtable "ALTER TABLE ? NOCHECK CONSTRAINT all";',
        ],
        'pgsql' => [
            'enable' => 'SET CONSTRAINTS ALL IMMEDIATE;',
            'disable' => 'SET CONSTRAINTS ALL DEFERRED;',
        ],
    ];

    /**
     * Disable foreign key checks for current db driver.
     */
    protected function disableForeignKeys(): void
    {
        DB::statement($this->getDisableStatement());
    }

    /**
     * Enable foreign key checks for current db driver.
     */
    protected function enableForeignKeys(): void
    {
        DB::statement($this->getEnableStatement());
    }

    /**
     * Return current driver enable command.
     */
    private function getEnableStatement(): string
    {
        return $this->getDriverCommands()['enable'];
    }

    /**
     * Return current driver disable command.
     *
     * @return mixed
     */
    private function getDisableStatement(): string
    {
        return $this->getDriverCommands()['disable'];
    }

    /**
     * Returns command array for current db driver.
     */
    private function getDriverCommands(): array
    {
        return $this->commands[DB::getDriverName()];
    }
}
