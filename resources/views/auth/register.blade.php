<x-guest-layout>
    <div class="auth-page">
        <div class="container page">
            <div class="row">
                <div class="col-md-6 offset-md-3 col-xs-12">
                    <h1 class="text-xs-center">Sign up</h1>
                    <p class="text-xs-center">
                        <a href="/login">Have an account?</a>
                    </p>

                    <x-input-error :messages="$errors->get('name')"></x-input-error>
                    <x-input-error :messages="$errors->get('email')"></x-input-error>
                    <x-input-error :messages="$errors->get('password')"></x-input-error>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <fieldset class="form-group">
                            <x-text-input id="name" class="form-control-lg" type="text" name="name"
                                :value="old('name')" required autofocus autocomplete="name" placeholder="Username" />
                        </fieldset>
                        <fieldset class="form-group">
                            <x-text-input id="email" class="form-control-lg" type="email" name="email"
                                :value="old('email')" required autocomplete="email" placeholder="Email" />
                        </fieldset>
                        <fieldset class="form-group">
                            <x-text-input id="password" class="form-control-lg" type="password" name="password"
                                required autocomplete="new-password" placeholder="Password" />
                        </fieldset>
                        <x-primary-button class="pull-xs-right">Sign up</x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
