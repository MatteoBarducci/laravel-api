<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;
use App\Models\Tag;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();

        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.posts.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'title' => 'required|min:5|max:150|unique:posts,title',
                'content' => 'nullable|min:10',
                'cover_image' => 'nullable|image|max:256',
                'category_id' => 'nullable|exists:categories,id',
                'tags' => 'nullable|exists:tags,id',
            ]
        );

        $formData = $request->all();

        // Solo se l'utente ha caricato la cover image
        // if(isset($formData['cover_image'])) {
        if($request->hasFile('cover_image')) {
            // Upload del file nella cartella pubblica
            $img_path = Storage::disk('public')->put('post_images', $formData['cover_image']);
            // Salvare nella colonna cover_image del db il path all'immagine caricata
            $formData['cover_image'] = $img_path;
        }

        $newPost = new Post();
        $newPost->fill($formData);
        $newPost->slug = Str::slug($newPost->title, '-');
        $newPost->save();

        // "Attaccare" i tags scelti dall'utente al post creato
        if($request->has('tags')) {
            $newPost->tags()->attach($formData['tags']);
        }

        return redirect()->route('admin.posts.show', ['post' => $newPost->slug])->with('message', $newPost->title . ' successfully created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $categories = Category::all();
        $tags = Tag::all();

        return view('admin.posts.edit', compact('post', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $validated = $request->validate(
            [
                'title' => [
                    'required',
                    'min:5',
                    'max:150',
                    // 'unique:posts,title'
                    Rule::unique('posts')->ignore($post)
                ],
                'content' => 'nullable|min:10',
                'cover_image' => 'nullable|image|max:256',
                'category_id' => 'nullable|exists:categories,id',
                'tags' => 'nullable|exists:tags,id'
            ]
        );

        $formData = $request->all();
        // $formData['slug'] = Str::slug($formData['title'], '-');

        // Se l'utente ha caricato una nuova immagine
        if($request->hasFile('cover_image')) {
            // Se avevo già un'immagine caricata la cancello
            if($post->cover_image) {
                Storage::delete($post->cover_image);
            }

            // Upload del file nella cartella pubblica
            $img_path = Storage::disk('public')->put('post_images', $formData['cover_image']);
            // Salvare nella colonna cover_image del db il path all'immagine caricata
            $formData['cover_image'] = $img_path;
        }

        $post->slug = Str::slug($formData['title'], '-');
        $post->update($formData);

        if($request->has('tags')) {
            $post->tags()->sync($formData['tags']);
        } else {
            $post->tags()->detach();
        }

        return redirect()->route('admin.posts.show', ['post' => $post->slug])->with('message', $post->title . ' successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('admin.posts.index')->with('message', $post->title . ' successfully deleted.');
    }
}
