<x-guest-layout>
    <div class="settings-page">
        <div class="container page">
            <div class="row">
                <div class="col-md-6 offset-md-3 col-xs-12">
                    <h1 class="text-xs-center">Your Settings</h1>

                    <x-input-error :messages="$errors->get('avatar')"></x-input-error>
                    <x-input-error :messages="$errors->get('name')"></x-input-error>
                    <x-input-error :messages="$errors->get('bio')"></x-input-error>
                    <x-input-error :messages="$errors->get('email')"></x-input-error>
                    <x-input-error :messages="$errors->get('password')"></x-input-error>

                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        <fieldset>
                            <fieldset class="form-group">
                                <input class="form-control" type="text" placeholder="URL of profile picture"
                                    @if ($user->avatar) value="{{ old('avatar', $user->avatar) }}" @endif
                                    name="avatar" />
                            </fieldset>
                            <fieldset class="form-group">
                                <input class="form-control form-control-lg" type="text" placeholder="Your Name"
                                    value="{{ old('name', $user->name) }}" name="name" />
                            </fieldset>
                            <fieldset class="form-group">
                                <textarea class="form-control form-control-lg" rows="8" placeholder="Short bio about you" name="bio">{{ old('bio', $profile->bio) }}</textarea>
                            </fieldset>
                            <fieldset class="form-group">
                                <input class="form-control form-control-lg" type="text" placeholder="Email"
                                    value="{{ old('email', $user->email) }}" name="email" />
                            </fieldset>
                            <fieldset class="form-group">
                                <input class="form-control form-control-lg" type="password" placeholder="New Password"
                                    value="{{ old('password') }}" name="password" />
                            </fieldset>
                            <x-primary-button class="pull-xs-right">Update Settings</x-primary-button>
                        </fieldset>
                    </form>
                    <hr />
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger">Or click here to logout.</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
