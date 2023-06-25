<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Agendamento de Consulta</title>
</head>

<body>
    <h3>Agendamento de consulta</h3>
    <p>Sua consulta foi agendada! Confira os dados e anote a data para não esquecer:</p>
    <p>Dentista reponsável: {{ $dentist->name }}</p>
    <p>Procedimento: {{ $procedure }}</p>
    <p>Horário: {{ $date }} - {{ $time }}</p>
</body>

</html>
