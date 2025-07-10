<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AddTimestampsToLeavesTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'leaves:add-timestamps';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add timestamp columns to the leaves table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Adding timestamp columns to leaves table...');

        try {
            // Check if columns exist first
            $columns = DB::select("SHOW COLUMNS FROM leaves");
            $columnNames = array_column($columns, 'Field');

            if (!in_array('created_at', $columnNames)) {
                DB::statement('ALTER TABLE leaves ADD created_at TIMESTAMP NULL DEFAULT NULL');
                $this->info('Added created_at column.');
            } else {
                $this->info('created_at column already exists.');
            }

            if (!in_array('updated_at', $columnNames)) {
                DB::statement('ALTER TABLE leaves ADD updated_at TIMESTAMP NULL DEFAULT NULL');
                $this->info('Added updated_at column.');
            } else {
                $this->info('updated_at column already exists.');
            }

            $this->info('Successfully added timestamp columns to the leaves table.');
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }
}
