<?php

use Illuminate\Support\Facades\Route;
use App\Models\Doctor;
use App\Models\BlogPost;

Route::get('/', function () {
    $doctors = Doctor::with('department')->where('is_active', true)->take(4)->get();
    return view('pages.home', compact('doctors'));
});

Route::get('/about', function () {
    return view('pages.about');
});

Route::get('/departments', function () {
    return view('pages.departments.index');
});

Route::get('/doctor/{slug}', function ($slug) {
    $doctor = Doctor::where('slug', $slug)->firstOrFail();
    return view('pages.doctor', compact('doctor'));
})->name('doctor.show');

Route::get('/doctors', function () {
    $doctors = Doctor::with('department')->where('is_active', true)->get();
    return view('pages.doctors.index', compact('doctors'));
});

// ── Blog Routes ──────────────────────────────────────────────
Route::get('/blog', function () {
    $posts = BlogPost::with(['category', 'user', 'comments'])
        ->where('is_published', true)
        ->orderBy('published_at', 'desc')
        ->paginate(9);
    return view('pages.blog.index', compact('posts'));
});

Route::get('/blog/{slug}', function ($slug) {
    $post = BlogPost::with(['category', 'user', 'comments' => function ($q) {
        $q->where('is_approved', true)->orderBy('created_at', 'desc');
    }])->where('slug', $slug)
      ->where('is_published', true)
      ->firstOrFail();

    $relatedPosts = BlogPost::where('is_published', true)
        ->where('id', '!=', $post->id)
        ->when($post->blog_category_id, fn ($q) => $q->where('blog_category_id', $post->blog_category_id))
        ->orderBy('published_at', 'desc')
        ->take(3)
        ->get();

    return view('pages.blog.show', compact('post', 'relatedPosts'));
})->name('blog.show');

// ── Appointment ──────────────────────────────────────────────
Route::get('/appointment', function () {
    return view('pages.appointment.index');
});

Route::get('/contact', function () {
    return view('pages.contact');
});

// ── Sitemap ──────────────────────────────────────────────────
Route::get('/sitemap.xml', function () {
    $doctors = Doctor::where('is_active', true)->get();
    $departments = \App\Models\Department::where('is_active', true)->get();
    $posts = BlogPost::where('is_published', true)->get();

    return response()->view('sitemap', [
        'doctors' => $doctors,
        'departments' => $departments,
        'posts' => $posts,
    ])->header('Content-Type', 'text/xml');
});
