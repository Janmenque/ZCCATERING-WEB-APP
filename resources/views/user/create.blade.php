<x-back-template>
    <x-slot:title>Save Customer</x-slot:title>

    <div class="card">
        <div class='card-body'>
            <form action='{{ route('user_store') }}' method='post'>
                @csrf
                <input type='hidden' name='user_id' value='{{ $id }}'>
                <div class='row'>
                    <div class='mb-3 col-12'>
                        <label>Name*</label>
                        <input type='text' name='name' class='form-control' required
                            value='{{ old('name') ?? @$info->name }}'>
                    </div>
                    <div class='mb-3 col-12'>
                        <label>Email*</label>
                        <input type='email' name='email' class='form-control' required
                            value='{{ old('email') ?? @$info->email }}'>
                    </div>

                </div>
                <input class='btn btn-primary' type='submit' value='Save' name='save'>
            </form>
        </div>
    </div>


</x-back-template>
