<?php

namespace OperationGpt\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class OperationExecutor
{
    public function execute(array $parsed): array
    {
        $loggingEnabled = config('operation-gpt.logging', true);

        try {
            if ($parsed['type'] === 'action') {
                DB::beginTransaction();
                $results = [];

                foreach ($parsed['operations'] as $op) {
                    $table = $op['table'] ?? null;
                    $action = $op['action'] ?? null;
                    $data = $op['data'] ?? [];
                    $where = $op['where'] ?? [];

                    // 1. Validate Table
                    $allowedTables = config('operation-gpt.allowed_tables');
                    if (!isset($allowedTables[$table])) {
                        throw new \Exception("Table '{$table}' is not authorized for operations.");
                    }

                    // 2. Validate/Filter Columns
                    $allowedColumns = $allowedTables[$table];
                    $data = array_intersect_key($data, array_flip($allowedColumns));

                    // 3. Auto-hash Passwords
                    if (isset($data['password'])) {
                        $data['password'] = Hash::make((string)$data['password']);
                    }

                    // 4. Execute
                    switch ($action) {
                        case 'insert':
                            $id = DB::table($table)->insertGetId($data);
                            $results[] = ["action" => "insert", "id" => $id];
                            break;
                        case 'update':
                            $affected = DB::table($table)->where($where)->update($data);
                            $results[] = ["action" => "update", "affected" => $affected];
                            break;
                        default:
                            throw new \Exception("Action '{$action}' is not supported.");
                    }

                    if ($loggingEnabled) {
                        Log::info("OperationGpt: Executed {$action} on {$table}", ['data' => $data, 'where' => $where]);
                    }
                }

                DB::commit();

                return [
                    'type' => 'action',
                    'message' => 'Successfully completed the requested operations.',
                    'data' => $results,
                ];
            }

            if ($parsed['type'] === 'report') {
                $table = $parsed['table'] ?? null;
                $columns = $parsed['columns'] ?? ['*'];
                $filters = $parsed['filters'] ?? [];

                // 1. Validate Table
                $allowedTables = config('operation-gpt.allowed_tables');
                if (!isset($allowedTables[$table])) {
                    throw new \Exception("Table '{$table}' is not authorized for reporting.");
                }

                // 2. Filter Columns
                $allowedColumns = $allowedTables[$table];
                if ($columns === ['*']) {
                    $columns = $allowedColumns;
                } else {
                    $columns = array_intersect($columns, $allowedColumns);
                }

                if (empty($columns)) {
                    throw new \Exception("No valid columns requested for table '{$table}'.");
                }

                // 3. Build Query
                $query = DB::table($table)->select($columns);

                foreach ($filters as $col => $val) {
                    if (in_array($col, $allowedColumns)) {
                        $query->where($col, $val);
                    }
                }

                $data = $query->limit(100)->get();

                if ($loggingEnabled) {
                    Log::info("OperationGpt: Generated report for {$table}", ['filters' => $filters]);
                }

                return [
                    'type' => 'report',
                    'message' => 'Report generated accurately.',
                    'data' => $data,
                ];
            }

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('OperationGpt Execution Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'parsed' => $parsed
            ]);

            return [
                'type' => 'error',
                'message' => $e->getMessage(),
            ];
        }

        return [
            'type' => 'error',
            'message' => 'The system could not determine the type of operation to perform.',
        ];
    }
}