<?php
$error = "";
$results = "";
$file_content = "";

$lastname = trim($_POST['lastname'] ?? '');
$firstname = trim($_POST['firstname'] ?? '');
$group = trim($_POST['group'] ?? '');
$variant = 9;

function calculateFunction($x, $y, $z)
{
    return (($y / $x) + pow(sin(pow($y, 3/2)), 2)) + pow(log(pow($z, 0.3)), 2);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($lastname)) $error .= "Не введено прізвище<br>";
    if (empty($firstname)) $error .= "Не введено ім'я<br>";
    if (empty($group)) $error .= "Не введено групу<br>";

    if (!empty($error)) {
        $error = "<div style='color:red;'>$error</div>";
    } else {
        $X_start = 1.23 * $variant;
        $X_end = $X_start + 10;
        $step = 1;
        $Y = 4.6 * $variant;
        $Z = 36.6 / $variant;
        
        
        $filename = "{$lastname}.txt";
        $file = fopen($filename, "w") or die("Неможливо відкрити файл!");

        fwrite($file, "Дані студента:\n");
        fwrite($file, "Прізвище: $lastname\n");
        fwrite($file, "Ім'я: $firstname\n");
        fwrite($file, "Група: $group\n\n");
        fwrite($file, "Результати обчислень (варіант $variant):\n");
        fwrite($file, "Y = $Y\n");
        fwrite($file, "Z = $Z\n\n");
        fwrite($file, "X\tf(X,Y,Z)\n");
        fwrite($file, "----------------\n");

        for ($x = $X_start; $x <= $X_end; $x += $step) {
            $result = calculateFunction($x, $Y, $Z);
            fwrite($file, sprintf("%.2f\t%.4f\n", $x, $result));
        }
        fclose($file);

        $results = "<h3>Результати обчислень:</h3><table border='1'>";
        $results .= "<tr><td>Прізвище:</td><td>$lastname</td></tr>";
        $results .= "<tr><td>Ім'я:</td><td>$firstname</td></tr>";
        $results .= "<tr><td>Група:</td><td>$group</td></tr>";
        $results .= "<tr><td>Номер варіанту:</td><td>$variant</td></tr>";
        $results .= "<tr><td>Початкове X:</td><td>$X_start</td></tr>";
        $results .= "<tr><td>Кінцеве X:</td><td>$X_end</td></tr>";
        $results .= "<tr><td>Y:</td><td>$Y</td></tr>";
        $results .= "<tr><td>Z:</td><td>$Z</td></tr>";
        $results .= "</table>";

        $file_content = "<h3>Вміст файлу $filename:</h3><pre>" . htmlspecialchars(file_get_contents($filename)) . "</pre>";
    }
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Лабораторна робота 19 (Варіант 9)</title>
    <style>
        table { border-collapse: collapse; margin-bottom: 20px; }
        td { padding: 5px 10px; border: 1px solid #ccc; }
        pre { background: #f5f5f5; padding: 10px; border: 1px solid #ddd; }
    </style>
</head>
<body>
    <h1>Лабораторна робота №19</h1>
    <h2>Робота з файлами засобами PHP (Варіант 9)</h2>
    
    <form method="post">
        <h3>Введіть ваші дані:</h3>
        <table>
            <tr>
                <td>Прізвище:</td>
                <td><input type="text" name="lastname" value="<?= htmlspecialchars($lastname ?? '') ?>"></td>
            </tr>
            <tr>
                <td>Ім'я:</td>
                <td><input type="text" name="firstname" value="<?= htmlspecialchars($firstname ?? '') ?>"></td>
            </tr>
            <tr>
                <td>Група:</td>
                <td><input type="text" name="group" value="<?= htmlspecialchars($group ?? '') ?>"></td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" value="Обчислити та зберегти"></td>
            </tr>
        </table>
    </form>

    <?= $error ?? '' ?>
    <?= $results ?? '' ?>
    <?= $file_content ?? '' ?>
</body>
</html>
