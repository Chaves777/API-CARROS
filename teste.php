<?php

if(!empty($_GET['name'])) {
    $request = file_get_contents("https://api.agify.io?name={$_GET['name']}");
    
    $response = json_decode($request, true);

    $age = $response['age'];
}

//$json = '{"nome": "Ana Luisa", "idade": 23}';

//echo $response['nome'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guess Age</title>
</head>
<body>
    <?php if(isset($age)): ?>

        Age: <?= $age ?>

    <?php endif; ?>

    <form>
        <label for="name">Name</label>

        <input type="text" name="name" id="name">

        <button type="submit">Guess Age</button>
    </form>
</body>
</html>