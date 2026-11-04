<?php

use Illuminate\Http\Request;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AlbumController;
use App\Http\Controllers\Api\OptionController;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\Page\PageController;
use App\Http\Controllers\Api\AuditTrailController;
use App\Http\Controllers\Api\AiAssistantController;
use App\Http\Controllers\Api\LayoutPresetController;
use App\Http\Controllers\Api\WebsiteSettingController;
use App\Http\Controllers\Api\ArticleCategoryController;
use App\Http\Controllers\Api\Page\PublicPageController;
use App\Http\Controllers\Api\PublicLegalController;
use App\Http\Controllers\Api\PermissionMatrixController;
use App\Http\Controllers\Api\DomainLookupController;
use App\Http\Controllers\Api\AccountController;
use App\Http\Controllers\Api\CmsHelpProgressController;

Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AccountController::class, 'me']);
    Route::get('/cms-help/progress', [CmsHelpProgressController::class, 'index']);
    Route::put('/cms-help/progress/{guideId}', [CmsHelpProgressController::class, 'upsert']);
    Route::post('/user/profile', [AccountController::class, 'updateProfile']);
    Route::put('/user/email', [AccountController::class, 'updateEmail']);
    Route::put('/user/password', [AccountController::class, 'updatePassword']);

    Route::middleware('cms.portal')->group(function () {
        // dashboard
        Route::get('/dashboard/stats', [DashboardController::class, 'stats']);

    // pages
    Route::get('/pages-switcher', [PageController::class, 'switcherList']);
    Route::get('/pages', [PageController::class, 'index']);
    Route::post('/pages', [PageController::class, 'store']);
    Route::get('/pages/{id}', [PageController::class, 'show']);
    Route::put('/pages/{id}', [PageController::class, 'update']);
    Route::patch('/pages/{id}', [PageController::class, 'update']);
    Route::delete('/pages/{id}', [PageController::class, 'destroy']);
    Route::post('/pages/restore', [PageController::class, 'restore']);
    Route::get('/pages-menu', [PageController::class, 'pages_menu']);

    // albums
    Route::apiResource('albums', AlbumController::class);
    Route::post('/albums/{album}/save', [AlbumController::class, 'update']);
    Route::post('/albums/restore', [AlbumController::class, 'restore']);
    Route::post('/albums/{id}/restore', [AlbumController::class, 'restoreById']);

    // fetch animations
    Route::get('/options', [OptionController::class, 'index']);

    // menus
    Route::apiResource('menus', MenuController::class);
    Route::patch('/menus/{menu}/activate', [MenuController::class, 'setActive']);
    Route::post('/menus/restore', [MenuController::class, 'restore']);
    Route::post('/menus/{id}/restore', [MenuController::class, 'restoreById']);

    // article categories
    Route::get('/article-categories', [ArticleCategoryController::class, 'index']);
    Route::post('/article-categories', [ArticleCategoryController::class, 'store']);
    Route::post('/article-categories/delete', [ArticleCategoryController::class, 'delete']);
    Route::post('/article-categories/restore', [ArticleCategoryController::class, 'restore']);
    Route::post('/article-categories/{id}/restore', [ArticleCategoryController::class, 'restoreById']);
    Route::get('/article-categories/{category}', [ArticleCategoryController::class, 'show']);
    Route::put('/article-categories/{category}', [ArticleCategoryController::class, 'update']);

    // Compatibility endpoint used by some frontends
    // e.g. GET /api/categories?type=product
    Route::get('/categories', function (Request $request) {
        $type = $request->input('type');

        if ($type === 'article') {
            return app(ArticleCategoryController::class)->index($request);
        }

        return response()->json([
            'message' => 'Unknown category type',
            'allowed' => ['article'],
        ], 404);
    });

    // articles
    Route::get('/articles', [ArticleController::class, 'index']);
    Route::get('/fetch-article-categories', [ArticleController::class, 'fetch_categories']);
    Route::post('/articles', [ArticleController::class, 'store']);
    Route::get('/articles/{article}', [ArticleController::class, 'show']);
    Route::post('/articles/{article}', [ArticleController::class, 'update']);
    Route::delete('/articles/{article}', [ArticleController::class, 'destroy']);
    Route::post('/articles/restore', [ArticleController::class, 'restore']);
    Route::post('/articles/{id}/restore', [ArticleController::class, 'restoreById']);
    Route::post('/articles/{article}/duplicate', [ArticleController::class, 'duplicate']);

    // users
    Route::post('/users', [UserController::class, 'store']);
    Route::get('/fetch_roles', [UserController::class, 'fetch_roles']);
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{user}', [UserController::class, 'show']);
    Route::put('/users/{user}', [UserController::class, 'update']);

    // audit
    Route::get('/audit-trails', [AuditTrailController::class, 'index']);

    // website settings
    Route::get('/website-settings', [WebsiteSettingController::class, 'show']);

    Route::post('/website-settings/website', [WebsiteSettingController::class, 'updateWebsite']);
    Route::post('/website-settings/contact', [WebsiteSettingController::class, 'updateContact']);
    Route::post('/website-settings/privacy', [WebsiteSettingController::class, 'updatePrivacy']);

    Route::get('/website-settings/social', [WebsiteSettingController::class, 'getSocials']);
    Route::post('/website-settings/social', [WebsiteSettingController::class, 'updateSocials']);

    // roles
    Route::get('/roles', [RoleController::class, 'index']);
    Route::post('/roles', [RoleController::class, 'store']);
    Route::put('/roles/{role}', [RoleController::class, 'update']);
    Route::delete('/roles/{role}', [RoleController::class, 'destroy']);

    // access right
    Route::get('/permissions/matrix', [PermissionMatrixController::class, 'index']);
    Route::post('/permissions/sync', [PermissionMatrixController::class, 'sync']);

    // ai assistant
    Route::post('/ai/page-assistant', [AiAssistantController::class, 'generate']);

    // layout presets
    Route::prefix('layout-presets')->group(function () {
        Route::get('/', [LayoutPresetController::class, 'index']);
        Route::post('/', [LayoutPresetController::class, 'store']);
        Route::put('/{id}', [LayoutPresetController::class, 'update']);
        Route::post('/{id}', [LayoutPresetController::class, 'update']);
        Route::delete('/{id}', [LayoutPresetController::class, 'destroy']);
        Route::post('/restore', [LayoutPresetController::class, 'restore']);
        Route::post('/{id}/restore', [LayoutPresetController::class, 'restoreById']);
    });

    // File Manager
    Route::prefix('file-manager')->group(function () {
        Route::get('initialize',         [\Alexusmai\LaravelFileManager\Controllers\FileManagerController::class, 'initialize']);
        Route::get('content',            [\Alexusmai\LaravelFileManager\Controllers\FileManagerController::class, 'content']);
        Route::get('tree',               [\Alexusmai\LaravelFileManager\Controllers\FileManagerController::class, 'tree']);
        Route::get('select-disk',        [\Alexusmai\LaravelFileManager\Controllers\FileManagerController::class, 'selectDisk']);
        Route::post('upload',            [\Alexusmai\LaravelFileManager\Controllers\FileManagerController::class, 'upload']);
        Route::post('create-directory',  [\Alexusmai\LaravelFileManager\Controllers\FileManagerController::class, 'createDirectory']);
        Route::post('rename',            [\Alexusmai\LaravelFileManager\Controllers\FileManagerController::class, 'rename']);
        Route::post('delete',            [\Alexusmai\LaravelFileManager\Controllers\FileManagerController::class, 'delete']);
        Route::post('paste',             [\Alexusmai\LaravelFileManager\Controllers\FileManagerController::class, 'paste']);
        Route::get('download',           [\Alexusmai\LaravelFileManager\Controllers\FileManagerController::class, 'download']);
        Route::get('thumbnails',         [\Alexusmai\LaravelFileManager\Controllers\FileManagerController::class, 'thumbnails']);
        Route::get('preview',            [\Alexusmai\LaravelFileManager\Controllers\FileManagerController::class, 'preview']);
        Route::get('url',                [\Alexusmai\LaravelFileManager\Controllers\FileManagerController::class, 'url']);
        Route::post('zip',               [\Alexusmai\LaravelFileManager\Controllers\FileManagerController::class, 'zip']);
        Route::post('unzip',             [\Alexusmai\LaravelFileManager\Controllers\FileManagerController::class, 'unzip']);
    });
    }); // cms.portal
}); // auth:sanctum

//public
Route::get('/public/pages/{slug}', [PublicPageController::class, 'show']);
Route::get('/public/legal/privacy', [PublicLegalController::class, 'privacy']);
Route::get('/public/menus/active', [PublicPageController::class, 'active']);
Route::get('/public/footer', [PublicPageController::class, 'footer']);
Route::get('/public/branding', [WebsiteSettingController::class, 'publicBranding']);

// Public search routes
// Back-compat aliases for frontend helpers expecting /search and /public/search
Route::get('/search', [SearchController::class, 'quickSearch']);
Route::get('/public/search', [SearchController::class, 'quickSearch']);

Route::get('/search/pages', [SearchController::class, 'searchPages']);
Route::get('/search/global', [SearchController::class, 'globalSearch']);
Route::get('/search/quick', [SearchController::class, 'quickSearch']);

Route::prefix('public-articles')->group(function () {
    Route::get('/', [PublicPageController::class, 'public_articles']);
    Route::get('/{slug}', [PublicPageController::class, 'public_articles_show']);
});
Route::get('/public-article-categories', [PublicPageController::class, 'public_article_categories']);
Route::get('/public-articles-archive', [PublicPageController::class, 'archive']);

Route::post('/contact', [PublicPageController::class, 'send']);

//DomainChecker
Route::get('/public/domains/check',[DomainLookupController::class, 'check'])->middleware('throttle:30,1');
Route::post('/domain-lookup', [DomainLookupController::class, 'search'])->name('domain.lookup.search');

