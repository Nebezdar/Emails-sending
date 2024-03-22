<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<hr>
<form action="/reading" method="post" enctype="multipart/form-data">
    @csrf
    <input type="file" name="file" />
    <button type="submit">Загрузить файл</button>

</form>
<hr>
<p>
    Данный сервис позволяет загрузить емейлы в список рассылки Мейлганер
</p>
<p>
    Для того, чтобы все заработало, необходимо загрузить файл формата .CSV, у которго в столбце А будет список емейлов
</p>
<img src="{{ asset('/emails.png') }}">
<p>
    После загрузки файла, произойдет недолгая обработка, затем емейлы добавятся в список
</p>

</body>
</html>
