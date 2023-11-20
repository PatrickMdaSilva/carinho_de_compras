<?php
session_start();
require_once("../app/classes/Model.php");
require_once("../app/classes/carFood.php");

$carFood = new CarFood;
$foodInCart = $carFood->cart();

$model = new Model;

$json = file_get_contents("../app/db/alimentos.json");

$listfood = $model->arrayJSONARRAY($json);

if (isset($_SESSION['alimento'])) {

    $values = $_SESSION['alimento'];

    $listcar= $carFood->list($values, 0);
    $kcalTotal = $carFood->sumAll($values, 1) * 0.86;
    $proteinaTotal = $carFood->sumAll($values, 2);
    $lipideoTotal = $carFood->sumAll($values, 3);
    $carbohidratoTotal = $carFood->sumAll($values, 4);
}

?>
<!DOCTYPE html>
<html lang="en">
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style.css">
    <script src="assets/index.js" defer></script>
    <title>Document</title>
</head>
<body>
    <div class="wrapper">
        <div class="form">
            <form action="addFood.php">
                <div id="range-container">
                    <label for="cowbell">Peso (gramas)</label>
                    <p id="rangeValue">10</p>
                    <input type="range" name="rangeInput" id="rangeInput" value="10" min="10" max="300" step="10" oninput="updateValue()">
                </div>
                <label for="food">Alimentos:</label>
                <select class="" aria-label="Default select example" name="food" id="food">
                    <option value=""></option>
                    <?php foreach ($listfood as $index => $food) { ?>
                        <option value="|<?= $food["id"] ?>|<?= $food["alimento"] ?>|<?= $food["kcal"] ?>|<?= $food["proteina"] ?>|<?= $food["lipideo"] ?>|<?= $food["carbohidrato"] ?>|<?= $food["calcio_mg"] ?>"><?= $food["alimento"] ?></option>
                    <?php } ?>
                </select>
                <input class="sub" type="submit" value="Adicionar alimento">
            </form>
            <div class="nutrientes">
                <div class="dieta">
                    <label for="">Quantidade:</label>
                    <p id="nutri"><?= (isset($_SESSION['alimento'])) ? count($foodInCart) : ""; ?>
                </div>
                <div class="dieta">
                    <label for="">Kcal:</label>
                    <p id="nutri"><?= (isset($_SESSION['alimento'])) ? $kcalTotal : ""; ?>
                </div>     
            </div>
            <form action="delFood.php">
                <label for="delfood">Alimentos adicionados:</label>
                <select class="" aria-label="Default select example" name="delfood" id="delfood">
                    <option value=""></option>
                    <?php foreach ($listcar as $index => $car) { ?>
                        <option value="<?=$car?>"><?=$car?></option>
                    <?php } ?>
                </select>
                <input class="sub" type="submit" value="Remover alimento">
            </form>  
        </div>
        <div id="piechart_3d">
            <div class="grafico">
                <div class="pie">
                    <canvas id="pieChart" width="300" height="300"></canvas>
                </div>
                <div class="seper">
                    <div class="microvalue">
                        <label for="">Proten.(g):</label>
                        <p id="nutri"><?= (isset($_SESSION['alimento'])) ? $proteinaTotal : ""; ?>
                    </div>
                    <div class="microvalue">
                        <label for="">Gordura(g):</label>
                        <p id="nutri"><?= (isset($_SESSION['alimento'])) ? $lipideoTotal : ""; ?>
                    </div>
                    <div class="microvalue">
                        <label for="">Carbo.(g):</label>
                        <p id="nutri"><?= (isset($_SESSION['alimento'])) ? $carbohidratoTotal : ""; ?>
                    </div>
                </div>
            </div>
            <div class="legend" id="legend">
                <div class="descrip" style="background-color:#cb0303;"></div><p>Proteina</p>
                <div class="descrip" style="background-color:#17a51c ;"></div><p>Gordura</p>
                <div class="descrip" style="background-color:#067bc9;"></div><p>Carbohidrato</p>
                <p></p>
            </div>
            <form action="delFood.php">
                <input type="hidden" id="delcar" name="delcar"/>
                <input class="sub" type="submit" value="Apagar alimentos">
            </form> 
        </div>
    </div>



    <script>
        const canvas = document.getElementById('pieChart');
        const context = canvas.getContext('2d');
        const legend = document.getElementById('legend');
        
        const values = [<?=$proteinaTotal ?>, <?=$lipideoTotal ?>, <?=$carbohidratoTotal ?>]; // Valores para os segmentos
        const colors = ['#cb0303', '#17a51c ', '#067bc9']; // Cores para os segmentos
        const total = values.reduce((acc, value) => acc + value, 0);

        let startAngle = 0;

        for (let i = 0; i < values.length; i++) {
            const sliceAngle = (values[i] / total) * 2 * Math.PI;

            const centerX = canvas.width / 2;
            const centerY = canvas.height / 2;

            // Desenha o segmento
            context.beginPath();
            context.fillStyle = colors[i];
            context.moveTo(centerX, centerY);
            context.arc(centerX, centerY, canvas.width / 2, startAngle, startAngle + sliceAngle);
            context.fill();

            // Adiciona texto no centro do segmento
            const angle = startAngle + sliceAngle / 2;
            const textX = centerX + Math.cos(angle) * (canvas.width / 3.5);
            const textY = centerY + Math.sin(angle) * (canvas.height / 3.5);
            context.fillStyle = '#fff';
            context.font = '14px Arial';
            context.fillText(`${values[i]} (${((values[i] / total) * 100).toFixed(1)}%)`, textX, textY);

            startAngle += sliceAngle;
        }
    </script>
</body>
</html>
