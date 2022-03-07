<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <a href="/">Home</a>
    <br>
    <a href="/invoice">Invoice</a>
    <br>
    <?= ($params['created'] ?? false) ? 'Invoices have been stored in db' : '' ?>
    <br>
    <form action="/invoice/upload" method="post" enctype="multipart/form-data">
        <input type="file" name="receipt[]" multiple>
        <br>
        <input type="submit" name="submit">
    </form>
</body>
</html>
