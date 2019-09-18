# ValidateMailgunMiddleware
Middleware to Validate Mailgun Webhook


Add the following to your config/mail.php file
```
'webhook' => ['signing_key' => env('MAILGUN_WEBHOOK_KEY')],
```

Add the API Key to your .env file
```
MAILGUN_WEBHOOK_KEY=
```

make sure you disable CSRF protection for the mailgun webhook URI by adding the following to app\Http\Middleware\VerifyCsrfToken.php
```
protected $except = ['/Mailgun-Webhook-Uri'];
```

then just move the ValidateMailgun.php file to your app/Http/Middleware folder and add the middleware to your route in routes/web.php
```
Route::middleware(['validateMailgun'])->group(function() {
    Route::post('/Mailgun-Webhook-Uri', 'InboundEmailController@receive');
});
```
