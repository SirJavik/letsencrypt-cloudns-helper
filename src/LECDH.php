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

/**
 * Description of lecdhClass
 *
 * @author javik
 */
class LECDH {
    public function __construct() {
        
    }
    
    public function getHelp() {
        echo 'Usage: letsencrypt-cloudns-helper [Option]', PHP_EOL, PHP_EOL;
        echo 'Options:', PHP_EOL;
        echo '-h, --help    -   Prints this information', PHP_EOL;
        echo '-v, --version -   Returns version information of the script', PHP_EOL;
        echo '--auth        -   Runs the authentification hook', PHP_EOL;
        echo '--cleanup     -   Runs the cleanup hook', PHP_EOL;
        return 0;
    }
    
    public function echo($message) {
        echo "[LECDH] ",$message,PHP_EOL;
    }
    
    public function getVersion() {
        $vmajor = 1;
        $vminor = 0;
        $vpatch = 0;
        
        return($vmajor.".".$vminor.'.'.$vpatch);
    }
}
