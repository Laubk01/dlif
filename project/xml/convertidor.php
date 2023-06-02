<?php 
$archivoXML = "prueba.xml";
$contenido = file_get_contents($archivoXML);
$contenido = str_replace(array("\n", "\r", "\t"), '',$contenido);
$contenido = trim(str_replace('"',"'",$contenido));
$stringXML = simplexml_load_string($contenido);
$json = json_encode($stringXML);
print_r($json);

$archivo = fopen('archivo.json', 'w+');
fwrite($archivo, $json . PHP_EOL);

fclose($archivo);
?>