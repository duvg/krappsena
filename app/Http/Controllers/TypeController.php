<?php

namespace App\Http\Controllers;

use App\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TypeController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types = Type::all();
        return $this->showAll($types, 200);

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
            'name' => 'required|min:5|max:160',
            'description' => 'required|min:15|max:191'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ( ! $validator->fails() )
        {
            $type = Type::create($request->all());
            return $this->showOne($type, 201);
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
        $type = Type::findOrFail($id);
        return $this->showOne($type,200);
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
        $type = Type::findOrFail($id);

        $rules = [
            'name' => 'required|min:5|max:160',
            'description' => 'required|min:15|max:191'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ( ! $validator->fails() )
        {
            if ( $request->has('name') )
            {
                $type->name = $request->name;
            }

            if ( $request->has('description') )
            {
                $type->description = $request->description;
            }

            if ( ! $type->isDirty() )
            {
                return $this->error(
                    'Se debe especificar al menos un valor diferente para actualizar',
                    422);
            }

            $type->save();
            return $this->showOne($type, 200);
        }
        else
        {
            return $this->error($validator->errors());
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
        $type = Type::findOrFail($id);
        $type->delete();
        return $this->showOne($type, 200);
    }
}
