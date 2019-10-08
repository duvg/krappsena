<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Validator;

class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return $this->showAll($users);
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
            'name' => 'required',
            'lastname' => 'required',
            'telephone' => 'required|min:5|max:12',
            'birthdate' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'occupation' => 'required',
            'area' => 'required',
            'headquarter' => 'required',
        ];


        $validator = Validator::make($request->all(), $rules);
        if( ! $validator->fails() )
        {
            $fields = $request->all();

            $fields['password'] = bcrypt($request->password);
            $fields['birthdate'] = date('y-m-d', strtotime($request->birthdate));
            $fields['headquarter_id'] = $request->headquarter;
            $fields['occupation_id'] = $request->occupation;
            $fields['area_id'] = $request->area;
            $fields['rol_id'] = 2;
            $fields['status'] = 1;

            $user = User::create($fields);
            return $this->showOne($user, 201);
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
        $user = User::findOrFail($id);

        return $this->showOne($user, 200);
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
        $user = User::findOrFail($id);

        $rules = [
            'email' => 'email|unique:users',
            'password' => 'min:6|confirmed',
        ];

        $valdiator = Validator::make($request->all(), $rules);

        if( ! $valdiator->fails())
        {
            if ( $request->has('name') )
            {
                $user->name = $request->name;
            }

            if ( $request->has('lastname') )
            {
                $user->lastname = $request->lastname;
            }

            if ( $request->has('birthdate') )
            {
                $user->birthdate = date('Y-m-d', strtotime($request->birthdate));
            }

            if ( $request->has('status') )
            {
                $user->status = $request->status;
            }

            if ( $request->has('rol') )
            {
                $user->rol_id = $request->rol;
            }

            if ( $request->has('headquarter') )
            {
                $user->headquarter_id = $request->headquarter;
            }

            if ( $request->has('occupation') )
            {
                $user->occupation_id = $request->occupation;
            }

            if ( $request->has('area') )
            {
                $user->area_id = $request->area;
            }

            if ( $request->has('email') && $user->email != $request->email )
            {
                if ( $user->email != $request->email )
                {
                    $user->email = $request->email;
                }

            }

            if ( $request->has('password') )
            {
                $user->password = bcrypt($request->password);
            }

            if ( ! $user->isDirty() )
            {
                return response()->json(
                    [
                        'error' => 'Se debe especificar al menos un valor diferente para actualizar',
                        'code' => 422], 422);
            }

            $user->save();

            return $this->showOne($user, 201);
        }
        else
        {
            return $valdiator->errors();
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
        $user = User::findOrFail($id);

        $user->delete();

        return $this->showOne($user, 200);
    }
}
