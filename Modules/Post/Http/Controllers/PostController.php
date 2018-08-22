<?php

namespace Modules\Post\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Mews\Purifier\Facades\Purifier;
use Modules\Post\Entities\Post;
use Modules\Post\Entities\PostImage;
use Modules\Post\Http\Requests\UploadPostImageRequest;

class PostController extends Controller
{

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($id)
    {
        $arrTabs = ['General'];
        $active = "active";

        $posts=Post::where('user_id',$id)->orderBy('created_at','DESC')->get();

        return view('post::index', compact('arrTabs', 'active','posts'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create($userId)
    {
        $arrTabs = ['General'];
        $active = "active";

        $userImages = Auth::user()->photos;

        return view('post::create', compact('arrTabs', 'active','userImages'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {

        $postContent = $request['content'];
        $postTitle = $request->title;
        $user_id = Auth::id();



        //-- Prevent XSS JS injection
        //-- Removing not allowed <script> tags
        $postContent = Purifier::clean($postContent, array('Attr.EnableID' => true));


        Post::create([
            'user_id' => $user_id,
            'title' => $postTitle,
            'content' => $postContent
        ]);


        Session::flash('post_change','Post was successfully created!');
        return \Redirect::route('posts', $user_id);


    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show($userId, $id)
    {
        $arrTabs = ['General'];
        $active = "active";
        $post=Post::findOrFail($id);

        return view('post::show',compact('arrTabs', 'active','post'));
    }


    /**
     * @param $userId
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($userId, $id)
    {
        $arrTabs = ['General'];
        $active = "active";

        $post=Post::findOrFail($id);
        $userImages = Auth::user()->photos;

        return view('post::edit', compact('arrTabs', 'active','post','userImages'));
    }


    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {


    }

    public function updatePost(Request $request, $id)
    {
        $input = $request->all();
        $user_id = Auth::id();


        //-- Prevent XSS JS injection
        //-- Removing not allowed <script> tags
        $input['content'] = Purifier::clean($input['content'], array('Attr.EnableID' => true));

        $post = Post::findOrFail($id);
        $post->update($input);


        Session::flash('post_change','Post was successfully updated!');
        return \Redirect::route('posts', $user_id);

    }

    /**
     * Remove the specified resource from storage.
     * @param $id
     * @return Response
     */
    public function destroy( $id)
    {


    }
    public function destroyPost( $id)
    {
        $user_id = Auth::id();
        $post = Post::findOrFail($id);
        if ($post->image) {
            if(file_exists(storage_path('/app/public/' . $post->image->path))){
                unlink(storage_path('/app/public/' . $post->image->path));
            }

            $photo_image = PostImage::where('post_id',$id)->first();
            if ($photo_image) {
                $photo_image->delete();
            }
        }
        $post->delete();

        Session::flash('post_change','Post was successfully deleted!');
        return \Redirect::route('posts', $user_id);


    }


    public function updatePostImage(UploadPostImageRequest $request, $id)
    {


       $user = User::findOrFail(Auth::id());
       $post=Post::find($id);

        $file = $request->file('image');
        $arrAllowedExtension = ['png', 'jpg', 'jpeg'];
        $extension = $file->getClientOriginalExtension();

        if (in_array($extension, $arrAllowedExtension)) {
            if (!($file->getClientSize() > 2100000)) {

                if ($post->image) {
                    if(file_exists(storage_path('/app/public/' . $post->image->path))){
                        unlink(storage_path('/app/public/' . $post->image->path));
                    }

                    $photo_image = PostImage::where('post_id',$id)->first();
                    if ($photo_image) {
                        $photo_image->delete();
                    }
                }

                $name = time()."_".$post->id."_" . $file->getClientOriginalName();
                //$file->move('images', $name);
                request()->file('image')->storeAs(
                    'public/upload/' . Auth::id() . '/post/images/', $name
                );
                PostImage::create([
                    'user_id' => Auth::id(),
                    'post_id' =>$id,
                    'name' => $name,
                    'size' => $file->getClientSize(),
                    'extension' => $extension,
                    'path' => 'upload/' . Auth::id() .'/post/images/' . $name
                ]);


                $arrOptions = [
                    'message' => 'Post has been successfully edited!',
                    'type' => 'success',
                    'position' => 'topRight'
                ];
                Session::flash('post_change', $arrOptions);
                return \Redirect::route('posts.show',['userId'=>$user->id,'id'=>$id]);

            } else {
                $arrOptions = [
                    'message' => 'Image size should not exceed 2 MB',
                    'type' => 'error',
                    'position' => 'bottomLeft'
                ];
                Session::flash('post_change', $arrOptions);
                return \Redirect::route('posts.show',['userId'=>$user->id,'id'=>$id]);
            }
        }else {
            $arrOptions = [
                'message' => trans('images::messages.image_format_error',['formats'=>implode(",", $arrAllowedExtension)]),
                'type' => 'error',
                'position' => 'bottomLeft'
            ];
            Session::flash('post_change', $arrOptions);
            return \Redirect::route('posts.show',['userId'=>$user->id,'id'=>$id]);
        }



    }


}
