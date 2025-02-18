<x-log-template>
    <x-slot:title>Register</x-slot:title>

    <form action="{{ route('register') }}" class="signin-form" method='post'>
        @csrf
        <div class="form-group mb-3">
            <label class="label" for="name">Name*</label>
            <input type="text" class="form-control" placeholder="Your Name" required
                name='name' value="{{ old('name') }}">
        </div>
        <div class="form-group mb-3">
            <label class="label" for="name">Email*</label>
            <input type="email" class="form-control" placeholder="Email" required
                name='email' value="{{ old('email') }}">
        </div>
        <div class="form-group mb-3">
            <label class="label" for="password">Password*</label>
            <input type="password" class="form-control" placeholder="Password" required
                name='password' value="{{ old('password') }}">
        </div>
        <div class="form-group mb-3">
            <label class="label">Confirm Password*</label>
            <input type="password" class="form-control" placeholder="Confirm Password" required
                name='password_confirmation' value="{{ old('password_confirmation') }}">
        </div>
        <div class="form-group">
            <button type="submit" class="form-control btn btn-primary rounded submit px-3">Sign
                Up</button>
        </div>
    </form>
    <p class="text-center">Already registered? <a href="{{ route('login') }}">Sign In</a></p>

</x-log-template>
