<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Message</title>

    <style>
        /* CSS styles go here */
        body {
            font-family: Arial, sans-serif;
            line-height: 1.5;
            color: #333333;
        }

        h1 {
            font-size: 24px;
        }

        p {
            margin-bottom: 10px;
        }

        a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            border-radius: 4px;
        }

        .button-primary {
            background-color: #007bff;
            color: #ffffff;
        }

        .button-success {
            background-color: #28a745;
            color: #ffffff;
        }

        .button-error {
            background-color: #dc3545;
            color: #ffffff;
        }

        .subcopy {
            font-size: 14px;
            color: #666666;
            margin-top: 10px;
        }

        .break-all {
            word-break: break-all;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #dddddd;
            border-radius: 4px;
        }
    </style>
</head>

<body>
    <div class="email-container">
        {{-- Greeting --}}
        @if (!empty($greeting))
        <h1>{{ $greeting }}</h1>
        @else
        @if ($level === 'error')
        <h1>Whoops!</h1>
        @else
        <h1>Hello!</h1>
        @endif
        @endif

        {{-- Intro Lines --}}
        @foreach ($introLines as $line)
        <p>{{ $line }}</p>
        @endforeach

        {{-- Action Button --}}
        @isset($actionText)
        <?php
        $color = match ($level) {
            'success', 'error' => $level,
            default => 'primary',
        };
        ?>
                        <a href="{{ $actionUrl }}" class="button-{{ $color }}">{{ $actionText }}</a>
        @endisset

        {{-- Outro Lines --}}
        @foreach ($outroLines as $line)
        <p>{{ $line }}</p>
        @endforeach

        {{-- Salutation --}}
        @if (!empty($salutation))
        <p>{{ $salutation }}</p>
        @else
        <p>Regards,<br>{{ config('app.name') }}</p>
        @endif

        {{-- Subcopy --}}
        @isset($actionText)
        <p class="subcopy">
            If you're having trouble clicking the "{{ $actionText }}" button, copy and paste the URL below into your web browser:
            <br>
            <span class="break-all">{{ $displayableActionUrl }}</span>
        </p>
        @endisset
    </div>
</body>

</html>
