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
		<tr>
			@foreach($products as $product)
				<td>{{ $loop->iteration }}</td>
				<td>{{ $product->name }}</td>
				<td>{{ $product->latest_price }}</td>
				<td><a href="{{ route('ppmonitor', ['product_link' => $product->url]) }}">Price Monitor</a></td>
			@endforeach
		</tr>
	</table>
</body>
</html>