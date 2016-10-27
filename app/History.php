<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $fillable = [
    	"object",
    	"metadata",
    	"issuer"
    ];

    protected $hidden = [
    	"created_at",
    	"updated_at"
    ];
}
