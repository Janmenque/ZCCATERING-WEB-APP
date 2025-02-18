<x-back-template>
    <x-slot:title>Save Address</x-slot:title>

    <div class="card">
        <div class='card-body'>
            <form action='{{ route('address_store') }}' method='post'>
                @csrf
                @if($id != '--')
                <input type='hidden' name='address_id' value='{{ $id }}'>
                @endif
                <div class='row'>
                    <div class='mb-3 col-12'>
                        <label>Title*</label>
                        <input type='text' name='title' class='form-control' required
                            value='{{ old('title') ?? @$info->title }}'>
                    </div>
                    <div class='mb-3 col-12'>
                        <label>State*</label>
                        <input type='text' name='state' class='form-control' required
                            value='{{ old('state') ?? @$info->state }}'>
                    </div>
                    <div class='mb-3 col-12'>
                        <label>City*</label>
                        <input type='text' name='city' class='form-control' required
                            value='{{ old('city') ?? @$info->city }}'>
                    </div>

                    <div class='mb-3 col-12'>
                        <label>Address*</label>
                        <textarea name='address' class='form-control' required>{{ old('address') ?? @$info->address }}</textarea>
                    </div>

                </div>
                <input class='btn btn-primary' type='submit' value='Save' name='save'>
            </form>
        </div>
    </div>


</x-back-template>
