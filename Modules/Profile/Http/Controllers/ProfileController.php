<?php

namespace Modules\Profile\Http\Controllers;

use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Image;
use App\Menu\MenuLang;
use App\Menu\UserMenu;
use App\Setting;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Modules\Dashboard\Entities\AdminSettings;
use Modules\Dashboard\Entities\Language;
use Modules\Dashboard\Entities\MailEntity;
use Modules\Dashboard\Entities\MailTemplate;
use Modules\Dashboard\Entities\SocialIcon;
use Modules\Images\Entities\Photo;
use Modules\Pagebuilder\Entities\Background;
use Modules\Pagebuilder\Entities\Block;
use Modules\Pagebuilder\Entities\BlockContent;
use Modules\Pagebuilder\Entities\UserBlockPivot;
use Modules\Post\Entities\Post;
use Modules\Website\Entities\WebsiteSetting;
use Spatie\TranslationLoader\LanguageLine;

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
        $user = User::findOrFail($id);

        return view('profile::index', compact('arrTabs', 'active', 'user'));
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
        $user = Auth::user();

        $user = Auth::user();
        return view('profile::settings', compact('arrTabs', 'active', 'user'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function updateProfile(UpdateProfileRequest $request, $id)
    {


        $user = User::findOrFail($id);
        $input = $request->all();
        if ($file = $request->file('photo_id')) {
            if (!($file->getClientSize() > 2100000)) {
                //dd('storage/upload/' . Auth::id() . '/profile/' . $user->image->path);
                if ($user->image) {
                    unlink(storage_path('/app/public/upload/' . Auth::id() . '/profile/' . $user->image->path));
                    $photo_user = Image::findOrFail($user->image->id);
                    if ($photo_user) {
                        $photo_user->delete();
                    }
                }

                $name = time() . $file->getClientOriginalName();
                //$file->move('images', $name);
                request()->file('photo_id')->storeAs(
                    'public/upload/' . Auth::id() . '/profile/', $name
                );
                Image::create(['path' => $name, 'user_id' => $id]);

            } else {
                Session::flash('user_change', 'Image size should not exceed 2 MB');
                return redirect('admin/profile/' . $id . '/settings');
            }
        }

        $input['name'] = $request->name;
        $input['email'] = $request->email;
        $user->update($input);
        Session::flash('user_change', 'Profile has been successfully edited!');
        return redirect('admin/profile/' . $user->id);


        //return view('profile::settings',compact('arrTabs','active'));
    }

    /**
     * Functionality for deleting user and all relevant content from application
     *
     * @return Response
     */
    public function deleteProfile(Request $request)
    {

        $user_id = $request->user_id;
        $user = User::findOrFail($user_id);


        Setting::where('user_id', $user_id)->delete();
        AdminSettings::where('user_id', $user_id)->delete();
        MenuLang::where('user_id', $user_id)->delete();
        UserMenu::where('user_id', $user_id)->delete();
        LanguageLine::where('user_id', $user_id)->delete();
        Language::where('user_id', $user_id)->delete();
        Post::where('user_id', $user_id)->delete();
        MailEntity::where('user_id', $user_id)->delete();
        MailTemplate::where('user_id', $user_id)->delete();
        SocialIcon::where('user_id', $user_id)->delete();
        WebsiteSetting::where('user_id', $user_id)->delete();
        Background::where('user_id', $user_id)->delete();

        //-- Deleting PAGEBUILDER BLOCKS related to this user
        $blocks=Block::where('user_id', $user_id)->get();
        if (!empty($blocks)) {
            foreach ($blocks as $block){
                UserBlockPivot::where('block_id', $block->id)->delete();
                BlockContent::where('id', $block->id)->delete();
                Block::where('id', $block->id)->delete();
            }
        }


        //-- Delete user profile image and unlick it physically from the server as well
        $image = Image::where('user_id', $user_id)->first();
        if (!empty($image)) {
            unlink(storage_path('/app/public/upload/' . $user_id . '/profile/' . $user->image->path));
            $image->delete();
        }


        $photos = Photo::where('user_id', $user_id)->get();
        if (!empty($photos)) {
            //-- Delete all user photos and unlick it physically from the server as well
            foreach ($photos as $photo) {
                unlink(storage_path('/app/public/' . $photo->path));
                $photo->delete();
            }
        }

        //-- Delete directory of this user in Storage
        Storage::disk('local')->deleteDirectory('/public/upload/' . $user_id);


        //-- Flush cached header menu for current user
        Cache::tags('menu_'.$user_id)->flush();

        //-- Delete current user and logout from application
        $user->delete();
        Auth::logout();

        //-- Redirect to the login page with corrent language locale
        $strLocale = App::getLocale();
        return redirect('/' . $strLocale . '/login');
    }


    /**
     * @return Response
     */
    public function updatePassword(UpdatePasswordRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $input = $request->all();
        $old_password = bcrypt(\Request::input('old_password'));
        $password = \Request::input('password');
        $password_2 = \Request::input('password_2');
        if (Hash::check(\Request::input('old_password'), $user->password)) {
            if ($password == $password_2) {
                $input['password'] = bcrypt(\Request::input('password'));
                $user->update($input);
                Session::flash('user_change', 'The password has been successfully edited!');
                return redirect('admin/profile/' . $id);
            } else {
                $arrTabs = ['General'];
                $active = "active";
                $user = User::findOrFail($id);
                $title = 'Change password';
                Session::flash('user_change', 'You repeated new password not correct');
                return view('profile::change_password', compact('user', 'arrTabs', 'active', 'title'));
            }
        } else {
            $arrTabs = ['General'];
            $active = "active";
            $user = User::findOrFail($id);
            $title = 'Change password';
            Session::flash('user_change', 'You entered wrong old password');
            return view('profile::change_password', compact('user', 'arrTabs', 'active', 'title'));
        }
    }

}
