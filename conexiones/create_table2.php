<?php

include "conexion.php";
 //MySQL Table Name   

$filename = "Tabla_acuerdos";         //File Name
$query = $_POST['url'];
/*******YOU DO NOT NEED TO EDIT ANYTHING BELOW THIS LINE*******/    
//create MySQL connection   
$result = mysqli_query($con,$query) or die('Error al consultar acuerdos');
$file_ending = "xls";
//header info for browser
header("Content-Type: application/xls");    
header("Content-Disposition: attachment; filename=$filename.xls");  
header("Pragma: no-cache"); 
header("Expires: 0");
/*******Start of Formatting for Excel*******/   
//define separator (defines columns in excel & tabs in word)
$sep = "\t"; //tabbed character
//start of printing column names as names of MySQL fields
$cant = mysqli_num_fields($result);
$tot = $cant - 3;
for ($i = 0; $i < $tot; $i++) {
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
        $final = $cantidad - 3;
        for($j=0; $j<$final;$j++)
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
        print(trim($schema_insert));
        print "\n";
    }
?>

