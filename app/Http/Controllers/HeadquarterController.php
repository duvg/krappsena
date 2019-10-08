<?php

namespace App\Http\Controllers;

use App\Headquarter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HeadquarterController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $headquarter = Headquarter::all();

        return $this->showAll($headquarter, 200);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|min:3',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ( ! $validator->fails() )
        {
            $headquarter = Headquarter::create($request->all());

            return $headquarter;
        }
        else
        {
            return $validator->errors();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $headquarter = Headquarter::findOrFail($id);

        return $this->showOne($headquarter, 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $headquarter = Headquarter::findOrFail($id);

        $rules = [
            'name' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ( ! $validator->fails() )
        {
            if( $request->has('name') )
            {
                $headquarter->name = $request->name;
            }

            if( ! $headquarter->isDirty() )
            {
                return $this->error(
                    'Se debe especificar al menos un valor diferente para actualizar',
                     422);
            }

            $headquarter->save();

            return $this->showOne($headquarter);
        }
        else
        {
            return $this->error($validator->errors(), 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $headquarter = Headquarter::findOrFail($id);

        $headquarter->delete();

        return $this->showOne($headquarter, 200);
    }
}
