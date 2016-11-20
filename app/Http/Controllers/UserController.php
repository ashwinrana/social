<?php
namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{


    function index()
    {
        $users = User::paginate(5);
        return view('users.List', ['users' => $users]);
    }


    function create()
    {
        return view('users.create');
    }


    function store( Request $request){
//        dd( $_FILES );
//  dd($request->file('image'));
//        if($request->hasFile('image')){
//            $image = $request->file('image');
//            $image->move(public_path('uploads') , time() . "." . $image->getClientOriginalExtension());
//        }
//        die;
        $user = $request->all();
//        $user['image'] = $image->getClientOriginalName();
        User::create( $user );
        return redirect('home');
//    dd($request->all());
    }

    function profile($id)
    {
        $user = User::find($id);
        return view('users.profile', ['user' => $user]);

    }


    function edit($id)
    {
        $user = User::find($id);
        return view('users.edit', ['user' => $user]);

    }


    function update(Request $requests, $id)
    {
        $user = User::find($id);
        $user->update($requests->all());
//        dd($user);
        if($requests->save(update))
        return redirect('home');

    }


    function delete($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->route('userList');

    }


    function login()
    {
        return view('users.login');
    }



    function postLogin(Request $request)
    {
//        dd($request->all());
        if (Auth::attempt($request->only('user_name', 'password'))) {

//            dd(Auth::user());
//            dd("True");
//            return redirect()->intended(route('userList'));
            return redirect()->intended(route('dashboard'));
        }

//        dd($request->all());
        return redirect()->route('login')->with('message', '<div class="alert alert-danger">Incorrect User Name or Password</div>');

    }


    function search()
    {

        return view('users.search');
    }


    function logout(){

        Auth::logout();
        return redirect()->route('login');
    }
}
