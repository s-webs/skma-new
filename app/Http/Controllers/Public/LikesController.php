<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikesController extends Controller
{
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($news_id)
    {
        if (!$news_id) {
            return abort(404);
        }

        $user = Auth::user();

        // Проверяем, есть ли уже лайк от этого пользователя на данную новость
        $existingLike = Like::where('news_id', $news_id)
            ->where('user_id', $user->id)
            ->first();

        if ($existingLike) {
            // Если лайк уже есть — удаляем его
            $existingLike->delete();
        } else {
            // Если лайка нет — создаём
            $like = new Like();
            $like->news_id = $news_id;
            $like->user_id = $user->id;
            $like->save();
        }

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
