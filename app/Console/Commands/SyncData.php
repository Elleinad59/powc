<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SyncData extends Command
{
    protected $signature = 'sync:data';
    protected $description = 'Sync data between crm_4 and crm_1 databases';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $tables = [
            'client_info_sheet' => ['client_id', 'company_name'],
            'item_master' => ['item_id', 'item_name'],
            'purchase_order' => ['purchase_order_id', 'po_number', 'date'],
            'po_items' => ['po_item_id', 'po_id', 'item', 'quantity'],
            'sales_order' => ['sales_order_id', 'SO_number', 'date', 'client', 'po_no'],
            'so_items' => ['so_item_id', 'so_id', 'item', 'quantity']
        ];

        foreach ($tables as $table => $columns) {
            $this->syncTable($table, $columns);
        }

        $this->info('Data synchronization complete.');
    }

    private function syncTable($table, $columns)
    {
        $page = 1;
        $perPage = 1000; // Number of records per batch

        do {
            $data = DB::connection('crm_4')->table($table)
                ->select($columns)
                ->forPage($page, $perPage) // Fetch data in batches
                ->get();

            foreach ($data as $row) {
                $rowArray = (array) $row;

                if (empty($rowArray[$columns[0]])) {
                    continue; // Skip rows with missing primary key
                }

                if (isset($rowArray['quantity'])) {
                    $rowArray['quantity'] = is_numeric($rowArray['quantity']) ? (int) $rowArray['quantity'] : 0;
                }

                // Check if the row exists in crm_1
                $existingRow = DB::connection('crm_1')->table($table)
                    ->where($columns[0], $rowArray[$columns[0]])
                    ->first();

                if ($existingRow) {
                    // Compare existing row with the current row from crm_4
                    $existingRowArray = (array) $existingRow;
                    if (array_diff_assoc($rowArray, $existingRowArray)) {
                        // Update the row if there are differences
                        DB::connection('crm_1')->table($table)
                            ->where($columns[0], $rowArray[$columns[0]])
                            ->update($rowArray);
                    }
                } else {
                    // Insert the row if it does not exist
                    DB::connection('crm_1')->table($table)->insert($rowArray);
                }
            }

            $page++;
        } while ($data->count() > 0);

        $this->info('Synchronized table: ' . $table);
    }
}
