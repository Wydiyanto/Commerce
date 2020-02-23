@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="GET">
	<input type="text" name="product_link" placeholder="Input fabelio's product link here." value="{{ old('product-link') }}">
	<button type="submit" formaction="{{ route('ppmonitor') }}">Price Monitor</button>
	<button type="submit" formaction="{{ route('productlist') }}">Product List</button>
</form>