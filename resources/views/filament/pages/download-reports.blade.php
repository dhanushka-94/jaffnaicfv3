<x-filament-panels::page>
	@php
		$summaryCards = [
			[
				'label' => 'Today',
				'value' => $this->summary['today'],
				'hint' => now()->format('M j'),
				'icon' => 'heroicon-o-sun',
				'tone' => 'amber',
				'preset' => 'today',
			],
			[
				'label' => 'Yesterday',
				'value' => $this->summary['yesterday'],
				'hint' => now()->subDay()->format('M j'),
				'icon' => 'heroicon-o-moon',
				'tone' => 'violet',
				'preset' => 'yesterday',
			],
			[
				'label' => 'This week',
				'value' => $this->summary['this_week'],
				'hint' => 'Mon–Sun',
				'icon' => 'heroicon-o-calendar-days',
				'tone' => 'sky',
				'preset' => 'week',
			],
			[
				'label' => 'This month',
				'value' => $this->summary['this_month'],
				'hint' => now()->format('F'),
				'icon' => 'heroicon-o-calendar',
				'tone' => 'emerald',
				'preset' => 'month',
			],
			[
				'label' => 'This year',
				'value' => $this->summary['this_year'],
				'hint' => (string) date('Y'),
				'icon' => 'heroicon-o-chart-bar',
				'tone' => 'primary',
				'preset' => 'year',
			],
			[
				'label' => 'All time',
				'value' => $this->summary['all_time'],
				'hint' => 'Lifetime',
				'icon' => 'heroicon-o-archive-box',
				'tone' => 'gray',
				'preset' => 'all',
			],
		];
	@endphp

	<style>
		.dlr { display: flex; flex-direction: column; gap: 1.25rem; }
		.dlr-hero {
			position: relative;
			overflow: hidden;
			border-radius: 1rem;
			border: 1px solid rgba(0,0,0,.08);
			background: linear-gradient(135deg, rgba(245,158,11,.12), #fff 45%, #fff);
			padding: 1.25rem 1.5rem;
		}
		.dark .dlr-hero {
			border-color: rgba(255,255,255,.1);
			background: linear-gradient(135deg, rgba(245,158,11,.12), rgb(17,24,39) 45%, rgb(17,24,39));
		}
		.dlr-hero-row {
			position: relative;
			display: flex;
			flex-wrap: wrap;
			align-items: center;
			justify-content: space-between;
			gap: 1rem;
		}
		.dlr-eyebrow {
			display: inline-flex;
			align-items: center;
			gap: .4rem;
			border-radius: 999px;
			background: rgba(255,255,255,.85);
			padding: .25rem .7rem;
			font-size: .75rem;
			font-weight: 600;
			color: #b45309;
			border: 1px solid rgba(245,158,11,.25);
		}
		.dark .dlr-eyebrow {
			background: rgba(255,255,255,.05);
			color: #fbbf24;
		}
		.dlr-title {
			margin: .65rem 0 0;
			font-size: 1.35rem;
			font-weight: 700;
			letter-spacing: -.02em;
			color: #111827;
		}
		.dark .dlr-title { color: #fff; }
		.dlr-sub {
			margin: .35rem 0 0;
			font-size: .875rem;
			color: #6b7280;
			max-width: 40rem;
		}
		.dark .dlr-sub { color: #d1d5db; }
		.dlr-kpi-wrap { display: flex; flex-wrap: wrap; gap: .75rem; }
		.dlr-kpi {
			min-width: 9rem;
			border-radius: .85rem;
			background: rgba(255,255,255,.9);
			border: 1px solid rgba(0,0,0,.06);
			padding: .75rem 1rem;
		}
		.dark .dlr-kpi {
			background: rgba(255,255,255,.05);
			border-color: rgba(255,255,255,.1);
		}
		.dlr-kpi-label {
			font-size: .7rem;
			text-transform: uppercase;
			letter-spacing: .04em;
			color: #6b7280;
		}
		.dlr-kpi-value {
			margin-top: .2rem;
			font-size: 1.5rem;
			font-weight: 700;
			color: #111827;
		}
		.dark .dlr-kpi-value { color: #fff; }
		.dlr-kpi-hint { margin-top: .15rem; font-size: .75rem; color: #9ca3af; }

		.dlr-cards {
			display: grid;
			grid-template-columns: repeat(2, minmax(0, 1fr));
			gap: .75rem;
		}
		@media (min-width: 1280px) {
			.dlr-cards { grid-template-columns: repeat(3, minmax(0, 1fr)); }
		}
		@media (min-width: 1536px) {
			.dlr-cards { grid-template-columns: repeat(6, minmax(0, 1fr)); }
		}
		.dlr-card {
			display: block;
			width: 100%;
			text-align: left;
			border-radius: 1rem;
			border: 1px solid rgba(0,0,0,.08);
			background: #fff;
			padding: 1rem;
			cursor: pointer;
			transition: transform .15s ease, box-shadow .15s ease, border-color .15s ease;
		}
		.dark .dlr-card {
			background: rgb(17,24,39);
			border-color: rgba(255,255,255,.1);
		}
		.dlr-card:hover {
			transform: translateY(-2px);
			box-shadow: 0 8px 20px rgba(0,0,0,.06);
			border-color: rgba(245,158,11,.45);
		}
		.dlr-card-top {
			display: flex;
			align-items: flex-start;
			justify-content: space-between;
			gap: .75rem;
		}
		.dlr-card-label {
			font-size: .7rem;
			font-weight: 600;
			text-transform: uppercase;
			letter-spacing: .04em;
			color: #6b7280;
		}
		.dlr-card-value {
			margin-top: .4rem;
			font-size: 1.75rem;
			font-weight: 700;
			color: #111827;
			line-height: 1.1;
		}
		.dark .dlr-card-value { color: #fff; }
		.dlr-card-hint { margin-top: .3rem; font-size: .75rem; color: #9ca3af; }
		.dlr-card-icon {
			display: inline-flex;
			align-items: center;
			justify-content: center;
			width: 2.25rem;
			height: 2.25rem;
			border-radius: .7rem;
			border: 1px solid transparent;
		}
		.dlr-card-icon svg { width: 1.15rem; height: 1.15rem; }
		.dlr-tone-amber { color: #d97706; background: #fffbeb; border-color: rgba(245,158,11,.25); }
		.dlr-tone-violet { color: #7c3aed; background: #f5f3ff; border-color: rgba(139,92,246,.25); }
		.dlr-tone-sky { color: #0284c7; background: #f0f9ff; border-color: rgba(14,165,233,.25); }
		.dlr-tone-emerald { color: #059669; background: #ecfdf5; border-color: rgba(16,185,129,.25); }
		.dlr-tone-primary { color: #b45309; background: #fffbeb; border-color: rgba(245,158,11,.25); }
		.dlr-tone-gray { color: #374151; background: #f3f4f6; border-color: rgba(107,114,128,.2); }
		.dark .dlr-tone-amber,
		.dark .dlr-tone-primary { color: #fbbf24; background: rgba(245,158,11,.12); }
		.dark .dlr-tone-violet { color: #c4b5fd; background: rgba(139,92,246,.12); }
		.dark .dlr-tone-sky { color: #7dd3fc; background: rgba(14,165,233,.12); }
		.dark .dlr-tone-emerald { color: #6ee7b7; background: rgba(16,185,129,.12); }
		.dark .dlr-tone-gray { color: #e5e7eb; background: rgba(255,255,255,.06); }

		.dlr-panel {
			border-radius: 1rem;
			border: 1px solid rgba(0,0,0,.08);
			background: #fff;
			padding: 1.25rem 1.5rem;
		}
		.dark .dlr-panel {
			background: rgb(17,24,39);
			border-color: rgba(255,255,255,.1);
		}
		.dlr-panel-head {
			display: flex;
			flex-wrap: wrap;
			align-items: flex-start;
			justify-content: space-between;
			gap: .75rem;
			margin-bottom: 1rem;
		}
		.dlr-panel-title {
			margin: 0;
			font-size: 1rem;
			font-weight: 700;
			color: #111827;
		}
		.dark .dlr-panel-title { color: #fff; }
		.dlr-panel-sub {
			margin: .25rem 0 0;
			font-size: .875rem;
			color: #6b7280;
		}
		.dark .dlr-panel-sub { color: #9ca3af; }
		.dlr-chip {
			display: inline-flex;
			align-items: center;
			gap: .35rem;
			border-radius: 999px;
			padding: .2rem .65rem;
			font-size: .7rem;
			font-weight: 600;
			background: #fffbeb;
			color: #b45309;
			border: 1px solid rgba(245,158,11,.25);
		}
		.dark .dlr-chip {
			background: rgba(245,158,11,.12);
			color: #fbbf24;
		}
		.dlr-count-pill {
			border-radius: 999px;
			padding: .2rem .65rem;
			font-size: .75rem;
			font-weight: 600;
			background: #f3f4f6;
			color: #4b5563;
		}
		.dark .dlr-count-pill {
			background: rgba(255,255,255,.06);
			color: #d1d5db;
		}

		.dlr-presets { display: flex; flex-wrap: wrap; gap: .45rem; margin-bottom: 1rem; }
		.dlr-preset {
			border-radius: .55rem;
			padding: .35rem .7rem;
			font-size: .75rem;
			font-weight: 600;
			border: 1px solid #e5e7eb;
			background: #f9fafb;
			color: #374151;
			cursor: pointer;
		}
		.dark .dlr-preset {
			background: rgba(255,255,255,.05);
			border-color: rgba(255,255,255,.1);
			color: #e5e7eb;
		}
		.dlr-preset.is-active {
			background: #d97706;
			border-color: #d97706;
			color: #fff;
		}
		.dlr-actions {
			display: flex;
			flex-wrap: wrap;
			align-items: center;
			gap: .5rem;
			margin-top: 1rem;
		}
		.dlr-filter-meta {
			font-size: .875rem;
			color: #6b7280;
		}
		.dlr-filter-meta strong { color: #111827; }
		.dark .dlr-filter-meta strong { color: #fff; }

		.dlr-split {
			display: grid;
			grid-template-columns: 1fr;
			gap: 1.25rem;
		}
		@media (min-width: 1280px) {
			.dlr-split { grid-template-columns: 1fr 1fr; }
		}

		.dlr-bars {
			display: flex;
			flex-direction: column;
			gap: .85rem;
			max-height: 28rem;
			overflow-y: auto;
			padding-right: .25rem;
		}
		.dlr-bar-row-top {
			display: flex;
			align-items: center;
			justify-content: space-between;
			gap: .75rem;
			margin-bottom: .35rem;
			font-size: .875rem;
		}
		.dlr-bar-day { font-weight: 600; color: #111827; }
		.dark .dlr-bar-day { color: #fff; }
		.dlr-bar-weekday { font-size: .75rem; color: #9ca3af; }
		.dlr-bar-total { font-weight: 700; color: #111827; }
		.dark .dlr-bar-total { color: #fff; }
		.dlr-bar-track {
			height: .5rem;
			border-radius: 999px;
			background: #f3f4f6;
			overflow: hidden;
		}
		.dark .dlr-bar-track { background: rgba(255,255,255,.06); }
		.dlr-bar-fill {
			height: 100%;
			border-radius: 999px;
			background: linear-gradient(90deg, #d97706, #fbbf24);
		}
		.dlr-bar-fill.is-year { background: linear-gradient(90deg, #374151, #9ca3af); }
		.dlr-bar-fill.is-current { background: linear-gradient(90deg, #059669, #34d399); }
		.dlr-year-badge {
			display: inline-flex;
			align-items: center;
			margin-left: .4rem;
			border-radius: 999px;
			padding: .1rem .45rem;
			font-size: .65rem;
			font-weight: 700;
			text-transform: uppercase;
			letter-spacing: .04em;
			background: #ecfdf5;
			color: #047857;
			border: 1px solid rgba(16,185,129,.25);
		}
		.dark .dlr-year-badge {
			background: rgba(16,185,129,.12);
			color: #6ee7b7;
		}

		.dlr-empty {
			display: flex;
			flex-direction: column;
			align-items: center;
			justify-content: center;
			text-align: center;
			border: 1px dashed #e5e7eb;
			border-radius: .85rem;
			padding: 2.5rem 1rem;
			color: #6b7280;
		}
		.dark .dlr-empty { border-color: rgba(255,255,255,.12); }
		.dlr-empty-icon {
			display: inline-flex;
			align-items: center;
			justify-content: center;
			width: 2.75rem;
			height: 2.75rem;
			border-radius: 999px;
			background: #f3f4f6;
			color: #9ca3af;
			margin-bottom: .75rem;
		}
		.dark .dlr-empty-icon { background: rgba(255,255,255,.06); }
		.dlr-empty strong {
			display: block;
			color: #374151;
			font-size: .875rem;
			margin-bottom: .2rem;
		}
		.dark .dlr-empty strong { color: #e5e7eb; }
		.dlr-empty span { font-size: .75rem; color: #9ca3af; }

		.dlr-table-wrap {
			overflow: hidden;
			border-radius: .85rem;
			border: 1px solid rgba(0,0,0,.08);
		}
		.dark .dlr-table-wrap { border-color: rgba(255,255,255,.1); }
		.dlr-table {
			width: 100%;
			border-collapse: collapse;
			font-size: .875rem;
		}
		.dlr-table thead {
			background: #f9fafb;
		}
		.dark .dlr-table thead { background: rgba(255,255,255,.04); }
		.dlr-table th {
			text-align: left;
			padding: .75rem 1rem;
			font-size: .7rem;
			font-weight: 700;
			text-transform: uppercase;
			letter-spacing: .04em;
			color: #6b7280;
			white-space: nowrap;
		}
		.dlr-table td {
			padding: .85rem 1rem;
			border-top: 1px solid #f3f4f6;
			vertical-align: top;
			color: #374151;
		}
		.dark .dlr-table td {
			border-top-color: rgba(255,255,255,.06);
			color: #d1d5db;
		}
		.dlr-when-main { font-weight: 600; color: #111827; }
		.dark .dlr-when-main { color: #fff; }
		.dlr-when-sub { margin-top: .15rem; font-size: .75rem; color: #9ca3af; }
		.dlr-year-pill {
			display: inline-flex;
			border-radius: 999px;
			padding: .2rem .55rem;
			font-size: .75rem;
			font-weight: 700;
			background: #fffbeb;
			color: #b45309;
			border: 1px solid rgba(245,158,11,.25);
		}
		.dark .dlr-year-pill {
			background: rgba(245,158,11,.12);
			color: #fbbf24;
		}
		.dlr-ip {
			font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
			font-size: .75rem;
			background: #f3f4f6;
			padding: .15rem .4rem;
			border-radius: .3rem;
		}
		.dark .dlr-ip { background: rgba(255,255,255,.08); }
		.dlr-ua {
			max-width: 22rem;
			overflow: hidden;
			text-overflow: ellipsis;
			white-space: nowrap;
			font-size: .75rem;
			color: #9ca3af;
		}
		@media (max-width: 767px) {
			.dlr-hide-sm { display: none; }
		}
	</style>

	<div class="dlr">
		<div class="dlr-hero">
			<div class="dlr-hero-row">
				<div>
					<div class="dlr-eyebrow">
						<x-filament::icon icon="heroicon-m-arrow-down-tray" class="h-3.5 w-3.5" />
						Application downloads
					</div>
					<h2 class="dlr-title">Download activity overview</h2>
					<p class="dlr-sub">
						Track form downloads by day, month, and year. Click a summary card or use presets to filter the report.
					</p>
				</div>

				<div class="dlr-kpi-wrap">
					<div class="dlr-kpi">
						<div class="dlr-kpi-label">In view</div>
						<div class="dlr-kpi-value">{{ number_format($this->filteredCount) }}</div>
						<div class="dlr-kpi-hint">{{ $this->filterLabel }}</div>
					</div>

					@if($this->peakDay)
						<div class="dlr-kpi">
							<div class="dlr-kpi-label">Peak day</div>
							<div class="dlr-kpi-value">{{ number_format($this->peakDay->total) }}</div>
							<div class="dlr-kpi-hint">
								{{ \Illuminate\Support\Carbon::parse($this->peakDay->day)->format('M j, Y') }}
							</div>
						</div>
					@endif
				</div>
			</div>
		</div>

		<div class="dlr-cards">
			@foreach($summaryCards as $card)
				<button type="button" class="dlr-card" wire:click="setPreset('{{ $card['preset'] }}')">
					<div class="dlr-card-top">
						<div>
							<div class="dlr-card-label">{{ $card['label'] }}</div>
							<div class="dlr-card-value">{{ number_format($card['value']) }}</div>
							<div class="dlr-card-hint">{{ $card['hint'] }}</div>
						</div>
						<span class="dlr-card-icon dlr-tone-{{ $card['tone'] }}">
							<x-filament::icon :icon="$card['icon']" />
						</span>
					</div>
				</button>
			@endforeach
		</div>

		<div class="dlr-panel">
			<div class="dlr-panel-head">
				<div>
					<h3 class="dlr-panel-title">Date range filter</h3>
					<p class="dlr-panel-sub">Choose a custom range, or use a quick preset. Leave empty for all records.</p>
				</div>
				@if($this->hasActiveFilter)
					<span class="dlr-chip">
						<x-filament::icon icon="heroicon-m-funnel" class="h-3.5 w-3.5" />
						Filter active
					</span>
				@endif
			</div>

			<div class="dlr-presets">
				@foreach([
					['key' => 'today', 'label' => 'Today'],
					['key' => 'yesterday', 'label' => 'Yesterday'],
					['key' => 'week', 'label' => 'This week'],
					['key' => 'month', 'label' => 'This month'],
					['key' => 'year', 'label' => 'This year'],
					['key' => 'all', 'label' => 'All time'],
				] as $preset)
					<button
						type="button"
						class="dlr-preset {{ $this->activePreset === $preset['key'] ? 'is-active' : '' }}"
						wire:click="setPreset('{{ $preset['key'] }}')"
					>
						{{ $preset['label'] }}
					</button>
				@endforeach
			</div>

			<form wire:submit.prevent="applyFilter">
				{{ $this->form }}
				<div class="dlr-actions">
					<x-filament::button type="submit" color="primary" icon="heroicon-m-magnifying-glass">
						Apply filter
					</x-filament::button>
					<x-filament::button type="button" color="gray" wire:click="clearFilter" icon="heroicon-m-x-mark">
						Clear
					</x-filament::button>
					<div class="dlr-filter-meta">
						Showing <strong>{{ number_format($this->filteredCount) }}</strong>
						download{{ $this->filteredCount === 1 ? '' : 's' }}
						· {{ $this->filterLabel }}
					</div>
				</div>
			</form>
		</div>

		<div class="dlr-split">
			<div class="dlr-panel">
				<div class="dlr-panel-head">
					<div>
						<h3 class="dlr-panel-title">Daily breakdown</h3>
						<p class="dlr-panel-sub">Last 60 days in the selected range</p>
					</div>
					<span class="dlr-count-pill">
						{{ $this->dailyBreakdown->count() }} day{{ $this->dailyBreakdown->count() === 1 ? '' : 's' }}
					</span>
				</div>

				@if($this->dailyBreakdown->isEmpty())
					<div class="dlr-empty">
						<div class="dlr-empty-icon">
							<x-filament::icon icon="heroicon-o-calendar" class="h-6 w-6" />
						</div>
						<strong>No downloads in this range</strong>
						<span>Try widening the date filter.</span>
					</div>
				@else
					<div class="dlr-bars">
						@foreach($this->dailyBreakdown as $row)
							@php
								$pct = round(($row->total / $this->maxDailyTotal) * 100);
								$day = \Illuminate\Support\Carbon::parse($row->day);
							@endphp
							<div>
								<div class="dlr-bar-row-top">
									<div>
										<div class="dlr-bar-day">{{ $day->format('M j, Y') }}</div>
										<div class="dlr-bar-weekday">{{ $day->format('l') }}</div>
									</div>
									<div class="dlr-bar-total">{{ number_format($row->total) }}</div>
								</div>
								<div class="dlr-bar-track">
									<div class="dlr-bar-fill" style="width: {{ max($pct, 4) }}%"></div>
								</div>
							</div>
						@endforeach
					</div>
				@endif
			</div>

			<div class="dlr-panel">
				<div class="dlr-panel-head">
					<div>
						<h3 class="dlr-panel-title">Yearly totals</h3>
						<p class="dlr-panel-sub">Cumulative downloads by festival year</p>
					</div>
					<span class="dlr-count-pill">
						{{ $this->yearlyStats->count() }} year{{ $this->yearlyStats->count() === 1 ? '' : 's' }}
					</span>
				</div>

				@if($this->yearlyStats->isEmpty())
					<div class="dlr-empty">
						<div class="dlr-empty-icon">
							<x-filament::icon icon="heroicon-o-chart-bar" class="h-6 w-6" />
						</div>
						<strong>No yearly totals yet</strong>
						<span>Totals appear after the first download.</span>
					</div>
				@else
					<div class="dlr-bars">
						@foreach($this->yearlyStats as $stat)
							@php
								$pct = round(($stat->downloads_count / $this->maxYearlyTotal) * 100);
								$isCurrent = (int) $stat->year === (int) date('Y');
							@endphp
							<div>
								<div class="dlr-bar-row-top">
									<div>
										<span class="dlr-bar-day">{{ $stat->year }}</span>
										@if($isCurrent)
											<span class="dlr-year-badge">Current</span>
										@endif
									</div>
									<div class="dlr-bar-total">{{ number_format($stat->downloads_count) }}</div>
								</div>
								<div class="dlr-bar-track">
									<div class="dlr-bar-fill {{ $isCurrent ? 'is-current' : 'is-year' }}" style="width: {{ max($pct, 4) }}%"></div>
								</div>
							</div>
						@endforeach
					</div>
				@endif
			</div>
		</div>

		<div class="dlr-panel">
			<div class="dlr-panel-head">
				<div>
					<h3 class="dlr-panel-title">Recent downloads</h3>
					<p class="dlr-panel-sub">
						Latest 25 downloads{{ $this->hasActiveFilter ? ' in the selected range' : '' }}
					</p>
				</div>
				<span class="dlr-count-pill">{{ $this->recentDownloads->count() }} shown</span>
			</div>

			@if($this->recentDownloads->isEmpty())
				<div class="dlr-empty">
					<div class="dlr-empty-icon">
						<x-filament::icon icon="heroicon-o-inbox" class="h-6 w-6" />
					</div>
					<strong>No recent downloads</strong>
					<span>Nothing matched this filter.</span>
				</div>
			@else
				<div class="dlr-table-wrap">
					<div style="overflow-x: auto;">
						<table class="dlr-table">
							<thead>
								<tr>
									<th>When</th>
									<th>Year</th>
									<th>IP address</th>
									<th class="dlr-hide-sm">Device / browser</th>
								</tr>
							</thead>
							<tbody>
								@foreach($this->recentDownloads as $log)
									<tr>
										<td>
											<div class="dlr-when-main">{{ $log->created_at?->format('M j, Y') }}</div>
											<div class="dlr-when-sub">
												{{ $log->created_at?->format('g:i A') }}
												· {{ $log->created_at?->diffForHumans() }}
											</div>
										</td>
										<td>
											<span class="dlr-year-pill">{{ $log->year }}</span>
										</td>
										<td>
											<code class="dlr-ip">{{ $log->ip_address ?: '—' }}</code>
										</td>
										<td class="dlr-hide-sm">
											<div class="dlr-ua" title="{{ $log->user_agent }}">
												{{ $log->user_agent ?: '—' }}
											</div>
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			@endif
		</div>
	</div>
</x-filament-panels::page>
