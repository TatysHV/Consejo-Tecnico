<?php

header('Content-type: application/x-msexcel; charset=UTF-8'); 
header("Content-Disposition: attachment; filename=Tabla_Acuerdos.xls");  
header("Pragma: no-cache"); 
header("Expires: 0");


include "conexion.php";
 //MySQL Table Name   
$year = date("Y");
/*******YOU DO NOT NEED TO EDIT ANYTHING BELOW THIS LINE*******/    
//create MySQL connection   
$sql = "SELECT id,titulo,acuerdo,etiqueta, estatus, tipo, numero_sesion, fecha_acta, observaciones FROM acuerdos WHERE year(fecha_acta) = '$year'";
$result = mysqli_query($con,$sql) or die('Error al consultar acuerdos');
//header info for browser  

/*******Start of Formatting for Excel*******/   
//define separator (defines columns in excel & tabs in word)
$sep = "\t"; //tabbed character
//start of printing column names as names of MySQL fields
$cant = mysqli_num_fields($result);

for ($i = 0; $i < $cant; $i++) {
	//$fieldName = mysqli_fetch_field_direct($result, $i)->name;
echo mysqli_fetch_field_direct($result, $i)->name . "\t";
}
print("\n");    
//end of printing column names  
//start while loop to get data
    while($row = mysqli_fetch_row($result))
    {
        $schema_insert = "";
        $cantidad = mysqli_num_fields($result);
       
        for($j=0; $j<$cantidad;$j++)
        {
            if(!isset($row[$j]))
                $schema_insert .= "NULL".$sep;
            elseif ($row[$j] != "")
                $schema_insert .= "$row[$j]".$sep;
            else
                $schema_insert .= "".$sep;
        }
        $schema_insert = str_replace($sep."$", "", $schema_insert);
        $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
        $schema_insert .= "\t";
        print(utf8_decode(trim($schema_insert)));
        print "\n";
    }
?>

