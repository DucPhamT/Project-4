<?php


namespace App\Http\Controllers;

use App\Models\Category;
use Faker\Guesser\Name;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Support\Facades\DB;
class PostController extends Controller
{
    //them moi bai viet
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|max:255',
                'content' => 'required',
                'thumbnail' => 'nullable',
                'category_ids' => 'sometimes|array',
                'category_ids.*' => 'exists:categories',
            ]);
            // $post = Post::create($request->only(
            //     'user_id',
            //     'title',
            //     'content',
            //     'thumbnail',
            // ));
            $post = Post::create([
                'user_id' => auth()->id(),
                ...$validated
            ]);
            if ($request->has('category_ids')) {

                $post->categories()->attach($request->category_ids); // ghi vao bang trung gian
            }
            return response()->json([
                'status' => 'success',
                'post' => $post->load('categories'),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                "error " => $e->getMessage()
            ], 500);
        }
    }

    public function index(Post $post)
    {
        $post = Post::all();
        return response()->json([
            'post' => $post
        ]);
    }
    public function update(Request $request, $id)
    {
        try {
            $post = Post::findOrFail($id);
            $post->update($request->all());
            return response()->json([
                'status' => 'success',
                'post' => $post,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 422);
        }
    }
    public function delete(Post $post, $id)
    {
        try {
            $post = Post::findOrFail($id);
            $post->delete();
            return response()->json([
                'status' => 'successfully deleted',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 422);
        }
    }



    //level-up api
    
    public function postNoComment()
    {
        try {
            $post_without_comment = Post::doesntHave('comments')->get();
            return response()->json($post_without_comment);
        } catch (\Throwable $th) {

        }
    }
    public function getPostFromCategory($categoryId)
    {

        try {
            $category = Category::findOrFail($categoryId);

            $post = $category->posts()->get();
            if ($post->isEmpty()) {
                return response()->json([
                    'message' => 'No posts found in this category'
                ]);
            } else
                return response()->json([
                    'status' => 'success',
                    'category' => $category->name,
                ]);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }



    public function getUserLatestPost()
    {
        $data = User::select('id', 'user_name')->with('latestPost')->get();

        return response()->json([

            'data' => $data,
        ], 200);
    }
}