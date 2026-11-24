<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="robots" content="noindex, nofollow">
	<title>@yield('code') — @yield('title') | Jaffna ICF</title>
	<style>
		*{box-sizing:border-box}
		html,body{height:100%;margin:0}
		body{display:flex;align-items:center;justify-content:center;padding:1.5rem;background:#F6EFE7;color:#1A1A1A;font-family:Inter,system-ui,-apple-system,"Segoe UI",Roboto,Arial,sans-serif;text-align:center}
		main{max-width:30rem}
		.code{font-size:clamp(4rem,18vw,7rem);font-weight:800;line-height:1;color:#C5502C;letter-spacing:-.02em}
		h1{margin:.75rem 0 .5rem;font-size:clamp(1.35rem,4vw,1.75rem)}
		p{margin:0 0 1.75rem;line-height:1.6;color:#4b4b4b}
		a.btn{display:inline-block;padding:.8rem 1.6rem;border-radius:.375rem;background:#C5502C;color:#fff;text-decoration:none;font-weight:600}
		a.btn:hover,a.btn:focus{background:#8C3B28}
		.brand{margin-top:2.5rem;font-size:.8rem;letter-spacing:.12em;text-transform:uppercase;color:#8C3B28}
	</style>
</head>
<body>
	<main>
		<div class="code">@yield('code')</div>
		<h1>@yield('title')</h1>
		<p>@yield('message')</p>
		<a class="btn" href="/">Back to home</a>
		<div class="brand">Jaffna International Cinema Festival</div>
	</main>
</body>
</html>