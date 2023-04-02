<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;



class AdminUserController extends Controller
{
    public function Show()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }
    public function createPage(){
        return view('admin.users.create');
    }

    public function UserDetails($user_id)
    {
        $user = User::findOrFail($user_id);
        return view('admin.users.edit', compact('user'));
    }

    public function Edit(Request $request, $user_id)
    {
        $request->validate([
            'name'     =>'required|max:500',
            'email'    =>'required',
            'password' =>'required|min:6',
            'major'    =>'required',
            'role'     =>'required',
            'status'   =>'required',
            'picture'  =>'mimes:jpeg,jpg,png'
            ]);
            $user = User::findOrFail($user_id);
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = bcrypt($request->input('password'));
            $user->major = $request->input('major');
            $user->role = $request->input('role');
            $user->status = $request->input('status');
            $user->point = $request->input('point');
            $user->remain = $request->input('remain');
            if($request->hasfile('picture'))
                {
                $file = $request->file('picture');
                $extention = $file ->getClientOriginalExtension();
                $filename = time().'.'.$extention;
                $file->move('imgs/users/' , $filename);
                $user->picture = $filename ;
                }
            
            
            $user->save();

            return redirect()->route('ShowUsers.admin')->with('success', 'User updated successfully');
    }

    public function Delete($user_id)
    {
        User::destroy($user_id);

        return redirect()->route('ShowUsers.admin')->with('success', 'User deleted successfully');
    }

    public function Create(Request $request)
    {
        $request->validate([
            'name'     =>'required|max:500',
            'email'    =>'required',
            'password' =>'required|min:6',
            'major'    =>'required',
            'role'     =>'required',
            'status'   =>'required',
            'picture'  =>'mimes:jpeg,jpg,png'
            ]);
            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = bcrypt($request->input('password'));
            $user->major = $request->input('major');
            $user->role = $request->input('role');
            $user->status = $request->input('status');
            $user->point = $request->input('point');
            $user->remain = $request->input('remain');
            if($request->hasfile('picture'))
            {
            $file = $request->file('picture');
            $extention = $file ->getClientOriginalExtension();
            $filename = time().'.'.$extention;
            $file->move('imgs/users/' , $filename);
            $user->picture = $filename ;
            }
            
            $user->save();

            return redirect()->route('ShowUsers.admin')->with('success', 'User created successfully');
    }
}
