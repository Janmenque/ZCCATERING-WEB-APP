<x-back-template>
    <x-slot:title>General Settings</x-slot:title>

    <div class="card">
        <div class='card-body'>
            <form action='{{ route('setting_store') }}' method='post' enctype="multipart/form-data">
                @csrf

                <div class='row'>
                    <div class='mb-3 col-12'>
                        <label>Site Name*</label>
                        <input type='text' name='name' class='form-control' required value='{{ $info->name }}'>
                    </div>
                    <div class='mb-3 col-12'>
                        <label>Slogan</label>
                        <input type='text' name='slogan' class='form-control' value='{{ $info->slogan }}'>
                    </div>
                    <div class='mb-3 col-6'>
                        <label>Email*</label>
                        <input type='email' name='email' class='form-control' required value='{{ $info->email }}'>
                    </div>
                    <div class='mb-3 col-6'>
                        <label>Phone</label>
                        <input type='text' name='tell' class='form-control' value='{{ $info->tell }}'>
                    </div>
                    <div class='mb-3 col-12'>
                        <label>Address</label>
                        <textarea name='address' class='form-control'>{{ $info->address }}</textarea>
                    </div>
                    <div class='mb-3 col-12'>
                        <label>Currency*</label>
                        <input type='text' name='currency' class='form-control' required value='{{ $info->currency }}'>
                    </div>
                    <div class='mb-3 col-12'>
                        <label>About section title</label>
                        <input type='text' name='home_about_title' class='form-control' value='{{ $info->home_about_title }}'>
                    </div>
                    <div class='mb-3 col-12'>
                        <label>About section text</label>
                        <textarea name='home_about' class='form-control'>{{ $info->home_about }}</textarea>
                    </div>
                    <div class='mb-3 col-6'>
                        <label>About image</label>
                        <input type='file' class='form-control' name='home_about_pix'>
                        <img src='{{ url('public/images/'.config('settings.home_about_pix')) }}' width='300' class='img-fluid'><br />
                        <small>540x507px</small>
                    </div>
                    <div class='mb-3 col-6'>
                        <label>Login page image</label>
                        <input type='file' class='form-control' name='log_back'>
                        <img src='{{ url('public/images/'.config('settings.log_back')) }}' width='300' class='img-fluid'><br />
                        <small>1000x1050px</small>
                    </div>

                </div>
                <input class='btn btn-primary' type='submit' value='Save' name='save'>
            </form>
        </div>
    </div>


</x-back-template>
