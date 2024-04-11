 <x-guest-layout>
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
     <script>
         window.onload = function() {
             window.location.hash = '#/';
             history.replaceState('#/', document.title, window.location.pathname);
         };
     </script>
     <script src="{{ asset('/js/home/popularTagBtn.js') }}"></script>
 </x-guest-layout>
