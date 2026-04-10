<?php

namespace App\Http\Controllers;

use App\Classes\ReCaptcha;
use App\Models\BlogArticle;
use App\Models\BlogCategory;
use App\Models\BlogComment;
use App\Models\Faq;
use App\Models\HomeSection;
use App\Models\Language;
use App\Models\Page;
use App\Models\Setting;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;

class GeneralController extends Controller
{
    public function home()
    {
        $homeSections = Cache::remember('home_sections_active',
            now()->addDay(), function () {
                return HomeSection::active()->get();
            });
        return theme_view('home', ['homeSections' => HomeSection::active()->get()]);
    }

    public function page($slug)
    {
        $page = Page::where('slug', $slug)->firstOrFail();
        incrementViews($page, 'pages');
        return theme_view('page', ['page' => $page]);
    }

    public function faqs()
    {
        $faqs = Faq::paginate(10);
        return theme_view('faqs', ['faqs' => $faqs]);
    }

    public function contact()
    {
        return theme_view('contact');
    }

    public function contactSend(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'indisposable', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string'],
        ] + app(ReCaptcha::class)->validate());

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }

        try {
            $name = $request->name;
            $email = $request->email;
            $subject = $request->subject;
            $msg = purifier($request->message);

            \Mail::send([], [], function ($message) use ($msg, $email, $subject, $name) {
                $message->to(config('settings.general.contact_email'))
                    ->from(env('MAIL_FROM_ADDRESS'), $name)
                    ->replyTo($email)
                    ->subject($subject)
                    ->html($msg);
            });

            toastr()->success(d_trans('Your message has been sent successfully'));
            return back();
        } catch (Exception $e) {
            toastr()->error(d_trans('Error on sending'));
            return back();
        }
    }

    public function blog()
    {
        $blogArticles = BlogArticle::query();

        if (request()->has('search')) {
            $searchTerm = '%' . request('search') . '%';
            $blogArticles->where('title', 'like', $searchTerm)
                ->OrWhere('slug', 'like', $searchTerm)
                ->OrWhere('body', 'like', $searchTerm)
                ->OrWhere('description', 'like', $searchTerm)
                ->OrWhere('keywords', 'like', $searchTerm)
                ->orWhereHas('category', function ($query) use ($searchTerm) {
                    $query->where('name', 'like', $searchTerm)
                        ->OrWhere('title', 'like', $searchTerm)
                        ->OrWhere('slug', 'like', $searchTerm)
                        ->OrWhere('body', 'like', $searchTerm)
                        ->OrWhere('description', 'like', $searchTerm)
                        ->OrWhere('keywords', 'like', $searchTerm);
                });
        }

        $blogArticles = $blogArticles->orderbyDesc('id')->paginate(15);
        $blogArticles->appends(request()->only(['search']));

        return theme_view('blog.index', ['blogArticles' => $blogArticles]);
    }

    public function blogCategory($slug)
    {
        $blogCategory = BlogCategory::where('slug', $slug)->firstOrFail();
        incrementViews($blogCategory, 'blog_categories');

        $blogArticles = BlogArticle::where('blog_category_id', $blogCategory->id);

        if (request()->has('search')) {
            $searchTerm = '%' . request('search') . '%';
            $blogArticles->where(function ($query) use ($searchTerm) {
                $query->where('title', 'like', $searchTerm)
                    ->OrWhere('slug', 'like', $searchTerm)
                    ->OrWhere('body', 'like', $searchTerm)
                    ->OrWhere('description', 'like', $searchTerm)
                    ->OrWhere('keywords', 'like', $searchTerm);
            });
        }

        $blogArticles = $blogArticles->orderbyDesc('id')->paginate(15);
        $blogArticles->appends(request()->only(['search']));

        return theme_view('blog.category', [
            'blogCategory' => $blogCategory,
            'blogArticles' => $blogArticles,
        ]);
    }

    public function blogArticle($slug)
    {
        $blogArticle = BlogArticle::where('slug', $slug)->firstOrFail();
        incrementViews($blogArticle, 'blog_articles');

        $blogArticleComments = BlogComment::where('blog_article_id', $blogArticle->id)
            ->published()->get();

        return theme_view('blog.article', [
            'blogArticle' => $blogArticle,
            'blogArticleComments' => $blogArticleComments,
        ]);
    }

    public function blogComment(Request $request, $slug)
    {
        $blogArticle = BlogArticle::where('slug', $slug)->firstOrFail();

        $validator = Validator::make($request->all(), [
            'comment' => ['required', 'string', 'block_patterns'],
        ] + app(ReCaptcha::class)->validate());

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }

        $blogComment = new BlogComment();
        $blogComment->user_id = authUser()->id;
        $blogComment->blog_article_id = $blogArticle->id;
        $blogComment->body = $request->comment;
        $blogComment->save();

        $title = d_trans('New Blog Comment Waiting Review');
        $image = asset('images/notifications/comment.png');
        $link = route('admin.blog.comments.index');
        adminNotify($title, $image, $link);

        toastr()->success(d_trans('Your comment is under review it will be published soon'));
        return back();
    }

    public function localize($code)
    {
        $language = Language::where('code', $code)->firstOrFail();

        App::setLocale($language->code);
        Cookie::queue('locale', $language->code, 1440 * 30);
        Cookie::queue('direction', $language->direction, 1440 * 30);

        $previousUrl = url()->previous();
        if (str_contains($previousUrl, '/' . $code)) {
            return redirect()->to(str_replace('/' . $code, '', $previousUrl));
        }

        return redirect()->back();
    }

    public function cookie()
    {
        Cookie::queue('gdpr_cookie', true, 1440 * 30);
    }

    public function maintenance()
    {
        if (!config('settings.maintenance.status')) {
            return redirect()->route('home');
        }

        return view('vendor.maintenance');
    }

    public function cronjob(Request $request)
    {
        ini_set('max_execution_time', 0);

        if (config('settings.cronjob.key') && config('settings.cronjob.key') != $request->key) {
            return response()->json([
                'status' => 'error',
                'message' => d_trans('Invalid Cron Job Key'),
            ], 403);
        }

        try {
            Artisan::call('schedule:run');

            Setting::updateSettings('cronjob', ['last_execution' => Carbon::now()]);

            return response()->json([
                'status' => 'success',
                'message' => d_trans('Cron Job executed successfully'),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 200);
        }
    }
}