<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <title>Conduit</title>
    <!-- Import Ionicon icons & Google Fonts our Bootstrap theme relies on -->
    <link href="//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <link
        href="//fonts.googleapis.com/css?family=Titillium+Web:700|Source+Serif+Pro:400,700|Merriweather+Sans:400,700|Source+Sans+Pro:400,300,600,700,300italic,400italic,600italic,700italic"
        rel="stylesheet" type="text/css" />
    <!-- Import the custom Bootstrap 4 theme from our hosted CDN -->
    <link rel="stylesheet" href="//demo.productionready.io/main.css" />
    <link rel="stylesheet" href="{{ asset('/css/custom.css') }}">
</head>

<body class="font-sans antialiased dark:bg-black dark:text-white/50">
    <header>
        <nav class="navbar navbar-light">
            <div class="container">
                <a class="navbar-brand" href="/">conduit</a>
                <ul class="nav navbar-nav pull-xs-right">
                    <li class="nav-item">
                        <!-- Add "active" class when you're on that page" -->
                        <a class="nav-link active" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/login">Sign in</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/register">Sign up</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <main>
        <div class="home-page">
            <div class="banner">
                <div class="container">
                    <h1 class="logo-font">conduit</h1>
                    <p>A place to share your knowledge.</p>
                </div>
            </div>

            <div class="container page">
                <div class="row">
                    <div class="col-md-9">
                        <div class="feed-toggle">
                            <ul class="nav nav-pills outline-active">
                                <li class="nav-item">
                                    <a class="nav-link" href="">Your Feed</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" href="">Global Feed</a>
                                </li>
                            </ul>
                        </div>
                        @foreach ($articles as $article)
                            @php $user = $users->where('id', $article->user_id)->first(); @endphp
                            @php
                                $tagsArticles = $articleTags->where('article_id', $article->id)->all();
                            @endphp

                            <div class="article-preview">
                                <div class="article-meta">
                                    <a href="/profile/eric-simons"><img src={{ $user->avatar }} /></a>
                                    <div class="info">
                                        <a href="/profile/eric-simons" class="author"> {{ $user->name }} </a>
                                        <span class="date">{{ $article->created_at }}</span>
                                    </div>
                                    <button class="btn btn-outline-primary btn-sm pull-xs-right">
                                        <i class="ion-heart"></i> {{ $article->favorite_count }}
                                    </button>
                                </div>
                                <a href="/article/how-to-build-webapps-that-scale" class="preview-link">
                                    <h1>{{ $article->title }}</h1>
                                    <p>{{ $article->content }}</p>
                                    <div class="custom-article-footer">
                                        <span>Read more...</span>
                                        <ul class="tag-list custom-tag-list">
                                            @foreach ($tagsArticles as $tagsArticle)
                                                @php $tag = $tags->where('id', $tagsArticle->tag_id)->first(); @endphp
                                                <li class="tag-default tag-pill tag-outline custom-tag">
                                                    {{ $tagsArticle->tag_id }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </a>
                            </div>
                        @endforeach

                        {{ $articles->links() }}
                    </div>

                    <div class="col-md-3">
                        <div class="sidebar">
                            <p>Popular Tags</p>

                            <div class="tag-list">
                                @foreach ($favoriteTags as $favoriteTag)
                                    <button class="tag-pill tag-default">{{ $favoriteTag->tag_name }}</button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer>
        <div class="container">
            <a href="/" class="logo-font">conduit</a>
            <span class="attribution">
                An interactive learning project from <a href="https://thinkster.io">Thinkster</a>. Code &amp;
                design licensed under MIT.
            </span>
        </div>
    </footer>
    <script>
        window.onload = function() {
            window.location.hash = '#/';
        };
    </script>
    <script src="{{ asset('/js/home/popularTagBtn.js') }}"></script>
</body>

</html>
