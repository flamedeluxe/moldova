<?php

use App\Services\Site\PublicationService;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            $news = (new PublicationService)->getPublications('news');
            $events = (new PublicationService)->getPublications('event', session('city'));

            if(request()->ajax()) {
                $data = match (request()->get('type')) {
                    'events' => $events,
                    default => $news,
                };
                return response()->json([
                    'data' => $data['items'],
                    'total' => $data['total']
                ]);
            }

            return response()->view('errors.404', [
                'categories' => $events['categories'],
                'events' => $events['items'],
                'news' => $news['items'],
                'news_total' => $news['total'],
                'events_total' => $events['total'],
                'eventDates' => $events['dates']
            ], 404);
        });
    })->create();
