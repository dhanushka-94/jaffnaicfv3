<x-filament-panels::page>
	@php
		$maxYearly = max(1, (int) $this->downloadStats->max('downloads_count'));
	@endphp

	<style>
		.aps { display: flex; flex-direction: column; gap: 1.25rem; }
		.aps-panel {
			border-radius: 1rem;
			border: 1px solid rgba(0,0,0,.08);
			background: #fff;
			padding: 1.25rem 1.5rem;
		}
		.dark .aps-panel {
			background: rgb(17,24,39);
			border-color: rgba(255,255,255,.1);
		}
		.aps-hero {
			position: relative;
			overflow: hidden;
			border-radius: 1rem;
			border: 1px solid rgba(0,0,0,.08);
			background: linear-gradient(135deg, rgba(245,158,11,.12), #fff 45%, #fff);
			padding: 1.25rem 1.5rem;
		}
		.dark .aps-hero {
			border-color: rgba(255,255,255,.1);
			background: linear-gradient(135deg, rgba(245,158,11,.12), rgb(17,24,39) 45%, rgb(17,24,39));
		}
		.aps-eyebrow {
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
		.dark .aps-eyebrow {
			background: rgba(255,255,255,.05);
			color: #fbbf24;
		}
		.aps-title {
			margin: .65rem 0 0;
			font-size: 1.35rem;
			font-weight: 700;
			letter-spacing: -.02em;
			color: #111827;
		}
		.dark .aps-title { color: #fff; }
		.aps-sub {
			margin: .35rem 0 0;
			font-size: .875rem;
			color: #6b7280;
			max-width: 40rem;
		}
		.dark .aps-sub { color: #d1d5db; }
		.aps-actions {
			display: flex;
			flex-wrap: wrap;
			align-items: center;
			gap: .5rem;
			margin-top: 1.25rem;
		}
		.aps-panel-head {
			display: flex;
			flex-wrap: wrap;
			align-items: flex-end;
			justify-content: space-between;
			gap: .75rem;
			margin-bottom: 1rem;
		}
		.aps-panel-title {
			margin: 0;
			font-size: 1rem;
			font-weight: 700;
			color: #111827;
		}
		.dark .aps-panel-title { color: #fff; }
		.aps-panel-sub {
			margin: .25rem 0 0;
			font-size: .875rem;
			color: #6b7280;
		}
		.dark .aps-panel-sub { color: #9ca3af; }
		.aps-year-total {
			font-size: .875rem;
			color: #4b5563;
		}
		.dark .aps-year-total { color: #d1d5db; }
		.aps-year-total strong {
			color: #111827;
			font-weight: 700;
		}
		.dark .aps-year-total strong { color: #fff; }
		.aps-empty {
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
		.dark .aps-empty { border-color: rgba(255,255,255,.12); }
		.aps-empty-icon {
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
		.dark .aps-empty-icon { background: rgba(255,255,255,.06); }
		.aps-empty strong {
			display: block;
			color: #374151;
			font-size: .875rem;
			margin-bottom: .2rem;
		}
		.dark .aps-empty strong { color: #e5e7eb; }
		.aps-empty span { font-size: .75rem; color: #9ca3af; }
		.aps-bars {
			display: flex;
			flex-direction: column;
			gap: .85rem;
		}
		.aps-bar-top {
			display: flex;
			align-items: center;
			justify-content: space-between;
			gap: .75rem;
			margin-bottom: .35rem;
			font-size: .875rem;
		}
		.aps-bar-year { font-weight: 700; color: #111827; }
		.dark .aps-bar-year { color: #fff; }
		.aps-bar-total { font-weight: 700; color: #111827; }
		.dark .aps-bar-total { color: #fff; }
		.aps-bar-track {
			height: .55rem;
			border-radius: 999px;
			background: #f3f4f6;
			overflow: hidden;
		}
		.dark .aps-bar-track { background: rgba(255,255,255,.06); }
		.aps-bar-fill {
			height: 100%;
			border-radius: 999px;
			background: linear-gradient(90deg, #374151, #9ca3af);
		}
		.aps-bar-fill.is-current {
			background: linear-gradient(90deg, #059669, #34d399);
		}
		.aps-year-badge {
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
		.dark .aps-year-badge {
			background: rgba(16,185,129,.12);
			color: #6ee7b7;
		}
	</style>

	<div class="aps">
		<div class="aps-hero">
			<div class="aps-eyebrow">
				<x-filament::icon icon="heroicon-m-document-arrow-down" class="h-3.5 w-3.5" />
				Public application form
			</div>
			<h2 class="aps-title">Application download settings</h2>
			<p class="aps-sub">
				Control whether visitors can download the application PDF, and review yearly download totals.
			</p>
		</div>

		<div class="aps-panel">
			<form wire:submit.prevent="save">
				{{ $this->form }}
				<div class="aps-actions">
					<x-filament::button type="submit" color="primary" icon="heroicon-m-check">
						Save
					</x-filament::button>
					<x-filament::button
						tag="a"
						color="gray"
						icon="heroicon-m-chart-bar"
						:href="\App\Filament\Pages\DownloadReports::getUrl()"
					>
						Open download reports
					</x-filament::button>
				</div>
			</form>
		</div>

		<div class="aps-panel">
			<div class="aps-panel-head">
				<div>
					<h3 class="aps-panel-title">Quick yearly totals</h3>
					<p class="aps-panel-sub">
						For today / yesterday / month / custom range, use Download Reports.
					</p>
				</div>
				<div class="aps-year-total">
					<strong>{{ date('Y') }}:</strong>
					{{ number_format($this->currentYearDownloads) }}
					download{{ $this->currentYearDownloads === 1 ? '' : 's' }}
				</div>
			</div>

			@if($this->downloadStats->isEmpty())
				<div class="aps-empty">
					<div class="aps-empty-icon">
						<x-filament::icon icon="heroicon-o-chart-bar" class="h-6 w-6" />
					</div>
					<strong>No downloads recorded yet</strong>
					<span>Totals appear after the first application download.</span>
				</div>
			@else
				<div class="aps-bars">
					@foreach($this->downloadStats as $stat)
						@php
							$pct = round(($stat->downloads_count / $maxYearly) * 100);
							$isCurrent = (int) $stat->year === (int) date('Y');
						@endphp
						<div>
							<div class="aps-bar-top">
								<div>
									<span class="aps-bar-year">{{ $stat->year }}</span>
									@if($isCurrent)
										<span class="aps-year-badge">Current</span>
									@endif
								</div>
								<div class="aps-bar-total">{{ number_format($stat->downloads_count) }}</div>
							</div>
							<div class="aps-bar-track">
								<div class="aps-bar-fill {{ $isCurrent ? 'is-current' : '' }}" style="width: {{ max($pct, 4) }}%"></div>
							</div>
						</div>
					@endforeach
				</div>
			@endif
		</div>
	</div>
</x-filament-panels::page>
