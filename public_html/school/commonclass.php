<?php
include("init.php");
$objMenu = load_class('Menu');
$getHeaderMenu = $objMenu->GetHeaderMenu();
$getFooterMenu= $objMenu->GetFooterMenu();

$objSlider = load_class('Banner');
$menubanner=$objSlider->GetRowContent(1);

$objContact = load_class('Contactaddress');
$getContact = $objContact->GetRowContent(1);

$objSocialMedia = load_class('SocialMedia');
$getSocialMedia = $objSocialMedia->GetRowContent(1);

$objArticle = load_class('Article');
$getabout = $objArticle->GetRowContentByMenu(2);

$objCounrty = load_class('Country');
$getAllCountry=$objCounrty->SelectAll();

$objItem= load_class('Item');
$objSize = load_class('Size');
$objFabric= load_class('Fabric');
$objColor= load_class('Color');
$objGrade= load_class('Grade');
$objChart= load_class('Chart');

$ObjProduct= load_class('Product');
$objPdtPrice = load_class('ProductPrice');
$ObjProductGallery = load_class('ProductGallery');

$objCorporate = load_class('Corporate');
$objSchool = load_class('School');
$objSchoolGal = load_class('SchoolGal');
$objLanguage = load_class('Language');
$objUsers = load_class('Users');
$objCounrty = load_class('Country');

$objOrder=load_class('Order');
$objOrderDetails=load_class('OrderDetails');

$objEmail = load_class('Email');
$objInnBanner = load_class('InnerBanner');

$ObjHelp = load_class('Help');
$GetHelp=$ObjHelp->GetRowContent(1);
?>