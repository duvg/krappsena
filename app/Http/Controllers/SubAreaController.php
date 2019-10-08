<?php

namespace App\Http\Controllers;

use App\SubArea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubAreaController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ambients = SubArea::all();
        return $this->showAll($ambients);
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
            'name' => 'required|min:5|max:100',
            'code' => 'required|min:2|max:10',
            'description' => 'required',
            'area' => 'required'
        ];



        $validator = Validator::make($request->all(), $rules);

        if( ! $validator->fails() )
        {
            $fields = $request->all();
            $fields['area_id'] = $request->area;

            $ambient = SubArea::create($fields);

            return $this->showOne($ambient);
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
        $ambient = SubArea::findOrFail($id);

        return $this->showOne($ambient);
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
        $ambient = SubArea::findOrFail($id);

        $rules = [
            'name' => 'required|min:5|max:100',
            'code' => 'required|min:2|max:10',
            'description' => 'required',
            'area' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ( ! $validator->fails() )
        {
            if ( $request->has('name') )
            {
                $ambient->name = $request->name;
            }

            if ( $request->has('code') )
            {
                $ambient->code = $request->code;
            }

            if ( $request->has('description') )
            {
                $ambient->description = $request->description;
            }

            if ( $request->has('area') )
            {
                $ambient->area_id = $request->area;
            }

            if ( ! $ambient->isDirty() )
            {
                return response()->json(
                    [
                        'error' => 'Se debe especificar al menos un valor diferente para actualizar',
                        'code' => 422], 422);
            }

            $ambient->save();

            return $this->showOne($ambient);
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
        $ambient = SubArea::findOrFail($id);
        return $this->showOne($ambient);
    }
}
