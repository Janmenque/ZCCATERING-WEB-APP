<x-log-template>
    <x-slot:title>Login</x-slot:title>

    <form action="{{ route('login') }}" class="signin-form" method='post'>
        @csrf
        <div class="form-group mb-3">
            <label class="label" for="name">Email</label>
            <input type="email" class="form-control" placeholder="Email" required
                name='email' value="{{ old('email') }}">
        </div>
        <div class="form-group mb-3">
            <label class="label" for="password">Password</label>
            <input type="password" class="form-control" placeholder="Password" required
                name='password'>
        </div>
        <div class="form-group">
            <button type="submit" class="form-control btn btn-primary rounded submit px-3">Sign
                In</button>
        </div>
        <div class="form-group d-md-flex">
            <div class="w-50 text-left">
                <label class="checkbox-wrap checkbox-primary mb-0">Remember Me
                    <input type="checkbox" name="remember">
                    <span class="checkmark"></span>
                </label>
            </div>
            <div class="w-50 text-md-right">
                <a href="{{ route('password.request') }}">Forgot Password</a>
            </div>
        </div>
    </form>
    <p class="text-center">Not a member? <a href="{{ route('register') }}">Sign Up</a></p>

</x-log-template>
