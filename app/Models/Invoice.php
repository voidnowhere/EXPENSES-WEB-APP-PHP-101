<?php

declare(strict_types=1);

namespace App\Models;

class Invoice extends Model
{
    public function getTransactions(): array
    {
        return $this->db->query('SELECT * from invoice')->fetchAll();
    }

    public function getIncome(): float
    {
        return $this->db->query('SELECT SUM(amount) AS income from invoice WHERE amount >= 0')->fetch()['income'] ?? 0;
    }

    public function getExpense(): float
    {
        return $this->db->query('SELECT SUM(amount) AS expense from invoice WHERE amount < 0')->fetch()['expense'] ?? 0;
    }

    public static function formatDollarAmount(float $amount): string
    {
        $isNegative = $amount < 0;

        return ($isNegative ? '-' : '') . '$' . number_format(abs($amount), 2);
    }

    public static function formatDate(string $format, int $date): string
    {
        return date($format, $date);
    }

    public function createFromFiles(array $files): bool
    {
        $transactions = $this->getTransactionsFromFiles($files);

        $stmt = $this->db->prepare('INSERT INTO invoice VALUES(NULL, :timestamp, :checkNum, :description, :amount)');
        foreach ($transactions as $transaction) {
            $stmt->execute([
                'timestamp' => $transaction['timestamp'],
                'checkNum' => $transaction['checkNum'],
                'description' => $transaction['description'],
                'amount' => $transaction['amount'],
            ]);
        }
        return !empty($transactions);
    }

    private function getTransactionsFromFiles(array $files): array
    {
        $transactions = [];
        $invoicesPaths = $this->getUploadedInvoicesPaths($files);

        if ($invoicesPaths[0] === '') {
            return $transactions;
        }

        foreach ($invoicesPaths as $invoicePath) {
            $file = fopen($invoicePath, 'r');
            fgetcsv($file);

            while ($transaction = fgetcsv($file)) {
                $transactions[] = [
                    'timestamp' => $this->getUnixTimestamp('m/d/Y', $transaction[0]),
                    'checkNum' => $transaction[1],
                    'description' => $transaction[2],
                    'amount' => $this->parseTransactionAmount($transaction[3])
                ];
            }

            fclose($file);
        }

        return $transactions;
    }

    private function getUploadedInvoicesPaths(array $files): array
    {
        return $files['receipt']['tmp_name'];
    }

    private function parseTransactionAmount(string $amount): float
    {
        return (float)str_replace([',', '$'], '', $amount);
    }

    private function getUnixTimestamp(string $dateFormat, string $date): int
    {
        return \DateTime::createFromFormat($dateFormat, $date)->getTimestamp();
    }
}
