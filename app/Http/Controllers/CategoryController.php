<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = Category::all();
        return $this->showAll($category, 200);
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
            'name' => 'required|min:5|max:50',
            'icon' => 'required',
            'description' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ( ! $validator->fails() )
        {   
            $fields = $request->all();
            $fields['name'] = $request->name;
            $fields['description'] = $request->description;
            $fields['icon'] = $request->icon;
            
            $category = Category::create($fields);
            return $this->showOne($category, 201);
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
        $category = Category::findOrFail($id);
        return $this->showOne($category, 200);
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
        $category = Category::findOrFail($id);



        $rules = [
            'name' => 'required|min:5|max:20',
            'icon' => 'required',
            'description' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);



        if ( ! $validator->fails() )
        {
            if ( $request->has('name') )
            {
                $category->name = $request->name;
            }

            if ( $request->has('icon' ) )
            {
                $category->icon = $request->icon;
            }

            if ( ! $request->has('description') )
            {
                $category->description = $request->description;
            }

            if ( ! $category->isDirty() )
            {
                return $this->error(
                    'Se debe especificar al menos un valor diferente para actualizar',
                    422);
            }

            $category->save();

            return $this->showOne($category);
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
        $category = Category::findOrFail($id);
        $category->delete();
        return $this->showOne($category);
    }
}
