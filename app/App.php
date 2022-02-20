<?php
    declare(strict_types=1);

    function getTransactionFiles(string $dirPath): array{
        $files = [];

        foreach (scandir($dirPath) as $file){
            if(is_dir($file)){
                continue;
            }

            $files[] = $dirPath . $file;
        }

        return $files;
    }

    function getTransactions(string $fileName, ?callable $transactionHandler = null): array{
        if(!file_exists($fileName)){
            trigger_error('File "' . $fileName . '" does not exist.', E_USER_ERROR);
        }

        $file = fopen($fileName, 'r');
        fgetcsv($file);

        $transactions = [];
        while ($transaction = fgetcsv($file)){
            if ($transactionHandler !== null){
                $transaction = $transactionHandler($transaction);
            }
            $transactions[] = $transaction;
        }

        fclose($file);

        return $transactions;
    }

    function extractTransaction(array $transactionRow): array{
        [$date, $checkNumber, $description, $amount] = $transactionRow;
        $amount = (float)str_replace(['$', ','], '', $amount);

        return [
            'date' => $date,
            'checkNumber' => $checkNumber,
            'description' => $description,
            'amount' => $amount
        ];
    }

    function calculateTotals(array $transactions): array{
        $totals = ['income' => 0, 'expense' => 0, 'net' => 0];

        foreach ($transactions as $transaction){
            $totals['net'] += $transaction['amount'];

            if ($transaction['amount'] >= 0){
                $totals['income'] += $transaction['amount'];
            }
            else{
                $totals['expense'] += $transaction['amount'];
            }
        }

        return $totals;
    }