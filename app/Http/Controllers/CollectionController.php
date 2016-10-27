<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Collection;
use Validator;

use Illuminate\Database\Eloquent\ModelNotFoundException;

class CollectionController extends Controller
{

    private function getStoreRequirements(){
        return [
            'name' => 'required|max:255|unique:collections',
            'path' => 'max:255',
            'status' => 'in:ok',
            'metadata' => 'max:1000',
            'issuer' => 'required|max:255'
        ];
    }

    private function getUpdateRequirements(){
        return [
            'name' => 'max:255|unique:collections',
            'path' => 'max:255',
            'status' => 'in:ok',
            'metadata' => 'max:1000',
            'issuer' => 'max:255'
        ];
    }

    public function index( Request $request ){
        return response()->success( Collection::all() );
    }

    public function indexById( Request $request, $id )
    {
        try{
            $collection = Collection::with( 'episodes' )->findOrFail( $id );
            return response()->success( $collection );
        }catch( ModelNotFoundException $e ){
            return response()->fail( null, 404 );
        }
    }

    public function indexByStatus( Request $request, $status ){
        try{
            $collection = Collection::where( compact( 'status' ) )->get()->toArray();
            if( !$collection )
                throw new ModelNotFoundException;
            return response()->success( $collection );
        }catch( ModelNotFoundException $e ){
            return response()->fail( null, 404 );
        }
    }

    public function indexByName( Request $request, $name ){
        try{
            $collection = Collection::with( 'episodes' )->where(compact( 'name' ))->first();
            if( !$collection )
                throw new ModelNotFoundException;
            return response()->success( $collection );
        }catch( ModelNotFoundException $e ){
            return response()->fail( null, 404 );
        }
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make( $data, $this->getStoreRequirements() );
        if( $validator->fails() ){
            return response()->fail( $validator->errors() );
        }else{
            $creation = Collection::create( $data );
            return response()->success( $creation );
        }
    }

    public function update(Request $request, $id)
    {
        try{
            $data = $request->all();
            $validator = Validator::make( $data, $this->getUpdateRequirements() );
            if( $validator->fails() ){
                return response()->fail( $validator->errors() );
            }else{
                $collection = Collection::findOrFail( $id );
                $update = $collection->fill( $data );
                $updated = $collection->save();
                return response()->success( $update );   
            }
        }catch( ModelNotFoundException $e ){
            return response()->fail( null, 404 );
        }
    }

    public function destroy($id)
    {
        try{
            $collection = Collection::findOrFail( $id );
            $collection->delete();
            return response()->success();
        }catch( ModelNotFoundException $e ){
            return response()->fail( null, 404 );
        }
    }
}
