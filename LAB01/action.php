<?php

$start_time = microtime(true);
$r = $_POST['r'];
$x = $_POST['x'];
$y = $_POST['y'];
$response = "";
$cookie_name = "response";

function validate_X($x): bool {
    if (is_numeric($x) && in_array($x, ["-3", "-2", "-1", "0", "1", "2", "3", "4", "5"])) return true;
    else return false;
}

function validate_Y($y): bool {
    if (is_numeric($y) && strlen($y) <= 12 ) {
        if (-3 <= $y && $y <= 5)  return true;
        else return false;
    } else return false;
}

function validate_R($r): bool {
    if (is_numeric($r) && strlen($r) <= 12 ) {
        if (1 <= $r && $r <= 4)  return $r;
        else return false;
    } else return false;
}

function check_data($x, $y, $r): string{
    if ((($x * $x + $y * $y) <= $r * $r / 4 && $x <= 0 && $y <= 0) ||
        ($y + (1/2) * $x <= $r/2 && $x >= 0 && $y >= 0) ||
        ($x <= 0 && $y >= 0 && $x >= (-1) * $r / 2 && $y <= $r)) {
        return "Входит";
    } else {
        return "Не входит";
    }
}

function fill_data($x, $y, $r): array {
    $y = strtr ($y, array (',' => '.'));
    $r = strtr ($r, array (',' => '.'));
    if (!validate_X($x)) $x = "invalid data";
    if (!validate_Y($y)) $y = "invalid data";
    if (!validate_R($r)) $r = "invalid data";
    if (is_numeric($x) && is_numeric($y) && is_numeric($r)) $out = check_data($x, $y, $r);
    else $out = "Данные некорректны";
    return array('x' => $x, 'y' => $y, 'r' => $r, 'result' => $out,
        'current_time' => date("Y-m-d H:i:s"));
}

//проверяем на сессию на существование
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

//проверка на наличие массива $_SESSION["response"]
if (!isset($_SESSION["response"])) {
    $_SESSION["response"] = array();
}

//создаём массив со строковыми индексами
$new_arr = fill_data($x, $y, $r);
$new_arr['computing_time'] = microtime(true) - $start_time;
$_SESSION["response"][] = $new_arr;

//html страница с результатом
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Result</title>
    <link rel="stylesheet" href="request_style.css">
    <!--<link rel="stylesheet" href="css/result.css"> -->
</head>
<body>
<div id="result">
<table class="result-table">
    <tr>
        <th>X</th>
        <th>Y</th>
        <th>R</th>
        <th>RESULT</th>
        <th>Current time</th>
        <th>Computation time</th>
    </tr>
    <?php
    $max=sizeof($_SESSION["response"]);
    $i = 0;
    // печатать только последние 20 измерений
    if ($max > 20) $i = $max - 20;
    for(; $i<$max; $i++) {
        echo "<tr>";
        echo "<td>" . $_SESSION["response"][$i]["x"] . "</td>";
        echo "<td>" . $_SESSION["response"][$i]["y"] . "</td>";
        echo "<td>" . $_SESSION["response"][$i]["r"] . "</td>";
        echo "<td>" . $_SESSION["response"][$i]["result"] . "</td>";
        echo "<td>" . $_SESSION["response"][$i]["current_time"] . "</td>";
        echo "<td>" . $_SESSION["response"][$i]["computing_time"] . "</td>";
        echo "<tr>";
    }
    ?>
</table>
<script src="validation.js"></script>
</div>
</body>
</html>
