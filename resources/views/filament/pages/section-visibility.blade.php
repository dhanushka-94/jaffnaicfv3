<x-filament-panels::page>
	@php
		$definitions = \App\Models\SectionSetting::definitions();
		$total = count($definitions);
		$showing = $this->showingCount();
		$comingSoon = $total - $showing;
	@endphp

	<style>
		.sv { display: flex; flex-direction: column; gap: 1.25rem; }
		.sv-hero {
			display: flex;
			flex-wrap: wrap;
			align-items: flex-end;
			justify-content: space-between;
			gap: 1rem;
			border-radius: 1rem;
			border: 1px solid rgba(0,0,0,.08);
			background: linear-gradient(135deg, rgba(197,80,44,.12), #fff 42%, #fff);
			padding: 1.25rem 1.5rem;
		}
		.dark .sv-hero {
			border-color: rgba(255,255,255,.1);
			background: linear-gradient(135deg, rgba(197,80,44,.18), rgb(17,24,39) 46%, rgb(17,24,39));
		}
		.sv-kicker {
			display: inline-flex;
			align-items: center;
			border-radius: 999px;
			border: 1px solid rgba(197,80,44,.28);
			background: rgba(255,255,255,.8);
			padding: .2rem .65rem;
			font-size: .75rem;
			font-weight: 700;
			letter-spacing: .04em;
			text-transform: uppercase;
			color: #9a3412;
		}
		.dark .sv-kicker { background: rgba(255,255,255,.06); color: #fdba74; }
		.sv-title { margin: .55rem 0 0; font-size: 1.35rem; font-weight: 700; letter-spacing: -.02em; color: #111827; }
		.dark .sv-title { color: #fff; }
		.sv-sub { margin: .35rem 0 0; max-width: 40rem; font-size: .9rem; line-height: 1.5; color: #6b7280; }
		.dark .sv-sub { color: #d1d5db; }
		.sv-stats { display: flex; flex-wrap: wrap; gap: .5rem; }
		.sv-stat {
			min-width: 7.5rem;
			border-radius: .85rem;
			border: 1px solid rgba(0,0,0,.08);
			background: #fff;
			padding: .7rem .9rem;
		}
		.dark .sv-stat { background: rgb(17,24,39); border-color: rgba(255,255,255,.1); }
		.sv-stat strong { display: block; font-size: 1.35rem; line-height: 1; color: #111827; }
		.dark .sv-stat strong { color: #fff; }
		.sv-stat span { display: block; margin-top: .25rem; font-size: .75rem; color: #6b7280; }
		.sv-group {
			border-radius: 1rem;
			border: 1px solid rgba(0,0,0,.08);
			background: #fff;
			padding: 1.1rem 1.15rem 1.2rem;
		}
		.dark .sv-group { background: rgb(17,24,39); border-color: rgba(255,255,255,.1); }
		.sv-group-head {
			display: flex;
			flex-wrap: wrap;
			align-items: center;
			justify-content: space-between;
			gap: .75rem;
			margin-bottom: .9rem;
		}
		.sv-group-title { margin: 0; font-size: 1rem; font-weight: 700; color: #111827; }
		.dark .sv-group-title { color: #fff; }
		.sv-group-actions { display: flex; flex-wrap: wrap; gap: .4rem; }
		.sv-mini {
			border: 1px solid rgba(0,0,0,.1);
			background: #f9fafb;
			color: #374151;
			border-radius: 999px;
			padding: .35rem .7rem;
			font-size: .75rem;
			font-weight: 600;
			cursor: pointer;
		}
		.sv-mini:hover { background: #f3f4f6; }
		.dark .sv-mini { background: rgba(255,255,255,.04); border-color: rgba(255,255,255,.12); color: #e5e7eb; }
		.sv-grid { display: grid; grid-template-columns: 1fr; gap: .75rem; }
		@media (min-width: 768px) { .sv-grid { grid-template-columns: 1fr 1fr; } }
		@media (min-width: 1280px) { .sv-grid { grid-template-columns: 1fr 1fr 1fr; } }
		.sv-card {
			display: flex;
			flex-direction: column;
			gap: .65rem;
			border-radius: .9rem;
			border: 1px solid rgba(0,0,0,.08);
			background: #fafafa;
			padding: .9rem 1rem;
		}
		.dark .sv-card { background: rgba(255,255,255,.03); border-color: rgba(255,255,255,.08); }
		.sv-card.is-on { border-color: rgba(5,150,105,.35); background: rgba(16,185,129,.06); }
		.sv-card-top { display: flex; align-items: flex-start; justify-content: space-between; gap: .75rem; }
		.sv-label { margin: 0; font-size: .95rem; font-weight: 700; color: #111827; }
		.dark .sv-label { color: #fff; }
		.sv-note { margin: .2rem 0 0; font-size: .78rem; line-height: 1.4; color: #6b7280; }
		.sv-pill {
			display: inline-flex;
			align-items: center;
			width: fit-content;
			border-radius: 999px;
			padding: .18rem .55rem;
			font-size: .7rem;
			font-weight: 700;
			letter-spacing: .04em;
			text-transform: uppercase;
		}
		.sv-pill.is-on { background: #ecfdf5; color: #047857; }
		.sv-pill.is-off { background: #fff7ed; color: #c2410c; }
		.sv-switch {
			position: relative;
			flex: 0 0 auto;
			width: 2.75rem;
			height: 1.55rem;
			border: 0;
			border-radius: 999px;
			background: #d1d5db;
			cursor: pointer;
		}
		.sv-switch.is-on { background: #059669; }
		.sv-switch span {
			position: absolute;
			top: .15rem;
			left: .15rem;
			width: 1.25rem;
			height: 1.25rem;
			border-radius: 999px;
			background: #fff;
			box-shadow: 0 1px 2px rgba(0,0,0,.2);
			transition: transform .15s ease;
		}
		.sv-switch.is-on span { transform: translateX(1.2rem); }
		.sv-save {
			display: flex;
			flex-wrap: wrap;
			align-items: center;
			justify-content: space-between;
			gap: .75rem;
			border-radius: 1rem;
			border: 1px solid rgba(0,0,0,.08);
			background: #fff;
			padding: .9rem 1rem;
		}
		.dark .sv-save { background: rgb(17,24,39); border-color: rgba(255,255,255,.1); }
		.sv-save p { margin: 0; font-size: .85rem; color: #6b7280; }
	</style>

	<div class="sv">
		<div class="sv-hero">
			<div>
				<div class="sv-kicker">Public pages</div>
				<h2 class="sv-title">Choose what visitors can see</h2>
				<p class="sv-sub">On shows the page content. Off shows “To be announced”. Empty pages that are still on show “Coming soon” until you add their images or records.</p>
			</div>
			<div class="sv-stats">
				<div class="sv-stat">
					<strong>{{ $showing }}</strong>
					<span>Showing content</span>
				</div>
				<div class="sv-stat">
					<strong>{{ $comingSoon }}</strong>
					<span>To be announced</span>
				</div>
			</div>
		</div>

		@foreach($this->groupKeys() as $group => $keys)
			<div class="sv-group">
				<div class="sv-group-head">
					<h3 class="sv-group-title">{{ $group }}</h3>
					<div class="sv-group-actions">
						<button type="button" class="sv-mini" wire:click="setGroup('{{ $group }}', true)">Show all</button>
						<button type="button" class="sv-mini" wire:click="setGroup('{{ $group }}', false)">Announce later</button>
					</div>
				</div>
				<div class="sv-grid">
					@foreach($keys as $key)
						@php($on = $this->isOn($key))
						<article class="sv-card {{ $on ? 'is-on' : '' }}">
							<div class="sv-card-top">
								<div>
									<h4 class="sv-label">{{ $definitions[$key] ?? $key }}</h4>
									<p class="sv-note">
										@if($key === 'programme_images')
											Stored here, but this switch is not used on a public page yet.
										@elseif($on)
											Visitors see this page’s content.
										@else
											Visitors see “To be announced”.
										@endif
									</p>
								</div>
								<button
									type="button"
									class="sv-switch {{ $on ? 'is-on' : '' }}"
									wire:click="toggle('{{ $key }}')"
									role="switch"
									aria-checked="{{ $on ? 'true' : 'false' }}"
									aria-label="{{ $definitions[$key] ?? $key }}"
								>
									<span></span>
								</button>
							</div>
							<span class="sv-pill {{ $on ? 'is-on' : 'is-off' }}">{{ $on ? 'Showing' : 'To be announced' }}</span>
						</article>
					@endforeach
				</div>
			</div>
		@endforeach

		<div class="sv-save">
			<p>Switch changes stay on this screen until you save them.</p>
			<x-filament::button type="button" color="primary" icon="heroicon-m-check" wire:click="save">
				Save visibility
			</x-filament::button>
		</div>
	</div>
</x-filament-panels::page>
