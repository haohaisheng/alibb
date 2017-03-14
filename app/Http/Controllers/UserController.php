<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\User;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
        $users = User::all();
        //return view('Admin\memberList')->with('users', $users);
    }


    public function save($id)
    {
        return  '这是UserController控制器中的tmp方法---d--'.$id;
    }

    /**
     * 添加一个用户
     *
     * @return Response
     */
    public function add(UserRequest $req)
    {
        $user = new User();
        $user['name'] = $req->input('uname');
        $user['sex'] = $req->input('sex');
        $user['age'] = $req->input('age');
        $user['phone'] = $req->input('phone');
        $user['email'] = $req->input('email');
        $user->save();
        return redirect()->route('index');
    }

    /**
     * 更新用户.
     *
     * @param  Request $request
     * @param  int $id
     * @return Response
     */
    public function update(Request $request, $id=null)
    {
        //
        return  '这是UserController控制器中的update方法----'.$id;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create($id)
    {
        //
        return  '这是UserController控制器中的create方法-----'.$id;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
        return  '这是UserController控制器中的store方法';
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  int $id
     * @return Response
     */
//     public function update(Request $request, $id)
//     {
//         //
//     }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }


}
