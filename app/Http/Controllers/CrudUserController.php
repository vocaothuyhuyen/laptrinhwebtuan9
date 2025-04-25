<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class CrudUserController extends Controller
{

   
    public function login()
    {
        return view('crud_user.login');
    }

 
    public function authUser(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('list')
                ->withSuccess('Signed in');
        }

        return redirect("login")->withSuccess('Login details are not valid');
    }

  
    public function createUser()
    {
        return view('crud_user.create');
    }

   
    public function postUser(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'like' => 'required',
            'github' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $data = $request->all();
        $check = User::create([
            'name' => $data['name'],
            'like' => $data['like'],
            'github' => $data['github'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);

        return redirect("login");
    }

    public function readUser(Request $request)
    {
        $user_id = $request->get('id');
        $user = User::find($user_id);

        return view('crud_user.read', ['messi' => $user]);
    }

  
    public function deleteUser($id)
    {
        User::destroy($id);
        return redirect("list")->withSuccess('User deleted successfully');
    }

   
    public function updateUser(Request $request)
    {
        $user_id = $request->get('id');
        $user = User::find($user_id);

        return view('crud_user.update', ['user' => $user]);
    }

    public function postUpdateUser(Request $request)
    {
        $input = $request->all();

        $request->validate([
            'name' => 'required',
            'like' => 'required',
            'github' => 'required',
            'email' => 'required|email|unique:users,id,' . $input['id'],
            'password' => 'required|min:6',
        ]);

        $user = User::find($input['id']);
        $user->name = $input['name'];
        $user->like = $input['like'];
        $user->github = $input['github'];
        $user->email = $input['email'];
        $user->password = $input['password'];
        $user->save();

        return redirect("list")->withSuccess('You have signed-in');
    }

    public function listUser()
    {
        if (Auth::check()) {
            $users = User::with('roles')->paginate(10);
            return view('crud_user.list', ['users' => $users]);
        }

        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function signOut()
    {
        Session::flush();
        Auth::logout();

        return Redirect('login');
    }
    public function index(Request $request)
    {
        $search = $request->input('search');

        $users = User::where(function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%')
                ->orWhereHas('orders', function ($query) use ($search) {
                    $query->where('order_number', 'like', '%' . $search . '%');
                });
        })->paginate(10);  

        return view('crud_user.list', compact('users'));
    }

}
