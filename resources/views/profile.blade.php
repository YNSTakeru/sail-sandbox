<x-guest-layout>
    <div class="profile-page">
        <div class="user-info">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-md-10 offset-md-1">
                        <img src="{{ $user->avatar }}" class="user-img" />
                        <h4>{{ $user->name }}</h4>
                        <p>
                            {{-- 後ほどsettingsで設定 --}}
                            Cofounder @GoThinkster, lived in Aol's HQ for a few months, kinda looks like Peeta from
                            the Hunger Games
                        </p>
                        <button class="btn btn-sm btn-outline-secondary action-btn">
                            <i class="ion-plus-round"></i>
                            &nbsp; Follow {{ $user->name }}
                        </button>
                        <button class="btn btn-sm btn-outline-secondary action-btn">
                            <i class="ion-gear-a"></i>
                            {{-- 後ほどsettingsで設定 --}}
                            &nbsp; Edit Profile Settings
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-md-10 offset-md-1">
                    <div class="articles-toggle">
                        <ul class="nav nav-pills outline-active">
                            <li class="nav-item">
                                <a class="nav-link active" href="{{ route('profile', ['id' => $user->id]) }}">My
                                    Articles</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="">
                                    {{-- 後ほど設定 --}}
                                    Favorited Articles
                                </a>
                            </li>
                        </ul>
                    </div>
                    @foreach ($articles as $article)
                        <div class="article-preview">
                            <div class="article-meta">
                                <a href="/profile/{{ $user->id }}"><img src="{{ $user->avatar }}" /></a>
                                <div class="info">
                                    <a href="/profile/{{ $user->id }}" class="author">{{ $user->name }}</a>
                                    <span class="date">{{ $article->created_at }}</span>
                                </div>
                                <button class="btn btn-outline-primary btn-sm pull-xs-right">
                                    <i class="ion-heart"></i> {{ $article->favorite_count }}
                                </button>
                            </div>
                            <a href="{{ route('articles.show', ['id' => $article->id]) }}" class="preview-link">
                                <h1>{{ $article->title }}</h1>
                                <p>{{ $article->abstract }}</p>
                                <span>Read more...</span>
                                <ul class="tag-list">
                                    @php
                                        $newArticleTags = $articleTags->where('article_id', $article->id);
                                    @endphp
                                    @foreach ($newArticleTags as $tag)
                                        <li class="tag-default tag-pill tag-outline">{{ $tag->tag_id }}</li>
                                    @endforeach
                                </ul>
                            </a>
                        </div>
                    @endforeach

                    {{ $articles->links() }}
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
