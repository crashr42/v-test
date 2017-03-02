<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Raleway', sans-serif;
            font-weight: 100;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .short-url-form > input {
            color: #636b6f;
            padding: 10px 25px;
            font-size: 16px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            border: 1px solid #eeeeee;
        }

        .short-url-form > button[type=submit] {
            border: 1px solid #eeeeee;
            font-size: 16px;
            height: 100%;
            padding: 10px;
        }

        .m-b-md {
            margin-bottom: 30px;
        }

        #short-url {
            margin: 20px 0;
        }
    </style>
</head>
<body>
<div class="flex-center position-ref full-height">
    <div class="content">
        <div class="title m-b-md">
            URL SHORTER
        </div>

        <form class="short-url-form" action="{!! route('root_path') !!}">
            <input type="text" name="long_url" placeholder="Enter long url" value="{{$longUrl}}"/>
            <button type="submit">OK</button>
        </form>

        <div id="short-url">
            @if($shortUrl !== null)
                <a href="{{$shortUrl}}">{{$shortUrl}}</a>
            @endif
        </div>
    </div>
</div>
</body>
</html>
