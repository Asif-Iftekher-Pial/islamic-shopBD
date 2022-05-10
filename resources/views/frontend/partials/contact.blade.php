<div class="d-flex align-items-center text-reset h-100">
    <div class="d-block">
        @auth
            @if(isAdmin())
            <div class="d-flex">
                <span class="d-block opacity-70 font-weight-bold">
                    <a href="{{ route('admin.dashboard') }}" class="text-reset">Hi! {{ Auth::user()->name }}</a>
                </span>
            </div>
            @else
            <div class="d-flex">
                <span class="d-block opacity-70 font-weight-bold">
                    <a href="{{ route('dashboard') }}" class="text-reset">Hi! {{ Auth::user()->name }}</a>
                </span>
            </div>
            @endif
            <div class="d-flex">
                <span class="d-block opacity-70 font-weight-bold">
                    <a href="{{ route('logout') }}" class="text-reset">{{ translate('Logout')}}</a>
                </span>
            </div>
        @else
            @if (get_setting('vendor_system_activation') == 1)
            <div class="d-flex">
                <span class="d-block opacity-70 font-weight-bold">
                    <a href="{{ route('shops.create') }}" class="text-reset">Sell on {{ env('APP_NAME') }}</a>
                </span>
            </div>
            @endif
            <div class="d-flex">
                <span class="d-block opacity-70 font-weight-bold">
                    <a href="{{ route('user.login') }}" class="text-reset">{{ translate('My Account')}}</a>
                </span>
            </div>
        @endauth
    </div>
</div>