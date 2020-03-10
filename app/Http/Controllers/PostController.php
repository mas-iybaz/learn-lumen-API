<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Post;

class PostController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
        $this->middleware('auth');
    }

    //
    public function index()
    {
        $getPost = Post::OrderBy("id", "DESC")->paginate(10);

        $data = [
            "message" => "List Post",
            "results" => $getPost
        ];

        return response()->json($data, 200);
    }

    public function show($id)
    {
        $post = Post::find($id);

        if (!$post) {
            $response = [
                "message" => 'Post not found!',
                "code" => 404
            ];
        } else {
            $response = [
                "message" => 'Success',
                "results" => $post,
                "code" => 200
            ];
        }

        return response()->json($response, $response['code']);
    }

    public function store(Request $request)
    {
        $data = [
            'user_id' => $request->input('user_id'),
            'title' => $request->input('title'),
            'slug' => Str::slug($request->input('title')),
            'body' => $request->input('body')
        ];

        $insert = Post::create($data);

        if ($insert) {
            $response = [
                "message" => "Success insert data!",
                "results" => $data,
                "code" => 200
            ];
        } else {
            $response = [
                "message" => "Failed insert data!",
                "results" => $data,
                "code" => 404
            ];
        }

        return response()->json($response, $response['code']);
    }

    public function update(Request $request)
    {
        $post = Post::find($request->input('id'));

        $data = [
            'id' => $request->input('id'),
            'title' => $request->input('title'),
            'slug' => Str::slug($request->input('title')),
            'body' => $request->input('body')
        ];

        $update = $post->update($data);

        if ($update) {
            $response = [
                "message" => "Success update data!",
                "results" => $data,
                "code" => 200
            ];
        } else {
            $response = [
                "message" => "Failed update data!",
                "results" => $data,
                "code" => 404
            ];
        }

        return response()->json($response, $response['code']);
    }

    public function destroy($id)
    {
        $post = Post::find($id);

        if (!$post) {
            $response = [
                "message" => 'ID not found!',
                "code" => 404
            ];
        } else {
            $post->delete();

            $response = [
                "message" => 'Data has been deleted!',
                "code" => 200
            ];
        }

        return response()->json($response, $response['code']);
    }
}
