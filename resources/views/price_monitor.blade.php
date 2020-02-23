<!DOCTYPE html>
<html>
<head>
	<title>Product Price Monitoring</title>
</head>
<body>
	<h1>{{ $product->name }}</h1>
	<h2>Latest Price : {{ $productPrice }}</h2>
	<table>
		<tr>
			<th>Date</th>
			<th>Price</th>
		</tr>
		<tr>
			@foreach($product->product_prices as $price)
				<td>{{ $price->created_at }}</td>
				<td>{{ $price->price }}</td>
			@endforeach
		</tr>
	</table>
</body>
<script type="text/javascript">
	timer = setInterval(function(){location.reload()}, 1000 * 60 * 60);
</script>
</html>