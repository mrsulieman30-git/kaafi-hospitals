<?php

use Illuminate\Support\Facades\Route;
use App\Models\Doctor;
use App\Models\BlogPost;
use App\Models\Page;

Route::get('/language/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'so'])) {
        session()->put('locale', $locale);
    }
    return redirect()->back();
})->name('language.switch');

Route::get('/', function () {
    $doctors = Doctor::with('department')->where('is_active', true)->inRandomOrder()->take(4)->get();
    return view('pages.home', compact('doctors'));
});

// Static pages can remain, or you can delete these and recreate them in your new Admin CMS!
Route::get('/about', function () { return view('pages.about'); });
Route::get('/contact', function () { return view('pages.contact'); });

Route::get('/departments', function () {
    return view('pages.departments.index');
})->name('departments.index');

Route::get('/departments/{slug}', function ($slug) {
    $department = \App\Models\Department::where('slug', $slug)->firstOrFail();
    return view('pages.departments.show', compact('department'));
})->name('departments.show');

Route::get('/doctor/{slug}', function ($slug) {
    $doctor = \App\Models\Doctor::where('slug', $slug)->firstOrFail();
    return view('pages.doctor', compact('doctor'));
})->name('doctor.show');

Route::get('/doctors/{doctor}', \App\Livewire\DoctorProfile::class)->name('doctors.profile');
Route::get('/book-appointment/{doctor?}', \App\Livewire\BookAppointment::class)->name('book.appointment');


Route::get('/doctors', \App\Livewire\DoctorsIndex::class)->name('doctors.index');

// ── Blog Routes ──────────────────────────────────────────────
Route::get('/posts', \App\Livewire\BlogIndex::class)->name('blog.index');
Route::get('/posts/{slug}', \App\Livewire\BlogPostShow::class)->name('blog.show');
Route::get('/blog', \App\Livewire\BlogIndex::class); // Redirect/Alias for convenience

Route::get('/blog/{slug}', function ($slug) {
    $post = BlogPost::with(['category', 'comments' => function ($q) {
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

// ── Offers ──
Route::get('/offers', \App\Livewire\OffersIndex::class)->name('offers.index');

// ── Appointment ──────────────────────────────────────────────
Route::get('/appointment', function () {
    return view('pages.appointment.index');
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

// ── DYNAMIC CMS Catch-All Route ──────────────────────────────
// This MUST be at the very bottom. It catches any URL not defined above.
Route::get('/{slug}', function ($slug) {
    $page = Page::where('slug', $slug)->where('is_published', true)->firstOrFail();
    return view('pages.dynamic', compact('page'));
})->name('page.show');
