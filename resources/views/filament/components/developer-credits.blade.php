@if(! request()->routeIs('filament.admin.auth.login'))
	<footer class="developer-credits-sticky">
		<div class="developer-credits-sticky-inner">
			<div class="developer-credits-sticky-left">
				<span>© {{ date('Y') }} {{ config('app.name', 'JaffnaICF') }}</span>
			</div>
			<div class="developer-credits-sticky-right">
				<span class="developer-credits-sticky-label">Website design &amp; development by</span>
				<a href="https://olexto.com/" target="_blank" rel="noopener" class="developer-credits-sticky-link">
					olexto Digital Solutions (Pvt) Ltd
				</a>
			</div>
		</div>
	</footer>
@endif
