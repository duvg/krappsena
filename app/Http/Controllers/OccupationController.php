<?php

namespace App\Http\Controllers;

use App\Occupation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OccupationController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $occupations = Occupation::all();
        return $this->showAll($occupations, 200);
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
            'name' => 'required|min:6',
            'description' => 'required|min:5|max:191'
        ];

        $validator = Validator::make($request->all(), $rules);

        if( ! $validator->fails() )
        {
            $occupation = Occupation::create($request->all());
            return $this->showOne($occupation, 201);
        }
        else
        {
            return $this->error($validator->errors(), 422);
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
        $occupation = Occupation::findOrFail($id);

        return $this->showOne($occupation, 200);
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
        $occupation = Occupation::findOrFail($id);

        $rules = [
            'name' => 'required|min:6',
            'description' => 'required:min:10|max:191'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ( ! $validator->fails() )
        {
            if( $request->has('name') )
            {
                $occupation->name = $request->name;
            }

            if( $request->has('description') )
            {
                $occupation->description = $request->description;
            }

            if( ! $occupation->isDirty() )
            {
                return $this->error(
                    'Se debe especificar al menos un valor diferente para actualizar',
                    422);
            }

            $occupation->save();
            return $this->showOne($occupation, 200);

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
        $occupation = Occupation::findOrFail($id);
        $occupation->delete();
        return $this->showOne($occupation, 200);
    }
}
