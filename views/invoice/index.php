<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Transactions</title>
        <style>
            table {
                width: 100%;
                border-collapse: collapse;
                text-align: center;
            }

            table tr th, table tr td {
                padding: 5px;
                border: 1px #eee solid;
            }

            tfoot tr th, tfoot tr td {
                font-size: 20px;
            }

            tfoot tr th {
                text-align: right;
            }
        </style>
    </head>
    <body>
        <a href="/">Home</a>
        <br>
        <a href="/invoice/upload">Upload Invoice</a>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Check #</th>
                    <th>Description</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($params['transactions'])): ?>
                    <?php foreach ($params['transactions'] as $transaction): ?>
                        <tr>
                            <td><?= \App\Models\Invoice::formatDate('M d, Y', $transaction['timestamp']) ?></td>
                            <td><?= $transaction['checkNum'] ?></td>
                            <td><?= $transaction['description'] ?></td>
                            <td>
                                <span style="color: <?= ($transaction['amount'] >= 0) ? 'green' : 'red' ?>">
                                    <?= \App\Models\Invoice::formatDollarAmount($transaction['amount']) ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach ?>
                <?php endif ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">Total Income:</th>
                    <td><?= \App\Models\Invoice::formatDollarAmount($params['income']) ?? '$0' ?></td>
                </tr>
                <tr>
                    <th colspan="3">Total Expense:</th>
                    <td><?= \App\Models\Invoice::formatDollarAmount($params['expense']) ?? '$0' ?></td>
                </tr>
                <tr>
                    <th colspan="3">Net Total:</th>
                    <td><?= \App\Models\Invoice::formatDollarAmount($params['total']) ?? '$0' ?></td>
                </tr>
            </tfoot>
        </table>
    </body>
</html>
