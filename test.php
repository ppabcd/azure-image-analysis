<?php
// File name
$filename = $_FILES['file']['name'];

// Valid file extensions
$valid_extensions = array("jpg","jpeg","png","pdf");

// File extension
$extension = pathinfo($filename, PATHINFO_EXTENSION);

$name = rand(1000,9999).".".$extension;
// Check extension
if(in_array(strtolower($extension),$valid_extensions) ) {

   // Upload file
   if(move_uploaded_file($_FILES['file']['tmp_name'], "upload/".$name)){
        echo json_encode(['message'=>'Success', 'name'=>$name]);
   }else{
        echo json_encode(['message'=>'Failed upload a file.']);
   }
}else{
   echo json_encode(['message'=>'Failed upload a file.']);
}