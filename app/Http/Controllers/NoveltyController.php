<?php

namespace App\Http\Controllers;

use App\Novelty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NoveltyController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $novelties = Novelty::all();

        return $this->showAll($novelties);
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
            'user' => 'required',
            'area' => 'required',
            'subarea' => 'required',
            'type' => 'required',
            'description' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ( ! $validator->fails() )
        {
            $fields = $request->all();
            $fields['user_id'] = $request->user;
            $fields['area_id'] = $request->area;
            $fields['subarea_id'] = $request->subarea;
            $fields['type_id'] = $request->type;
            $fields['description'] = $request->description;
            $fields['status'] = 'pendiente';

            $novelty = Novelty::create($fields);
            return $this->showOne($novelty);
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
        $novelty = Novelty::findOrFail($id);
        return $this->showOne($novelty);
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
        $novelty = Novelty::findOrFail($id);

        $rules = [
            'user' => 'required',
            'area' => 'required',
            'subarea' => 'required',
            'type' => 'required',
            'description' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ( ! $validator->fails() )
        {
            if ( $request->has('user') )
            {
                $novelty->user_id = $request->user;
            }

            if ( $request->has('area') )
            {
                $novelty->area_id = $request->area;
            }

            if ( $request->has('subarea') )
            {
                $novelty->subarea_id = $request->subarea;
            }

            if ( $request->has('type') )
            {
                $novelty->type_id = $request->type;
            }

            if ( $request->has('description') )
            {
                $novelty->description = $request->description;
            }

            if ( $request->has('status') )
            {
                $novelty->status = $request->status;
            }

            if ( ! $novelty->isDirty() )
            {
                return response()->json(
                    [
                        'error' => 'Se debe especificar al menos un valor diferente para actualizar',
                        'code' => 422], 422);
            }

            $novelty->save();
            return $this->showOne($novelty);
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
        $novelty = Novelty::findOrFail($id);
        $novelty->delete();
        return $this->showOne($novelty);
    }
}
