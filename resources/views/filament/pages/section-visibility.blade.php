<x-filament-panels::page>
	<style>
		.section-visibility-form > div:first-child {
			display: grid;
			grid-template-columns: 1fr;
			gap: 2rem;
			margin-bottom: 3rem;
		}
		@media (min-width: 640px) {
			.section-visibility-form > div:first-child {
				grid-template-columns: repeat(2, 1fr);
				gap: 2rem;
				margin-bottom: 3rem;
			}
		}
		@media (min-width: 1024px) {
			.section-visibility-form > div:first-child {
				grid-template-columns: repeat(3, 1fr);
				gap: 2rem;
				margin-bottom: 3rem;
			}
		}
		.section-visibility-form .fi-fo-field-wrp-label {
			margin-bottom: 0.75rem;
		}
		.section-visibility-form .button-container {
			margin-top: 3rem;
			padding-top: 2rem;
		}
	</style>
	<div class="space-y-6">
		<p class="text-sm text-gray-600 dark:text-gray-400">
			Turn sections <span class="font-semibold">ON</span> to show their content (images, team members, venues) or
			<span class="font-semibold">OFF</span> to show a "TO BE ANNOUNCED" message on the frontend.
		</p>

		<form wire:submit.prevent="save" class="space-y-6 section-visibility-form">
			{{ $this->form }}

			<div class="flex justify-end button-container">
				<x-filament::button type="submit" color="primary">
					Save visibility
				</x-filament::button>
			</div>
		</form>
	</div>
</x-filament-panels::page>


