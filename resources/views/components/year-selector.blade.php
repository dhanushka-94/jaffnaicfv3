@props(['currentYear', 'selectedYear', 'availableYears', 'routeName', 'routeParams' => []])

<div class="mb-8 md:mb-12" data-aos="fade-up">
	<div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
		<div>
			<h2 class="text-2xl md:text-3xl lg:text-4xl font-display font-bold text-primary">
				{{ $selectedYear }} Archive
			</h2>
			@if($selectedYear !== $currentYear)
				<p class="mt-2 text-dark/70">Viewing archived content from {{ $selectedYear }}</p>
			@endif
		</div>
		
		<div class="flex items-center gap-3">
			<label for="year-selector" class="text-sm font-medium text-dark/80">Select Year:</label>
			<select 
				id="year-selector" 
				onchange="window.location.href = this.value"
				class="px-4 py-2 border border-dark/20 rounded-lg bg-white text-dark focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
			>
				@foreach($availableYears as $year)
					<option 
						value="{{ route($routeName, array_merge($routeParams, ['year' => $year])) }}"
						{{ $year == $selectedYear ? 'selected' : '' }}
					>
						{{ $year }}
					</option>
				@endforeach
			</select>
		</div>
	</div>
</div>

