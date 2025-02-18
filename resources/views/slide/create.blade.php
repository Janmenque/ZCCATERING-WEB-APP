<x-back-template>
    <x-slot:title>Save Slide</x-slot:title>

    <div class="card">
        <div class='card-body'>
            <form action='{{ route('slide_store') }}' method='post' enctype="multipart/form-data">
                @csrf

                <div class='row'>

                    <div class='mb-3 col-12'>
                        <label>Pix</label>
                        <input type='file' name='pix' class='form-control'
                            required>
                    <small>1500x800px</small>
                    </div>
                </div>
                <input class='btn btn-primary' type='submit' value='Save' name='save'>
            </form>
        </div>
    </div>


</x-back-template>
