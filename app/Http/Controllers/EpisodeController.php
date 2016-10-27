<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Episode;

use Validator;

use Illuminate\Database\Eloquent\ModelNotFoundException;

class EpisodeController extends Controller
{

    public function getStoreRequirements(){
        return [
            'name' => 'required|max:255',
            'path' => 'max:255',
            'url'      => 'required|max:255',
            'headers'  => 'max:1000',
            'template' => 'max:255',
            'status'   => 'in:ok',
            'metadata' => 'max:1000',
            'issuer'  => 'required|max:255',
            'collection_id' => 'exists:collections,id'
        ];
    }

    protected function getUpdateRequirements(){
        return [
            'name' => 'max:255',
            'path' => 'max:255',
            'url'      => 'max:255',
            'headers'  => 'max:1000',
            'template' => 'max:255',
            'status'   => 'in:ok,cached',
            'metadata' => 'max:1000',
            'issuer'  => 'required|max:255',
            'collection_id' => 'exists:collections,id'
        ];
    }

    public function indexById( Request $request, $id ){
        $validator = Validator::make( compact( "id" ), [
            'id'    => 'exists:episodes'
        ]);
        if( $validator->fails() ){
            return response()->fail( $validator->errors(), 404 );
        }else{
            return response()->success( Episode::find( $id ) );
        }
    }

    public function indexByStatus( Request $request, $status ){
        if( ( $validator = Validator::make( compact( "status" ), [
            'status' => 'in:'.$this->getStatusValues()
        ]))->fails() ){
            return response()->fail( $validator->errors() );
        }else if( ( $validator = Validator::make( compact( "status" ), [
            'status' => 'exists:episodes'
        ]))->fails() ){
            return response()->fail( $validator->errors(), 404 );
        }else{
            return response()->success( Episode::where( "status", $status )->get()->toArray() );
        }
    }

    public function indexByName( Request $request, $name ){
        $validator = Validator::make( compact( 'name' ), [
            'name'  => 'exists:episodes'
        ]);
        if( $validator->fails() ){
            return response()->fail( $validator->errors(), 404 );
        }else{
            return response()->success( Episode::where( "name", $name )->get()->toArray() );
        }
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make( $data, $this->getStoreRequirements());
        if( $validator->fails() ){
            return response()->fail( $validator->errors() );
        }else{
            $creation = Episode::create($data);
            return response()->success( $creation );
        }
    }

    public function update(Request $request, $id)
    {
        if( ( $validator = Validator::make( compact( 'id' ), [
            'id' => 'exists:episodes'
        ]))->fails() ){
            return response()->fail( $validator->errors(), 404);
        }
        $data = $request->all();
        $validator = Validator::make( $data, $this->getUpdateRequirements());
        if( $validator->fails() ){
            return response()->fail( $validator->errors() );
        }
        $episode = Episode::find( $id );
        $update = $episode->fill( $data );
        $updated = $episode->save();
        return response()->success( $update );
    }

    public function destroy($id)
    {
        if( ( $validator = Validator::make( compact( 'id' ), [
            'id' => 'exists:episodes'
        ]))->fails() ){
            return response()->fail( $validator->errors(), 404);
        }
        $episode = Episode::find( $id );
        $deleted = $episode->delete();
        return response()->success();
    }
}
