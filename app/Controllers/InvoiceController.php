<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Invoice;
use App\View;

class InvoiceController
{
    public function index(): View
    {
        $invoice = new Invoice();
        $transactions = $invoice->getTransactions();
        $income = $invoice->getIncome();
        $expense = $invoice->getExpense();
        $total = $income + $expense;
        return View::make('invoice/index', [
            'transactions' => $transactions,
            'income' => $income,
            'expense' => $expense,
            'total' => $total
        ]);
    }

    public function upload(): View
    {
        $created = null;
        if (isset($_POST['submit'])) {
            $invoice = new Invoice();
            $created = $invoice->createFromFiles($_FILES);
        }
        return View::make('invoice/upload', [
            'created' => $created
        ]);
    }
}
