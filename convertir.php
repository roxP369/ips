<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body style="background-color: lavenderblush; font-family: sans-serif; font-size: small">
    <center>
    <?php
        $ip = $_POST['ip'];

        if (strpos($ip, ':') !== false) { 
            echo '<b style="font-size: medium">Es IP v6</b> <br><br>';
            
            if (strpos($ip, '::') !== false) {
                // Contar cuántos bloques ya hay (separados por ":")
                $bloques = explode(':', $ip);
                $faltan = 8 - count(array_filter($bloques)); // Contar bloques no vacíos

                // Expansión precisa de "::" a la cantidad correcta de bloques "0000"
                $ip = str_replace('::', ':' . str_repeat('0000:', $faltan), $ip);
            }

            // Separar por los ":" para obtener los bloques
            $sepa = explode(':', $ip); 
            $bin = []; 
            $oct = [];

            for ($i = 0; $i < count($sepa); $i++) {
                if (!empty($sepa[$i])) {
                    $decimal = hexdec($sepa[$i]); 

                    // Conversión manual a binario
                    $binario = '';
                    do {
                        $residuo = $decimal % 2; 
                        $binario = (string)$residuo . $binario; 
                        $decimal = intval($decimal / 2); 
                    } while ($decimal > 0);
                    $binario = str_pad($binario, 16, "0", STR_PAD_LEFT); // Rellenar a 16 bits
                    $bin[] = $binario;

                    // Conversión manual a octal
                    $decimal = hexdec($sepa[$i]); // Volver a convertir para octal
                    $octal = '';
                    do {
                        $residuo = $decimal % 8; 
                        $octal = (string)$residuo . $octal; 
                        $decimal = intval($decimal / 8); 
                    } while ($decimal > 0);
                    $octal = str_pad($octal, 6, "0", STR_PAD_LEFT); // Rellenar a 6 dígitos
                    $oct[] = $octal;
                } else {
                    // Si el bloque está vacío, añadir ceros
                    $bin[] = str_pad('', 16, "0", STR_PAD_LEFT);
                    $oct[] = str_pad('', 6, "0", STR_PAD_LEFT);
                }
            }

            // Mostrar los resultados
            echo "<b>En binario</b> <br>";
            for ($i = 0; $i < count($bin); $i++) {
                echo $sepa[$i] . " -> " . $bin[$i] . "<br>";
            }
            echo "<b><br>En octal</b> <br>";
            for ($i = 0; $i < count($oct); $i++) {
                echo $sepa[$i] . " -> " . $oct[$i] . "<br>";
            }
        } else {
            // IPv4
            echo '<b style="font-size: medium">Es IP v4</b> <br><br>';
            $sepa = explode('.', $ip); // Separar en octetos
            $bin = []; 
            $oct = [];
            $hexa = [];

            for ($i = 0; $i < count($sepa); $i++) {
                $decimal = intval($sepa[$i]);

                // Conversión manual a binario
                $binario = '';
                do {
                    $residuo = $decimal % 2; 
                    $binario = (string)$residuo . $binario; 
                    $decimal = intval($decimal / 2); 
                } while ($decimal > 0);
                $binario = str_pad($binario, 8, "0", STR_PAD_LEFT); // Rellenar a 8 bits
                $bin[] = $binario;

                // Conversión a octal
                $decimal = intval($sepa[$i]);
                $octal = '';
                do {
                    $residuo = $decimal % 8;
                    $octal = (string)$residuo . $octal; 
                    $decimal = intval($decimal / 8); 
                } while ($decimal > 0);
                $oct[] = $octal;

                // Conversión a hexadecimal
                $decimal = intval($sepa[$i]);
                $hexadecimal = '';
                do {
                    $residuo = $decimal % 16;
                    $hexadecimal = dechex($residuo) . $hexadecimal; 
                    $decimal = intval($decimal / 16); 
                } while ($decimal > 0);
                $hexa[] = str_pad($hexadecimal, 2, "0", STR_PAD_LEFT);
            }

            // Mostrar los resultados
            echo '<b>En binario</b> <br>';
            for ($i = 0; $i < count($sepa); $i++) {
                echo $sepa[$i] . " -> " . $bin[$i] . "<br>";
            }

            echo '<b><br>En octal</b> <br>';
            for ($i = 0; $i < count($sepa); $i++) {
                echo $sepa[$i] . " -> " . $oct[$i] . "<br>";
            }

            echo '<b><br>En hexadecimal</b> <br>';
            for ($i = 0; $i < count($sepa); $i++) {
                echo $sepa[$i] . " -> " . $hexa[$i] . "<br>";
            }
        }
    ?>

</body>
</html>
