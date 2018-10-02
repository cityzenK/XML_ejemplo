<?php

$nombre = $_POST["nombre"];
$apellido = $_POST["apellido"];
$edad = $_POST["edad"];


header('Content-Type: text/plain');
//Guardamos los datos en un array
$datos = array(
'title' => 'Informacion de usuario.',
'user'  => array(array('estado' => 'ok','nombre' => $nombre, 'apellido' => $apellido, 'edad' => $edad))
);

function createXML($datos){
    $title = $datos['title'];
    $rowCount = count($datos['user']);

    //Creamos el documentos xml
    $xmlDoc = new DOMDocument();

    $root = $xmlDoc->appendChild($xmlDoc->CreateElement("user_info"));
    $root->appendChild($xmlDoc->createElement("title",$title));
    $root->appendChild($xmlDoc->createElement("totalRows",$rowCount));
    $tabUsers = $root->appendChild($xmlDoc->createElement('rows'));

    foreach($datos['user'] as $user){
        if(!empty($user)){
            $tabUsers = $tabUsers->appendChild($xmlDoc->createElement('user'));
            foreach($user as $key=>$val){
                $tabUsers->appendChild($xmlDoc->createElement($key, $val));
            }
        }
    }

    header("Content-Type: text/plain");

    $xmlDoc->formatOutput = true;

    $file_name = str_replace(' ','_',$title).'.xml';
    $xmlDoc->save("files/" . $file_name);

    return $file_name;
}

echo createXML($datos);


//abrir y pasar el archivo xml
$path = "files/Informacion_de_usuario..xml";

$xmlfile = file_get_contents($path);

$xml = simplexml_load_string($xmlfile);

$json = json_encode($xml);

$xmlArr = json_decode($json,true);


print_r($xmlArr);
echo json_encode($datos, JSON_FORCE_OBJECT);
?>