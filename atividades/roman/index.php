<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atividade 2.1</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #e0f7fa;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            border: 1px solid #00796b;
        }
        h1 {
            text-align: center;
            color: #004d40;
        }
        .form-group {
            text-align: center;
            margin: 20px 0;
        }
        select, input[type="text"], input[type="number"] {
            padding: 10px;
            width: 150px;
            border: 2px solid #004d40;
            border-radius: 4px;
            margin-right: 10px;
            background-color: #f1f8e9;
        }
        button {
            padding: 10px 20px;
            border: none;
            background-color: #00796b;
            color: white;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #004d40;
        }
        .result {
            text-align: center;
            font-size: 1.2em;
            margin-top: 20px;
            color: #333;
        }
    </style>
    <script>
        function updateInputPlaceholder() {
            var conversionType = document.getElementById('conversionType').value;
            var inputValue = document.getElementById('inputValue');

            if (conversionType === 'toInteger') {
                inputValue.placeholder = 'Valor em Algarismo Romano';
                inputValue.style.textTransform = 'uppercase';
                inputValue.addEventListener('input', function() {
                    inputValue.value = inputValue.value.toUpperCase();
                });
            } else {
                inputValue.placeholder = 'Valor em número inteiro';
                inputValue.style.textTransform = 'none';
                inputValue.removeEventListener('input', function() {
                    inputValue.value = inputValue.value.toUpperCase();
                });
            }
        }
    </script>
</head>
<body onload="updateInputPlaceholder()">
    <div class="container">
        <h1>Conversos de números (atividade 2.1)</h1>
        <form method="POST" action="">
            <div class="form-group">
                <label for="conversionType">Escolha uma opção:</label>
                <select id="conversionType" name="conversionType" onchange="updateInputPlaceholder()" required>
                    <option value="toRoman">Número inteiro para Algarismo Romano</option>
                    <option value="toInteger">Algarismo Romano para Número inteiro</option>
                </select>
            </div>
            <div class="form-group">
                <label for="inputValue">Insira um valor:</label>
                <input type="text" id="inputValue" name="inputValue" required>
                <button type="submit">Converter</button>
            </div>
        </form>
        <div class="result">
            <?php
                if (
                    $_SERVER['REQUEST_METHOD'] === 'POST' && 
                    isset($_POST['conversionType']) && 
                    isset($_POST['inputValue'])
                ) {
                    include __DIR__ . '/Main.php';
                        
                    $main = new Main();
                    $conversionType = $_POST['conversionType'];
                    $inputValue = $_POST['inputValue'];

                    if ($conversionType == 'toRoman') {
                        $number = intval($inputValue);
                        echo $main->romanConverter->convertToRoman($number);
                    } elseif ($conversionType == 'toInteger') {
                        echo $main->romanConverter->convertToInteger($inputValue);
                    }
                }
            ?>
        </div>
    </div>
</body>
</html>
