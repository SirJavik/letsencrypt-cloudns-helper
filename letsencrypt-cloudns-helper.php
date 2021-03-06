#!/usr/bin/php

<?php

/* 
 * Copyright (c) 2018, javik
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *
 * * Redistributions of source code must retain the above copyright notice, this
 *   list of conditions and the following disclaimer.
 * * Redistributions in binary form must reproduce the above copyright notice,
 *   this list of conditions and the following disclaimer in the documentation
 *   and/or other materials provided with the distribution.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 */

require(__DIR__.'/vendor/autoload.php');
require(__DIR__.'/config.inc.php');

use lecdh\ClouDNS;
use lecdh\LECDH;
use lecdh\Exception\RecordNotCreatedException;
use lecdh\Exception\RecordNotDeletedException;

$cloudns = new ClouDNS();
$lecdh   = new LECDH();

$domainName         = getenv("CERTBOT_DOMAIN");
$validationString   = getenv("CERTBOT_VALIDATION");

foreach ($argv as $argument) {
    if($argument == '-v' or $argument == '--version') {
        $lecdh->echo('letsencrypt-cloudns-helper v'.$lecdh->getVersion());
        return 0;
        
    } elseif($argument == '-h' or $argument == '--help') {
        $lecdh->getHelp();
        return 0;
        
    } elseif($argument == '--auth') {
        try {
            if(!$cloudns->createRecord($domainName, 'TXT', '_acme-challenge', $validationString)) {
                throw new RecordNotCreatedException();
            }
        } catch (RecordNotCreatedException $e) {
            echo $e->getMessage(), PHP_EOL;
            die();
        }
        $lecdh->echo("TXT DNS Record for Domain $domainName with host _acme-challenge which contains \"$validationString\" has been created sucessfully");
        
        $end = false;
        $count = 1;
        
        while(!$end) {
            $lecdh->echo("Waitig for ClouDNS to become updated... [$count]");    
            if($cloudns->isUpdated($domainName)=="true") {
                $lecdh->echo("ClouDNS is updated. [$count tries]");   
                $end = true;
                break;
            }
            $count++;
            sleep(30);
            
        }
        return 0;
        
    } elseif ($argument == '--cleanup') {
        $records = json_decode($cloudns->listRecords($domainName, 'TXT', '_acme-challenge'), true);
        
        
        foreach($records as $record) {
            try {
                if(!$cloudns->deleteRecord($domainName, $record['id'])) {
                    throw new RecordNotDeletedException();
                }
            } catch (RecordNotCreatedException $e) {
                echo $e->getMessage(), PHP_EOL;
                die();
            }
                $lecdh->echo("TXT DNS Record for Domain $domainName with host _acme-challenge which contains \"$validationString\" has been deleted sucessfully");
            }
    }
}

