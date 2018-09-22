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

namespace lecdh;
use lecdh\Exception\FileNotFoundException;

/**
 * Description of ClouDNS
 *
 * @author javik
 */
class ClouDNS {
    public function __construct() {
        try {
            if(!file_exists(__DIR__."/../config.inc.php")) {
                throw new FileNotFoundException(null, 0, null, "config.inc.php");
            }
        } catch (FileNotFoundException $e) {
            echo $e->getMessage(), PHP_EOL;
        }
    }
    
    public function __destruct() {
        ;
    }
    
    public function listRecords($domainName, $type = null, $host = null) {
        global $config;
        
        $url = "https://api.cloudns.net/dns/records.json";
        $postRequest = [
            'auth-id'       => $config['ClouDNS']['auth-id'],
            'auth-password' => $config['ClouDNS']['auth-password'],
            'domain-name'   => $domainName
        ];
        
        if($type != null) {
            $postRequest['type'] = $type;
        }
        
        if($host != null) {
            $postRequest['host'] = $host;
        }
        
        $curl = \curl_init($url);
        
        
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, 'libClouDNS v1.0.0 (https://javik.net)');
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postRequest);
        
        $content = curl_exec($curl); 
        
        return $content;
    }
    
    public function deleteRecord($domainName, $recordID) {
        global $config;
        
        $url = "https://api.cloudns.net/dns/delete-record.json";
        $postRequest = [
            'auth-id'       => $config['ClouDNS']['auth-id'],
            'auth-password' => $config['ClouDNS']['auth-password'],
            'domain-name'   => $domainName,
            'record-id'     => $recordID
        ];
        
        $curl = \curl_init($url);
        
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, 'libClouDNS v1.0.0 (https://javik.net)');
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postRequest);
        
        $content = curl_exec($curl);
        return $content;
    }
    
    public function createRecord($domainName, $recordType, $host, $record, $ttl = 3600) {
        global $config;
        
        $url = "https://api.cloudns.net/dns/add-record.json";
        $postRequest = [
            'auth-id'       => $config['ClouDNS']['auth-id'],
            'auth-password' => $config['ClouDNS']['auth-password'],
            'domain-name'   => $domainName,
            'record-type'   => $recordType,
            'host'          => $host,
            'record'        => $record,
            'ttl'           => $ttl
        ];
        
        $curl = \curl_init($url);
        
        
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, 'libClouDNS v1.0.0 (https://javik.net)');
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postRequest);
        
        $content = curl_exec($curl); 
        
        return $content;
    }
}
