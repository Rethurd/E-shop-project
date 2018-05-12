<?php

session_start();

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

function debug_to_console( $data ) {
    $output = $data;
    if ( is_array( $output ) )
        $output = implode( ',', $output);

    echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
}
$file = 'data/adminlist.xlsx';
$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

//simple read and write test
$admins=[];
$potentialAdmins = $spreadsheet->getActiveSheet()->rangeToArray('A1:A10');
for ($i=0;$i<count($potentialAdmins);$i++)
{
    if($potentialAdmins[$i][0]!='')
    {
        array_push($admins,$potentialAdmins[$i][0]);
        $coord='B'.($i+1);
        $spreadsheet->getActiveSheet()->setCellValue($coord, base64_encode($potentialAdmins[$i][0]));
        $writer->save("data/adminlist.xlsx");
    }
    
}

//if user logged in, check if admin
if(isset($_SESSION['logged-in']))
{
    if(in_array($_SESSION['email'],$admins))
    {
        $_SESSION['adminAccount']=true;
    }
}

//print_r($admins);
//creating an array of admins:


?>