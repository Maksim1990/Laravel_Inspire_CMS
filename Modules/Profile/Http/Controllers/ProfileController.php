<?php

namespace Modules\Profile\Http\Controllers;

use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Image;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index($id)
    {
        $arrTabs = ['General'];
        $active = "active";

        return view('profile::index',compact('arrTabs','active'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('profile::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('profile::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('profile::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
        dd($request);
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {

    }

    /**
     * @return Response
     */
    public function settings($id)
    {
        $arrTabs = ['General'];
        $active = "active";
        $user=Auth::user();

        $user=Auth::user();
        return view('profile::settings',compact('arrTabs','active','user'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function updateProfile(UpdateProfileRequest $request, $id)
    {


        $user=User::findOrFail($id);
        $input=$request->all();
        if($file=$request->file('photo_id')) {
            if (!($file->getClientSize() > 2100000)) {
                if ($user->photo) {
                    unlink(public_path() . $user->photo->path);
                    $photo_user = Image::findOrFail($user->photo_id);
                    if($photo_user){
                        $photo_user->delete();
                    }
                }

                $name = time() . $file->getClientOriginalName();
                //$file->move('images', $name);
                request()->file('photo_id')->storeAs(
                    'public/upload/' . Auth::id() . '/profile/', $name
                );
                $photo = Image::create(['path' => $name,'user_id'=>$id]);

            } else {
                Session::flash('user_change', 'Image size should not exceed 2 MB');
                return redirect('admin/profile/' . $id . '/upload');
            }
        }

        $input['name'] = $request->name;
        $input['email'] = $request->email;
        $user->update($input);
        Session::flash('user_change','Profile has been successfully edited!');
        return redirect('admin/profile/'.$user->id);


        //return view('profile::settings',compact('arrTabs','active'));
    }

    /**
     * @return Response
     */
    public function deleteProfile(Request $request)
    {

        dd("TEST");
        $arrTabs = ['General'];
        $active = "active";

        return view('profile::settings',compact('arrTabs','active'));
    }



    /**
     * @return Response
     */
    public function updatePassword(UpdatePasswordRequest $request, $id)
    {
        $user=User::findOrFail($id);
        $input=$request->all();
        $old_password=bcrypt(\Request::input('old_password'));
        $password=\Request::input('password');
        $password_2=\Request::input('password_2');
        if (Hash::check(\Request::input('old_password'), $user->password)) {
            if($password==$password_2){
                $input['password'] = bcrypt(\Request::input('password'));
                $user->update($input);
                Session::flash('user_change','The password has been successfully edited!');
                return redirect('admin/profile/'.$id);
            }else{
                $arrTabs=['General'];
                $active="active";
                $user=User::findOrFail($id);
                $title='Change password';
                Session::flash('user_change','You repeated new password not correct');
                return view('profile::change_password', compact('user','arrTabs', 'active','title'));
            }
        }else{
            $arrTabs=['General'];
            $active="active";
            $user=User::findOrFail($id);
            $title='Change password';
            Session::flash('user_change','You entered wrong old password');
            return view('profile::change_password', compact('user','arrTabs', 'active','title'));
        }
    }

}
