<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use App\Post;
use Carbon;
use App\Comment;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $allPosts = Post::orderBy('created_at','desc')->get();



       
        return view('blog.index', compact('allPosts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('blog.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // Validate
        $this->validate($request,[
            'title' => 'required|min:10|max:70',
            'content' => 'required|max:65535',
            'image' => 'required|image'
            ]);

        // Save
            $image = Image::make($request->image);

            switch($image->mime){
            case 'image/jpeg':
            case 'image/jpg':
                break;
                $fileExtension = '.jpg';
            break;

            case 'image/png':
                $fileExtension = '.png';
            break;

            case 'image/gif':
                $fileExtension = '.gif';
            break;
        }

            $filename = uniqid().$fileExtension;
            // Save Image
            $image->save("image/blog/$filename");
            // override the image object
            $newPost =$request->all();

            $newPost['image']= $filename;
            $newPost['users_id'] = \Auth::user()->id;

            $post = Post::create($newPost);
            // Redirect Post
            return redirect('blog/'.$post->id);
        
        // Redirect to post
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $post = Post::findOrFail($id);

        return view('blog.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function newComment(Request $request) {
        // Validation
        $this->validate($request, [
            'comment' => 'required|max:1000|min:20',
            'posts_id'=> 'required|exists:posts,id'
            ]);
        // Create new comment

        $data = $request->all();
        $data['users_id'] = \Auth::user()->id;

        $comment = Comment::create($data);

        // Redirect back to post
        return redirect('/blog/'.$request->posts_id);

    }
}
