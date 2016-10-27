<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

class JsonResponseProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Response::macro( 'success', function( $payload = null, $status = 200, $metadata = [], $headers = [] ){
            $data = [
                'result' => 'success'
            ];
            if( $payload )
                $data[ 'payload' ] = $payload;
            $data = array_merge( $data, $metadata );
            return Response::json( $data, $status )->withHeaders( $headers );
        });
        Response::macro( 'fail', function( $payload = null, $status = 400, $metadata = [], $headers = [] ){
            $data = [
                'result' => 'fail'
            ];
            if( $payload )
                $data[ 'errors' ] = $payload;
            $data = array_merge( $data, $metadata );
            return Response::json( $data, $status )->withHeaders( $headers );
        });
        
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
