<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    const STATUS_OK = 'ok';
    const STATUS_PRELOADED = 'cached';

    protected $fillable = [
    	"name",
    	"path",
    	"url",
    	"headers",
    	"template",
    	"status",
    	"metadata",
    	"issuer",
    	"collection_id"
    ];

    protected $hidden = [
    ];

    public function collection(){
    	return $this->belongsTo( "App\Collection" );
    }
}
