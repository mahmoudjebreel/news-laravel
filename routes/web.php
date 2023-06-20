<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'WebsiteController@showHome')->name('home');

Route::get('/contact', function () {
    return view('website.contact_us');
})->name('contact');

Route::get('/category/{id}/news', 'WebsiteController@showCategoryArticles')->name('category.news');
Route::get('/news/{id}/details', 'WebsiteController@showArticleDetails')->name('news_details');

Route::prefix('/admin/')->group(function () {
    Route::get('login', 'Auth\AdminLoginController@showLoginForm')->name('admin.auth.login');
    Route::post('login', 'Auth\AdminLoginController@login')->name('admin.auth');
    Route::view('register', 'cms.auth.register')->name("admin.auth.register");
    Route::view('password/forget', 'cms.auth.forgot_password')->name("admin.auth.forgot_password");
    Route::view('password/recover', 'cms.auth.recover_password')->name("admin.auth.recover_password");
});

Route::prefix('/admin/')->middleware(['auth:admin'])->group(function () {
    Route::get('dashboard', 'CMS\CMSDashboardController@showAdminDashboard')->name("admin.dashboard");
    Route::get('logout', 'Auth\AdminLoginController@logout')->name("admin.logout");
    Route::view('lock', 'cms.auth.lock_screen')->name("admin.auth.lock_screen");
});

Route::resource('admins', 'CMS\AdminController')->middleware(['auth:admin']);

Route::prefix('/author/')->group(function () {
    Route::get('login', 'Auth\AuthorLoginController@showLoginForm')->name('author.auth.login');
    Route::post('login', 'Auth\AuthorLoginController@login')->name('author.auth');
    Route::view('register', 'author.auth.register')->name("author.auth.register");
    Route::view('password/forget', 'author.auth.forgot_password')->name("author.auth.forgot_password");
    Route::view('password/recover', 'author.auth.recover_password')->name("author.auth.recover_password");
});

Route::prefix('/author/')->middleware(['auth:author'])->group(function () {
    Route::view('', 'author.dashboard')->name("author.dashboard");
    Route::get('logout', 'Auth\AuthorLoginController@logout')->name("author.logout");
    Route::view('lock', 'author.auth.lock_screen')->name("author.auth.lock_screen");
});

Route::prefix('categories/')->namespace('CMS')->middleware(['auth:admin'])->group(function () {
    Route::get('', 'CategoryController@index')->name('admin.categories.index');
    Route::get('create/view', 'CategoryController@create')->name('admin.categories.create');
    Route::post('store', 'CategoryController@store')->name('admin.categories.store');
    Route::get('{id}', 'CategoryController@show');
    Route::get('{id}/articles', 'CategoryController@showArticles')->name('admin.category.articles');
    Route::get('{id}/edit', 'CategoryController@edit')->name('admin.categories.edit');
    Route::put('{id}/update', 'CategoryController@update')->name('admin.categories.update');
    Route::get('{id}/delete', 'CategoryController@destroy')->name('admin.categories.destroy');
});

Route::prefix('articles')->namespace('CMS')->middleware(['auth:admin'])->group(function () {
    Route::get('', 'ArticleController@index')->name('admin.articles.index');
    Route::get('create/view', 'ArticleController@create')->name('admin.articles.create');
    Route::post('store', 'ArticleController@store')->name('admin.articles.store');
    Route::get('{id}', 'ArticleController@show');
    Route::get('{id}/edit', 'ArticleController@edit')->name('admin.articles.edit');
    Route::put('{id}/update', 'ArticleController@update')->name('admin.articles.update');
    Route::get('{id}/delete', 'ArticleController@destroy')->name('admin.articles.destroy');
});

Route::prefix('authors/')->namespace('CMS')->middleware(['auth:admin'])->group(function () {
    Route::get('', 'AuthorController@index')->name('admin.authors.index');
    Route::get('create/view', 'AuthorController@create')->name('admin.authors.create');
    Route::post('store', 'AuthorController@store')->name('admin.authors.store');
    Route::get('{id}', 'AuthorController@show');
    Route::get('{id}/articles', 'AuthorController@showArticles')->name('admin.author.articles');
    Route::get('{id}/edit', 'AuthorController@edit')->name('admin.authors.edit');
    Route::put('{id}/update', 'AuthorController@update')->name('admin.authors.update');
    Route::get('{id}/delete', 'AuthorController@destroy')->name('admin.authors.destroy');
});

Route::get('test_email', function () {
//    \Illuminate\Support\Facades\Mail::to($request->user())->send(new OrderShipped($order));
    $article = \App\Article::find(1);
    \Illuminate\Support\Facades\Mail::to('momen.sisalem@gmail.com')->send(new \App\Mail\WelcomeEmail($article));
});


Route::get('article_mail', function () {
    $article = \App\Article::find(1);
    return new App\Mail\ArticleMaill($article);
});

Route::get('new_article_mail', function () {
    $article = \App\Article::find(1);
    return new App\Mail\NewArticleEmail($article);
});


Route::get('send_article_mail', function () {
    $article = \App\Article::find(1);
//    \Illuminate\Support\Facades\Mail::to('momen.sisalem@gmail.com')->send(new \App\Mail\ArticleMaill($article));
    \Illuminate\Support\Facades\Mail::to('momen.sisalem@gmail.com')->send(new \App\Mail\NewArticleEmail($article));
});
