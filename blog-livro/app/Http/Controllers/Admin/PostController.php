<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Post;
use App\User;
use Exception;
use Illuminate\Support\Facades\Storage;


class PostController extends Controller
{

    private $post;


    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function index() {
        $posts = Post::paginate(15);

        return view('posts.index', compact('posts'));
    }

    public function show(Post $post) {

        $categories = \App\Category::all(['id', 'name']);

        return view('posts.edit', compact('post', 'categories'));
    }

    public function create() {

        $categories = \App\Category::all(['id', 'name']);
        return view('posts.create', compact('categories'));
        
    }

    public function store(Request $request) {

        $data = $request->all();

        try {

            $data['is_active'] = true;

            $user = auth()->user();
            $post = $user->posts()->create($data);

            $post->categories()->sync($data['categories']);

            if($request->hasFile('thumb')) {
                $data['thumb'] = $request->file('thumb')->store('thumbs', 'public');
            } else {
                unset($data['thumb']);
            }

            flash('Postagem Inserida com sucesso');
            return redirect()->route('posts.index');



        } catch (Exception $e) {

            $message = 'Erro ao enviar categoria';
            if(env('APP_DEBUG')) {
                $message = $e->getMessage();
            }

            flash($message)->warning();
            return redirect()->back();
        }
    }

    public function update(Post $post, Request $request) {
        $data = $request->all();

        try {

            $post->update($data);
            $post->categories()->sync($data['categories']);

            if($request->hasFile('thumb')) {

                //Remove a imagem atual
                Storage::disk('public')->delete($post->thumb);

                $data['thumb'] = $request->file('thumb')->store('thumbs', 'public');

            } else {
                unset($data['thumb']);
                }

            flash('Postagem atualizada com sucesso');

            return redirect()->route('posts.show', ['post' => $post->id]);
        } catch (Exception $e) {

            $message = 'Erro ao atualizar categoria';
            if(env('APP_DEBUG')) {
                $message = $e->getMessage();
            }

            flash($message)->warning();
            return redirect()->back();
        }
    }


    public function destroy(Post $post) {

       try {
           $post->delete($post);

           flash('Postagem deletada com sucesso');

            return redirect()->route('posts.index');

       } catch (Exception $e) {

            $message = 'Erro ao remover categoria!';
            
            if(env('APP_DEBUG')) {
                $message = $e->getMessage();
            }

            flash($message)->warning();
            return redirect()->back();


       }
    }


}
