<!DOCTYPE html>
<html>
<head>
	<title>Product List</title>
</head>
<body>
	<table>
		<tr>
			<th>No</th>
			<th>Product Name</th>
			<th>Latest Price</th>
			<th></th>
		</tr>
		@foreach($products as $product)
			<tr>
				<td>{{ $loop->iteration }}</td>
				<td>{{ $product->name }}</td>
				<td>{{ $product->latest_price }}</td>
				<td><a href="{{ route('ppmonitor', ['product_link' => $product->url]) }}">Price Monitor</a></td>
			</tr>
		@endforeach
	</table>
</body>
</html>