<?php
ob_start();
session_start();
include('../init.php');
$pid = $_POST['id'];

$objProduct = load_class('Product');
$objImage=load_class("ProductGallery");
$objType = load_class('Type');
$objFeatures = load_class('Features');
$objCity = load_class('City');
$objContact = load_class('Contactaddress');

$row = $objProduct->GetRowContent($pid);
$row2 = $objProduct->GetRowGallery($pid);
if($row['user_id'] == 1){
	$getContact = $objContact->GetRowContent(1);
	$contactemail = $getContact['email'];
	$contactnumber = $getContact['tel'];
}else {
	$GetUser = $objUser->GetRowContent($row['user_id']);	
	$contactemail = $GetUser['email'];
	$contactnumber = $GetUser['telephone'];
}
//pre($row);

$domDocument = new DOMDocument(); //Create xml DOMDocument.
if(file_exists ( '../multimedia/xml_file/feed.xml' )){
	$domDocument->load("../multimedia/xml_file/feed.xml", LIBXML_NOBLANKS);
	$dubizzl = $domDocument->getElementsByTagName('dubizzlepropertyfeed')->item(0);  
}else{
	//create Main elements
	$dubizzl = $domDocument->appendChild($domDocument->createElement('dubizzlepropertyfeed'));
}
$property = $dubizzl->appendChild($domDocument->createElement('property'));

// Append the elements to the Main Elements
$property->appendChild($domDocument->createElement('status','deleted'));

if($row['purpose'] == 'SELL'){
	$type = 'SP';
}else if($row['purpose'] == 'RENT'){
	$type = 'RP';
}
$property->appendChild($domDocument->createElement('type',$type));

$type = $objType->GetRowContent($row['tid']);
$subtype = $type['d_code'];
$property->appendChild($domDocument->createElement('subtype',$subtype));

if($row['tid'] == 13)
	$commercialtype = $row['commer_type'];
else 
	$commercialtype="";
$property->appendChild($domDocument->createElement('commercialtype',$commercialtype));

$refno = $row['id'];
$property->appendChild($domDocument->createElement('refno',$refno));

$title = $row['title'];
$property->appendChild($domDocument->createElement('title',$title));

$description = $row['description'];
$property->appendChild($domDocument->createElement('description',$description));

$size = $row['sft'];
$property->appendChild($domDocument->createElement('size',$size));

$sizeunits = 'SqFt';
$property->appendChild($domDocument->createElement('sizeunits',$sizeunits));

$price = $row['price'];
$property->appendChild($domDocument->createElement('price',$price));

$pricecurrency = 'AED';
$property->appendChild($domDocument->createElement('pricecurrency',$pricecurrency));

$bedrooms = $row['bedroom'];
$property->appendChild($domDocument->createElement('bedrooms',$bedrooms));

$bathrooms = $row['bathroom'];
$property->appendChild($domDocument->createElement('bathrooms',$bathrooms));

$lastupdated = $row['update_on'];
$property->appendChild($domDocument->createElement('lastupdated',$lastupdated));

$property->appendChild($domDocument->createElement('contactemail',$contactemail));
$property->appendChild($domDocument->createElement('contactnumber',$contactnumber));

$city = $objCity->GetRowContent($row['city']);
$property->appendChild($domDocument->createElement('city',$city['title']));

$locationtext = $row['location'];
$property->appendChild($domDocument->createElement('locationtext',$locationtext));

$array_fet = explode("/",$row['features']);
foreach($array_fet as $fe_id){
	$featureslist = $objFeatures->GetRowContent($fe_id); 
	$ft_array[] = $featureslist['d_code'];
}
$privateamenities = implode("|",$ft_array);
$property->appendChild($domDocument->createElement('privateamenities',$privateamenities));

$geopoint = $row['cityLat'].','.$row['cityLng'];
$property->appendChild($domDocument->createElement('geopoint',$geopoint));

foreach($row2 as $img){
	$image[] = $_SERVER['SERVER_NAME']."/global/multimedia/product_gallery/".$img['thumb'];
}
$photos = implode("|",$image);
$property->appendChild($domDocument->createElement('photos',$photos));

//to see the full output of the document 
$domDocument->formatOutput = true;
if($domDocument->save('../multimedia/xml_file/feed.xml')){ // save as file
	echo "done";
}
?>