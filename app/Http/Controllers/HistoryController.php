<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Validator;

use App\History;

use Illuminate\Database\Eloquent\ModelNotFoundException;

class HistoryController extends Controller
{

	private function getStoreRequirements(){
        return [
            'object' => 'required|max:255|unique:histories',
            'metadata' => 'max:1000',
            'issuer' => 'required|max:255'
        ];
    }

    private function getUpdateRequirements(){
        return [
            'object' => 'max:255|unique:histories',
            'metadata' => 'max:1000',
            'issuer' => 'max:255'
        ];
    }

    public function indexById( Request $request, $id ){
    	try{
            $history = History::findOrFail( $id );
            return response()->success( $history );
        }catch( ModelNotFoundException $e ){
            return response()->fail( null, 404 );
        }
    }

    public function indexByObject( Request $request, $object ){
    	try{
            $history = History::where( compact( 'object' ) )->get()->toArray();
            if( !$history )
                throw new ModelNotFoundException;
            return response()->success( $history );
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
            $creation = History::create( $data );
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
                $history = History::findOrFail( $id );
                $update = $history->fill( $data );
                $updated = $history->save();
                return response()->success( $update );   
            }
        }catch( ModelNotFoundException $e ){
            return response()->fail( null, 404 );
        }
    }

    public function destroy($id)
    {
        try{
            $history = History::findOrFail( $id );
            $history->delete();
            return response()->success();
        }catch( ModelNotFoundException $e ){
            return response()->fail( null, 404 );
        }
    }
}
