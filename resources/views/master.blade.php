<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="">
	<title>@yield ('title')</title>
</head>
<body>
	<nav>
		<ul>
			<li><a href="/">Home</a></li>
			<li><a href="/about">About</a></li>
			<li><a href="/contact">Contact</a></li>
			<li><a href="/shop">Shop</a></li>
		</ul>
	</nav>

	@yield('content')

	<footer>
		<p>Copyright <?= date('Y') ?></p>
	</footer>
</body>
</html>