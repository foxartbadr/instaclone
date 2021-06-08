<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use App\Like;
use App\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PostsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $utilisateurs = User::all();

        $users = auth()->user()->following()->pluck('profiles.user_id');

        $posts = Post::whereIn('user_id', $users)->with('user')->latest()->paginate(5);

        return view('posts.index', compact(['posts', 'utilisateurs']));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store()
    {
        $data = request()->validate([
            'caption' => 'required',
            'image' => ['required', 'image'],
        ]);

        $imagePath = request('image')->store('uploads', 'public');

        $image = Image::make(public_path("storage/{$imagePath}"))->fit(1200, 1200);
        $image->save();

        auth()->user()->posts()->create([
            'caption' => $data['caption'],
            'image' => $imagePath,

        ]);

        return redirect('/profile/' . auth()->user()->id);
    }


    public function show(\App\Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function destroy(User $user,$id)
    {
        $user = auth()->user();
        $utilisateurs= User::orderBy('id', 'ASC')->whereNotIn('username', [auth()->user()->username])->paginate(3);
        $users = auth()->user()->following->pluck('user_id'); 
        $posts = Post::whereIn('user_id' , $users)->orderBy('created_at' , 'DESC')->paginate(8);


        $post_supp=Post::find($id);
        $this->authorize('delete' , $post_supp );
        $post_supp->delete();
        return view('posts.index' , compact(['posts','user','utilisateurs']));


    }

    
    public function like()
    {
        $post = Post::find(request()->id);

        if ($post->isLikedByLoggedInUser()) {
            $res = Like::where([
                'user_id' => auth()->user()->id,
                'post_id' => request()->id
            ])->delete();

            if ($res) {
                return redirect('/');
            }

        } else {
            $like = new Like();

            $like->user_id = auth()->user()->id;
            $like->post_id = request()->id;

            $like->save();

            return redirect('/');
        }
    }
    public function like_1()
    {
        $post = Post::find(request()->id);

        if ($post->isLikedByLoggedInUser()) {
            $res = Like::where([
                'user_id' => auth()->user()->id,
                'post_id' => request()->id
            ])->delete();

            if ($res) {
                  return view('posts.show', compact('post'));
            }

        } else {
            $like = new Like();

            $like->user_id = auth()->user()->id;
            $like->post_id = request()->id;

            $like->save();

              return view('posts.show', compact('post'));
        }
    }





    public function comment()
    {
        $post = Post::find(request()->id);

        $comment = new Comment();
        $comment->user_id = auth()->user()->id;
        $comment->post_id = request()->id;
        $comment->comment = request()->comment;

        $comment->save();

        return response()->json([
            'count' => Post::find(request()->id)->comments->count()
        ]);

        
    }
    public function delete_comment($comment_id)
    {
        $comment = Comment::find($comment_id);
        $this->authorize('delete_comment' , $comment );
        $comment->delete();

        $post = $comment->post;
        $user= auth()->user()->username ;
        $comments = Comment::where('post_id' , $post->id)->orderBy('created_at' , 'DESC')->paginate(17);


        return view('posts.show' , compact(['post','user','comments']));

    }
}
