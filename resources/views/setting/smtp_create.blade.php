<x-back-template>
    <x-slot:title>SMTP</x-slot:title>

    <div class='card text-bg-secondary'>
        <div class='card-body'>
            <form action='{{ route('smtp_store') }}' method='post'>
                @csrf
                <div class='row'>
                    <div class='col-sm-12 mb-3'>
                        <label>Mailer*</label>
                        <input type='text' name='mailer' class='form-control' value='{{ env('MAIL_MAILER') }}' required>
                    </div>
                    <div class='col-sm-12 mb-3'>
                        <label>Host*</label>
                        <input type='text' name='host' class='form-control' value='{{ env('MAIL_HOST') }}'
                            required>
                    </div>

                <div class='col-sm-12 mb-3'>
                    <label>Port*</label>
                    <input type='text' name='port' class='form-control' value='{{ env('MAIL_PORT') }}' required>
                </div>
                <div class='col-sm-12 mb-3'>
                    <label>Username*</label>
                    <input type='text' name='username' class='form-control' value='{{ env('MAIL_USERNAME') }}'
                        required>
                </div>
                <div class='col-sm-12 mb-3'>
                    <label>Password*</label>
                    <input type='password' name='password' class='form-control' value='{{ env('MAIL_PASSWORD') }}'
                        required>
                </div>
                <div class='col-sm-12 mb-3'>
                    <label>From Address*</label>
                    <input type='text' name='from_address' class='form-control'
                        value='{{ env('MAIL_FROM_ADDRESS') }}' required placeholder="example@mail.com">
                </div>
                <div class='col-sm-12 mb-3'>
                    <label>Encryption*</label>
                    <input type='text' name='encryption' class='form-control' value='{{ env('MAIL_ENCRYPTION') }}'
                        required>
                </div>
                </div>

                <input type='submit' name='save' value='Save' class='btn btn-primary'>
            </form>
        </div>
    </div>
    
</x-back-template>