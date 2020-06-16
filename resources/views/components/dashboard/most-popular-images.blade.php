@inject('analytics', App\Libraries\ToolboxGoogleAnalytics)
@php
  // Get our values for the dashboard:

$mostPopularPages = $analytics->getMostPopularPages();
@endphp

<div class="card">
	<div class="card-header card-header-warning">
		<h4 class="card-title">Most Popular Images</h4>
		<p class="card-category">Most-viewed image pages over the past 7 days</p>
	</div>
	<div class="card-body table-responsive">
		<table class="table table-hover">
			<thead class="text-warning">
				<th>Page Title</th>
				<th>URL</th>
				<th>Views</th>
			</thead>
			<tbody>
				@foreach($mostPopularPages as $page)
				<tr>
					<td>{{ explode('—', $page['title'])[0] }}</td>
					<td>
						<a href="{{ url($page['url']) }}">
							{{ $page['url'] }}
						</a>
					</td>
					<td>{{ $page['views'] }}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>