<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    const STATUS_OK = "ok";

    protected $fillable = [
    	"name",
    	"path",
    	"status",
    	"metadata",
    	"issuer"
    ];

    protected $hidden = [
    	"status",
    	"metadata",
    	"created_at",
    	"updated_at"
    ];

    public function episodes(){
    	return $this->hasMany( "App\Episode" );
    }
}
