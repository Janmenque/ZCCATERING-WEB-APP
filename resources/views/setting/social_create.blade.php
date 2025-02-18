<x-back-template>
    <x-slot:title>Social Media</x-slot:title>

    <div class='card text-bg-secondary'>
        <div class='card-body'>
            <form action='{{ route('setting_social_store') }}' method='post'>
                @csrf
                <div class='row'>
                    <div class='col-sm-6 mb-3'>
                        <label>Facebook</label>
                        <input type='text' name='facebook' class='form-control'
                            value='{{ config('settings')->facebook }}' placeholder='https://'>
                    </div>
                    <div class='col-sm-6 mb-3'>
                        <label>Twitter</label>
                        <input type='text' name='twitter' class='form-control'
                            value='{{ config('settings')->twitter }}' placeholder='https://'>
                    </div>
                    <div class='col-sm-6 mb-3'>
                        <label>Youtube</label>
                        <input type='text' name='youtube' class='form-control'
                            value='{{ config('settings')->youtube }}' placeholder='https://'>
                    </div>
                    <div class='col-sm-6 mb-3'>
                        <label>Instagram</label>
                        <input type='text' name='instagram' class='form-control'
                            value='{{ config('settings')->instagram }}' placeholder='https://'>
                    </div>

                </div>

                <input type='submit' name='save' value='Save' class='btn btn-primary'>
            </form>
        </div>
    </div>

</x-back-template>