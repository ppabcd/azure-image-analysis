<?php
require "vendor/autoload.php";

use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use MicrosoftAzure\Storage\Common\Exceptions\ServiceException;
use MicrosoftAzure\Storage\Blob\Models\ListBlobsOptions;
use MicrosoftAzure\Storage\Blob\Models\CreateContainerOptions;
use MicrosoftAzure\Storage\Blob\Models\PublicAccessType;
use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/.env');

$connectionString = "DefaultEndpointsProtocol=https;AccountName=".$_ENV['ACCOUNT_NAME'].";AccountKey=".$_ENV['ACCOUNT_KEY'];

// Create blob client.
$blobClient = BlobRestProxy::createBlobService($connectionString);

function response($data){
    echo json_encode($data);
    die();
}
// var_dump($_FILES['gambar']);
// Process File upload
if(!isset($_FILES['gambar'])){
    $data = [
        "message" => 'Please select a file before upload a file',
        "status" => 'error',
    ];
    response($data);
}
$name = $_FILES['gambar']['name'];
$tmp_name = $_FILES['gambar']['tmp_name'];

var_dump($_FILES);
move_uploaded_file($tmp_name, __DIR__.'/upload/'.$name);
$fileToUpload = $name;
// Create container options object.
$createContainerOptions = new CreateContainerOptions();
// Set public access policy. Possible values are
// PublicAccessType::CONTAINER_AND_BLOBS and PublicAccessType::BLOBS_ONLY.
// CONTAINER_AND_BLOBS:
// Specifies full public read access for container and blob data.
// proxys can enumerate blobs within the container via anonymous
// request, but cannot enumerate containers within the storage account.
//
// BLOBS_ONLY:
// Specifies public read access for blobs. Blob data within this
// container can be read via anonymous request, but container data is not
// available. proxys cannot enumerate blobs within the container via
// anonymous request.
// If this value is not specified in the request, container data is
// private to the account owner.
$createContainerOptions->setPublicAccess(PublicAccessType::CONTAINER_AND_BLOBS);
// Set container metadata.
$createContainerOptions->addMetaData("key1", "value1");
$createContainerOptions->addMetaData("key2", "value2");
$containerName = "blockblobs";
try {
    // Getting local file so that we can upload it to Azure
    $myfile = fopen($fileToUpload, "w") or die("Unable to open file!");
    fclose($myfile);
    
    $content = fopen($fileToUpload, "r");
    //Upload blob
    $blobClient->createBlockBlob($containerName, $fileToUpload, $content);

}
catch(ServiceException $e){
    // Handle exception based on error codes and messages.
    // Error codes and messages are here:
    // http://msdn.microsoft.com/library/azure/dd179439.aspx
    $code = $e->getCode();
    $error_message = $e->getMessage();
    echo $code.": ".$error_message."<br />";
}
catch(InvalidArgumentTypeException $e){
    // Handle exception based on error codes and messages.
    // Error codes and messages are here:
    // http://msdn.microsoft.com/library/azure/dd179439.aspx
    $code = $e->getCode();
    $error_message = $e->getMessage();
    echo $code.": ".$error_message."<br />";
}
