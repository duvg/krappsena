<?php

namespace App\Http\Controllers;

use App\Area;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AreaController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $areas = Area::all();
        return $this->showAll($areas, 200);
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
            'name' => 'required|min:7|max:180',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ( ! $validator->fails() )
        {
            $area = new Area();
            $area->name = $request->name;
            $area->status = true;
            $area->save();

            return $this->showOne($area, 201);
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
        $area = Area::findOrFail($id);
        return $this->showOne($area, 200);
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
        $area = Area::findOrFail($id);

        $rules = [
            'name' => 'required|min:7|max:180',
        ];

        $validator = Validator::make($request->all(), $rules);

        if( ! $validator->fails() ) {
            if ($request->has('name')) {
                $area->name = $request->name;
            }

            if ($request->has('description'))
            {
                $area->description = $request->description;
            }

            if ( ! $area->isDirty() )
            {
                return $this->error(
                    'Se debe especificar al menos un valor diferente para actualizar',
                    422);
            }

            $area->save();
            return $this->showOne($area, 200);

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
        $area = Area::findOrFail($id);
        $area->delete();
        return $this->showOne($area, 200);
    }
}
