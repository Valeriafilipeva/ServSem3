<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use App\Events\ArticleCreated;
use Illuminate\Support\Facades\Cache;


use Illuminate\Http\Request;
use App\Notifications\ArticleCreatedNotification;


class ArticleController extends Controller
{
    public function index()
    {
        //$articles = Article::paginate(10);
        
        $articles = Cache::remember('articles_page_' . request('page', 1), 60, function () {
            return Article::paginate(perPage: 10);
        });
       
        if(auth()->user()->role == 'moderator'){
           
            return view('article.add', compact('articles'));
            //  это функция PHP, которая создает массив с ключом articles
        }
        return view('article.index', compact('articles'));
    }

    public function create()
    {

        $categories = Category::all(); // Получаем все категории
    return view('article.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'shortDesc' => 'required|string',
            'desc' => 'required|string',
        ]);

        $article =  Article::create($request->all());
        Cache::forget('articles_page_' . request('page', 1));
        // Первый аргумент 'page'указывает, что мы ищем значение параметра запроса с именем «страница».
        // Второй аргумент 1имеет значение по умолчанию, если параметр «страница» не найден в запросе.

        $users = User::all();
        foreach ($users as $user) {
            $user->notify(new ArticleCreatedNotification($article));
            //  метод уведомляет пользователя о создании новых статей.
        }
        broadcast(new ArticleCreated($article));
        // Метод broadcast()отправляет это событие всем подключенным клиентам.


        return redirect()->route('article.index')->with('success', 'Новость создана.');
    }

    public function show($id)
    {
       
        //$articles = Article::findOrFail($id);
        $articles = Article::findOrFail($id);
        if(auth()->user()->role == 'user'){
            $articles->comments = $articles->comments->where('approved', true);
            // Присваивает эти отфильтрованные комментарии к свойству comments статьи
        }
        
        auth()->user()->unreadNotifications
        //  получает все непрочитанные уведомления ( auth()->user()->unreadNotifications).
        ->where('data.id', $id)
        ->markAsRead();
         
        return view('article.show', compact('articles'));
    }
    public function edit(Article $article)
    {
        return view('article.edit', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'shortDesc' => 'required|string',
        ]);

        $article->update($request->all());
        Cache::forget('article_' . $article->id);
        Cache::forget('articles_page_' . request('page', 1));

        return redirect()->route('article.index')->with('success', 'Новость обновлена.');
    }

    public function destroy(Article $article)
    {
        $article->delete();
        Cache::forget('article_' . $article->id);
        Cache::forget('articles_page_' . request('page', 1));


        return redirect()->route('article.index')->with('success', 'Новость удалена.');
    }
}
