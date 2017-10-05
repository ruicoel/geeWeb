<?php
require_once '../models/DatabaseConnection.php';
require_once '../models/Local.php';

function parseToXML($htmlStr)
{
    $xmlStr=str_replace('<','&lt;',$htmlStr);
    $xmlStr=str_replace('>','&gt;',$xmlStr);
    $xmlStr=str_replace('"','&quot;',$xmlStr);
    $xmlStr=str_replace("'",'&#39;',$xmlStr);
    $xmlStr=str_replace("&",'&amp;',$xmlStr);
    return $xmlStr;
}


$db     = DatabaseConnection::conexao();
$stmt   = $db->query("SELECT nome, descricao, ponto[0] AS pontox, ponto[1] AS pontoy FROM gee.local");

header("Content-type: text/xml");

// Start XML file, echo parent node
echo '<markers>';

// Iterate through the rows, printing XML nodes for each
foreach ($stmt as $row){
    // Add to XML document node
    echo '<marker ';
    echo 'nome="'       . parseToXML($row['nome']) . '" ';
    echo 'descricao="'  . parseToXML($row['descricao']) . '" ';
    echo 'lat="'        . $row['pontox'] . '" ';
    echo 'lng="'        . $row['pontoy'] . '" ';
    echo '/>';
}

// End XML file
echo '</markers>';

?>