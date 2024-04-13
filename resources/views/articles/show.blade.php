<x-guest-layout>
    <div class="article-page">
        <div class="banner">
            <div class="container">
                <h1>{{ $article->title }}</h1>

                <div class="article-meta">
                    <a href="{{ route('profile', ['id' => $user->id]) }}"><img src="{{ $user->avatar }}" /></a>
                    <div class="info">
                        <a href="{{ route('profile', ['id' => $user->id]) }}" class="author">{{ $user->name }}</a>
                        <span class="date">{{ $article->created_at }}</span>
                    </div>
                    <button class="btn btn-sm btn-outline-secondary">
                        <i class="ion-plus-round"></i>
                        &nbsp; {{ $user->name }} <span class="counter">(10)</span>
                    </button>
                    &nbsp;&nbsp;
                    <button class="btn btn-sm btn-outline-primary">
                        <i class="ion-heart"></i>
                        &nbsp; Favorite Post <span class="counter">(29)</span>
                    </button>
                    @if (Auth::id() == $user->id)
                        <form style="display: inline;" method="get"
                            action="{{ route('articles.edit', ['id' => $article->id]) }}">
                            <button class="btn btn-sm btn-outline-secondary">
                                <i class="ion-edit"></i> Edit Article
                            </button>
                        </form>
                        <form class="delete_{{ $article->id }}" style="display: inline;" method="post"
                            action="{{ route('articles.destroy', ['id' => $article->id]) }}">
                            @csrf
                            <button class="btn btn-sm btn-outline-danger">
                                <i class="ion-trash-a"></i> Delete Article
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <div class="container page">
            <div class="row article-content">
                <div class="col-md-12">
                    {{-- markdownを投稿できるように変更 --}}
                    <p>{{ $article->content }}</p>
                    <ul class="tag-list">
                        @foreach ($articleTags as $articleTag)
                            <li class="tag-default tag-pill tag-outline">{{ $articleTag->tag_id }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <hr />

            <div class="article-actions">
                <div class="article-meta">
                    <a href="{{ route('profile', ['id' => $user->id]) }}"><img src="{{ $user->avatar }}" /></a>
                    <div class="info">
                        <a href="{{ route('profile', ['id' => $user->id]) }}" class="author">{{ $user->name }}</a>
                        <span class="date">{{ $article->created_at }}</span>
                    </div>

                    <button class="btn btn-sm btn-outline-secondary">
                        <i class="ion-plus-round"></i>
                        &nbsp; Follow {{ $user->name }}
                    </button>
                    &nbsp;
                    <button class="btn btn-sm btn-outline-primary">
                        <i class="ion-heart"></i>
                        &nbsp; Favorite Article <span class="counter">({{ $article->favorite_count }})</span>
                    </button>
                    @if (Auth::id() == $user->id)
                        <form style="display: inline;" method="get"
                            action="{{ route('articles.edit', ['id' => $article->id]) }}">
                            <button class="btn btn-sm btn-outline-secondary">
                                <i class="ion-edit"></i> Edit Article
                            </button>
                        </form>
                        <form class="delete_{{ $article->id }}" style="display: inline;" method="post"
                            action="{{ route('articles.destroy', ['id' => $article->id]) }}">
                            @csrf
                            <button class="btn btn-sm btn-outline-danger">
                                <i class="ion-trash-a"></i> Delete Article
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <div class="row">
                @if (Auth::check())
                    <div class="col-xs-12 col-md-8 offset-md-2">
                        <form class="card comment-form" method="post"
                            action="{{ route('comments.store', ['id' => $article->id]) }}">
                            @csrf
                            <div class="card-block">
                                <textarea class="form-control" placeholder="Write a comment..." rows="3" name="content"></textarea>
                            </div>
                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                            <input type="hidden" name="article_id" value="{{ $article->id }}">
                            <div class="card-footer">
                                <img src="{{ $user->avatar }}" />
                                <button class="btn btn-sm btn-primary" type="submit">Post Comment</button>
                            </div>
                        </form>

                        @foreach ($comments as $comment)
                            <div class="card">
                                <div class="card-block">
                                    <p class="card-text">
                                        {{ $comment->content }}
                                    </p>
                                </div>
                                <div class="card-footer">
                                    <a href="{{ route('profile', ['id' => $comment->user_id]) }}"
                                        class="comment-author">
                                        <img src="{{ $comment->user_avatar }}" class="comment-author-img" />
                                    </a>
                                    &nbsp;
                                    <a href="{{ route('profile', ['id' => $comment->user_id]) }}"
                                        class="comment-author">{{ $comment->user_name }}</a>
                                    <span class="date-posted">{{ $comment->created_at }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
    <script>
        const $deleteForms = document.querySelectorAll('.delete_{{ $article->id }}');

        for (let i = 0; i < $deleteForms.length; i++) {
            $deleteForms[i].addEventListener('submit', (e) => {
                e.preventDefault();
                if (confirm('本当に削除しますか？')) {
                    e.target.submit();
                }
            });
        }
    </script>
</x-guest-layout>
