<table class="table table-hover table-condensed">
    <thead>
        <tr>
            <th style="width:50%">Product</th>
            <th style="width:10%">Price</th>
            <th style="width:8%">Quantity</th>
            <th style="width:22%" class="text-center">Subtotal</th>
            <th style="width:10%"></th>
        </tr>
    </thead>
    <tbody>
        @php $total = 0 @endphp
        @if (session('cart'))
            @foreach (session('cart') as $id => $details)
                @php $total += $details['price'] * $details['quantity'] @endphp
                <tr data-id="{{ $id }}">
                    <td data-th="Product">
                        {{ $details['name'] }}

                    </td>
                    <td data-th="Price">{{ config('settings.currency') }}{{ $details['price'] }}</td>
                    <td data-th="Quantity">
                        <input type="number" value="{{ $details['quantity'] }}"
                            class="form-control quantity update-cart" />
                    </td>
                    <td data-th="Subtotal" class="text-center">
                        {{ config('settings.currency') }}{{ $details['price'] * $details['quantity'] }}
                    </td>
                    <td class="actions" data-th="">
                        <button class="btn btn-danger btn-sm remove-from-cart"><i
                                class="bi bi-trash"></i></button>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
    <tfoot>
        <tr>
            <td colspan="5" class="text-right">
                <h4><strong>Total {{ config('settings.currency') }}{{ $total }}</strong></h4>
            </td>
        </tr>
        <tr>
            <td colspan="5" class="text-right">
                <input type='hidden' name='total' value='{{ $total }}'>
                <button type='submit' class="btn btn-success">Place Order</a>
            </td>
        </tr>
    </tfoot>
</table>