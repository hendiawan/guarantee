<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
        'find-sertifikat',
        'post-sertifikat', 
        'proses-sign', 
        'proses-sign-sb', 
        'test-curl', 
        'show-sertifikat-sb', 
        'autoSinkSb', 
        'send-message', 
    ];
}
