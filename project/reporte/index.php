<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../css/estilo2.css">

</head>

<body>

    <section class="home">

        <div class="content">
            <h3>¡CONSULTA NUESTRO MENÚ!</h3>
            <p>Te invitamos a vivir una experiencia única escaneando nuestro menú en formato QR. Solo necesitas seguir
                estos sencillos pasos:
                <br>
                Abre la cámara de tu dispositivo móvil.<br>
                Apunta la cámara hacia el código QR que se encuentra en tu mesa o en algún lugar visible.<br>
                Espera unos segundos mientras tu dispositivo escanea el código.<br>
                Una vez escaneado, se abrirá automáticamente nuestro menú digital en tu navegador.<br>
                Explora nuestra amplia variedad de bebidas, comidas y postres deliciosos.<br>
                ¡No te quedes con las ganas! Atrévete a escanear nuestro menú en QR y sumérgete en una experiencia
                gastronómica única en nuestra cafetería.<br>

                ¡Te esperamos con los brazos abiertos y el mejor café de la ciudad!





            </p>
            <?php
            //Agregamos la libreria para genera códigos QR
            require "phpqrcode/qrlib.php";

            //Declaramos una carpeta temporal para guardar la imagenes generadas
            $dir = 'temp/';

            //Si no existe la carpeta la creamos
            if (!file_exists($dir))
                mkdir($dir);

            //Declaramos la ruta y nombre del archivo a generar
            $filename = $dir . 'test.png';

            //Parametros de Condiguración
            
            $tamaño = 5; //Tamaño de Pixel
            $level = 'L'; //Precisión Baja
            $framSize = 2; //Tamaño en blanco
            $contenido = "https://drive.google.com/file/d/1TCOIPv_XWXA1pIszN_8vEMCcIih2E_ho/view?usp=sharing"; //Texto
            
            //Enviamos los parametros a la Función para generar código QR 
            QRcode::png($contenido, $filename, $level, $tamaño, $framSize);

            //Mostramos la imagen generada
            echo '<img src="' . $dir . basename($filename) . '" /><hr/>';
            ?>
        </div>

    </section>




</body>

</html>