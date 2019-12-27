<?php
/**
 * Automatsiertes erstellen und Versenden von Rechnungen per Gsales 2 API
 * 
 */
ini_set("soap.wsdl_cache_enabled", "0"); 

$strAPIKey = '<API-Keys>'; 
$strApiWsdlUrl = 'http://<Gsales-Domain>/api/api.php?wsdl'; 

$client = new soapclient($strApiWsdlUrl);  
$arrCount = $client->processContractsRepayable($strAPIKey);
if ($arrCount['result'] > 0){
    $arrayOfInvoices = $client->createInvoicesFromQueueForAll($strAPIKey); 
    foreach ((array)$arrayOfInvoices['result'] as $key => $objInvoice){ 
        $arrFilterMailspool[] = array('field'=>'sub_recordset_id', 'operator'=>'is', 'value'=>$objInvoice->base->id); 
        $arrFilterMailspool[] = array('field'=>'sub', 'operator'=>'is', 'value'=>'subinvoice'); 
        $arrSortMailspool = array('field'=>'created', 'direction'=>'asc'); 
        $arrMailspoolEntries = $client->getMailspoolEntries($strAPIKey, $arrFilterMailspool, $arrSortMailspool,999,0); 
        if (isset($arrMailspoolEntries['result']['0'])){ 
            $client->setMailspoolSendApprovalForEntry($strAPIKey, $arrMailspoolEntries['result']['0']->id); 
            unset($arrFilterMailspool, $arrSortMailspool, $arrMailspoolEntries); 
        }
    } 
    //Mailpool Absenden
    $client->sendMailspool($strAPIKey); 
} 