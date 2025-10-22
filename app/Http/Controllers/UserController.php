<?php

namespace App\Http\Controllers;
use App\Models\Category;
use Faker\Guesser\Name;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
class UserController extends Controller
{
    public function topFiveUser(User $user)
    {
        try {
            $topUsers = User::withCount('posts')
                ->orderBy('posts_count', 'DESC')
                ->take(5)
                ->get('id', 'name', 'email', 'posts_count');
            return response()->json($topUsers);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),

            ], 500);
        }
    }
    public function commentersWithoutPosts()
    {
        try {
            $users = User::query()
                ->whereHas('comments')
                ->doesntHave('posts')
                ->select('id', 'user_name')->get();
            foreach ($users as $user) {
                $data[] = [
                    'user' => $user,
                ];

            }
            return response()->json($data);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
            ]);
        }

    }
}
