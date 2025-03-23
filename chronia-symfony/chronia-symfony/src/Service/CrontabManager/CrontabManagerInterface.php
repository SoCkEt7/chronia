<?php

namespace App\Service\CrontabManager;

interface CrontabManagerInterface
{
    /**
     * Get all crontab entries
     *
     * @return array Array of crontab entries
     */
    public function getEntries(): array;
    
    /**
     * Add a new crontab entry
     *
     * @param string $schedule The cron schedule expression
     * @param string $command The command to execute
     * @return bool Success status
     */
    public function addEntry(string $schedule, string $command): bool;
    
    /**
     * Update an existing crontab entry
     *
     * @param int $id The entry ID to update
     * @param string $schedule The new cron schedule expression
     * @param string $command The new command to execute
     * @return bool Success status
     */
    public function updateEntry(int $id, string $schedule, string $command): bool;
    
    /**
     * Delete a crontab entry
     *
     * @param int $id The entry ID to delete
     * @return bool Success status
     */
    public function deleteEntry(int $id): bool;
    
    /**
     * Toggle the active state of a crontab entry
     *
     * @param int $id The entry ID to toggle
     * @param bool $active Whether the entry should be active
     * @return bool Success status
     */
    public function toggleEntryActive(int $id, bool $active): bool;
    
    /**
     * Test run a crontab entry
     *
     * @param int $id The entry ID to test
     * @return array|false Test result or false on failure
     */
    public function testRun(int $id);
    
    /**
     * Calculate the next run times for a crontab entry
     *
     * @param string $schedule The cron schedule expression
     * @param int $count Number of occurrences to calculate
     * @return array Array of next run times
     */
    public function getNextRunTimes(string $schedule, int $count = 5): array;
}