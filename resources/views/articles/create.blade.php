<x-guest-layout>
    <div class="editor-page">
        <div class="container page">
            <div class="row">
                <div class="col-md-10 offset-md-1 col-xs-12">
                    <ul class="error-messages">
                        <li>That title is required</li>
                    </ul>

                    <x-input-error :messages="$errors->get('title')"></x-input-error>
                    <x-input-error :messages="$errors->get('content')"></x-input-error>
                    <x-input-error :messages="$errors->get('abstract')"></x-input-error>
                    <x-input-error :messages="$errors->get('tags')"></x-input-error>

                    <form method="POST" action="{{ route('articles.store') }}">
                        @csrf
                        <fieldset>
                            <fieldset class="form-group">
                                <x-text-input type="text" class="form-control-lg" placeholder="Article Title"
                                    :value="old('title')" />
                            </fieldset>
                            <fieldset class="form-group">
                                <x-text-input type="text" placeholder="What's this article about?"
                                    :value="old('abstract')" />
                            </fieldset>
                            <fieldset class="form-group">
                                <x-textarea rows="8" placeholder="Write your article (in markdown)"
                                    :value="old('content')"></x-textarea>
                            </fieldset>
                            <fieldset class="form-group">
                                <x-text-input id="tag-input" type="text" placeholder="Enter tags" />
                                <div class="tag-list">
                                </div>
                            </fieldset>
                            <x-primary-button class="pull-xs-right">
                                Publish Article
                            </x-primary-button>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('build/create.js') }}"></script>
</x-guest-layout>
