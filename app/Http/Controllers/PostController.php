<?php


namespace App\Http\Controllers;

use App\Models\Category;
use Faker\Guesser\Name;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class PostController extends Controller
{
    //them moi bai viet
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }
        try {
            $validated = $request->validate([
                'title' => 'required|max:255',
                'content' => 'required',
                'thumbnail' => 'nullable',
                'category_ids' => 'sometimes|array',
                'category_ids.*' => 'exists:categories,id',
            ]);
            $user = Auth::user();
            $post = $user->posts()->create($validated);

            if ($request->has('category_ids')) {

                $post->categories()->sync($request->category_ids);
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

    public function index()
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
    public function delete($id)
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

    public function countPostsWithCategories($categoryId)
    {
        try {
            $category = Category::findOrFail($categoryId);
            if ($category->posts()->exists()) {
                $post = $category->posts()->count();
                return response()->json([
                    'status' => 'success',
                    'number_of_posts' => $post,
                ]);

            } else {
                return response()->json([
                    'status' => 'success',
                    'number_of_posts' => 0,
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
            ], );
        }
    }




    //start api for project 5
    public function createPost()
    {
        $user = Auth::user();
        $token = session('api_token');


        $categories = Category::select('id', 'name')->orderBy('name')->get();
        return Inertia::render('CreatePost', [
            'user' => $user,
            'token' => $token,
            'categories' => $categories
        ]);

    }

    public function showPost()
    {
        return Inertia::render('ShowPost', []);
    }

    public function getPost()
    {
        $posts = Post::with('user', 'categories')->get();
        return response()->json([
            'post' => $posts
        ]);
    }

    public function deletePost($id)
    {
        try {
            $post = Post::findOrFail($id);
            $post->delete();
            return redirect()->route('show-posts');
        } catch (\Throwable $e) {
            return redirect()
                ->route('show-posts')
                ->with('error', 'Unexpected error');
        }
    }

    public function editPost(Post $post)
    {
        $post =
            $post->load('categories');
        return Inertia::render('EditPost', [
            'post' => [
                'id' => $post->id,
                'title' => $post->title,
                'content' => $post->content,
                'thumbnail' => $post->thumbnail,
                'categories' => $post->categories,
            ],
            'categories' => Category::all(),
        ]);
    }


    public function updatePost(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|max:255',
                'content' => 'required',
                'thumbnail' => 'nullable',
                'category_ids' => 'sometimes|array',
                'category_ids.*' => 'exists:categories,id',
            ]);
            $post = Post::findOrFail($id);
            //user authentication
            if (auth()->id() !== $post->user_id) {
                return response()->json(['error' => 'You do not have permission to edit this post!'], 403);
            }



            $post->update($validatedData);
            if ($request->has('category_ids')) {
                $post->categories()->sync($request->category_ids);
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Post not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An internal error occurred.'], 500);
        }
    }
    //end api for project 5
}
