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
