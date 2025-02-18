<x-back-template>
    <x-slot:title>Save Product</x-slot:title>

    <div class="card">
        <div class='card-body'>
            <form action='{{ route('product_store') }}' method='post' enctype="multipart/form-data">
                @csrf
                <input type='hidden' name='product_id' value='{{ $id }}'>
                <div class='row'>
                    <div class='mb-3 col-12'>
                        <label>Name*</label>
                        <input type='text' name='name' class='form-control' required
                            value='{{ old('name') ?? @$info->name }}'>
                    </div>
                    <div class='mb-3 col-sm-6'>
                        <label>Category*</label>
                        <select name='category' class='form-control'>
                            <option value=''>Select Category</option>
                            @if($category_list->count() > 0)
@foreach ($category_list as $item)
    <option value='{{ $item->id }}' @if(old('category') == $item->id || @$info->category_id == $item->id) selected @endif>{{ $item->name }}</option>
@endforeach
                            @endif
                        </select>
                    </div>
                    <div class='mb-3 col-sm-6'>
                        <label>Price*</label>
                        <input type='number' name='price' class='form-control' required
                            value='{{ old('price') ?? @$info->price }}' step='any'>
                    </div>
                    <div class='mb-3 col-12'>
                        <label>Description</label>
                        <textarea name='description' class='form-control' rows='5'>{{ old('description') ?? @$info->description }}</textarea>
                    </div>
                    <div class='mb-3 col-12'>
                        <label>Pix</label>
                        <input type='file' name='pix' class='form-control' @if($id == '--') required @endif>
                        @if($id != '--')
<img src='{{ url('public/uploads/product/'.$info->pix) }}' class='img-fluid'><br />
                        @endif
                        <small>200x200px</small>
                    </div>
                </div>
                <input class='btn btn-primary' type='submit' value='Save' name='save'>
            </form>
        </div>
    </div>


</x-back-template>
