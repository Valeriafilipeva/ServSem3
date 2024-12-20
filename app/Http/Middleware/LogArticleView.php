<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\ArticleView;

class LogArticleView
{
    
    public function handle(Request $request, Closure $next)
    {
        
        if ($request->is('article/*')) {
            ArticleView::create(['url' => $request->fullUrl()]);
            // Если URL соответствует этому шаблону, создается новый запись в таблице ArticleView с полем url, содержащим полный URL запроса.
        }

        return $next($request);
    }
}
