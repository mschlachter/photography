@inject('analytics', App\Libraries\ToolboxGoogleAnalytics)
@php
  // Get our values for the dashboard:

$viewsByDay = $analytics->getViewsPerDayForLast7Days();
$viewsByDayLabels = array_map(function($day) {return substr($day['dayOfWeek'], 0, 1);}, $viewsByDay);
$viewsByDayValues = array_map(function($day) {return $day['views'];}, $viewsByDay);
$viewsByDayChange = count($viewsByDayValues) > 2 && $viewsByDayValues[count($viewsByDayValues) - 3] > 0 ? floor(($viewsByDayValues[count($viewsByDayValues) - 2] * 1.0 / $viewsByDayValues[count($viewsByDayValues) - 3] - 1) * 100) : (count($viewsByDayValues) > 0 && $viewsByDayValues[count($viewsByDayValues) - 2] > 0 ? INF : 0);
@endphp

<div class="card card-chart">
	<div class="card-header card-header-warning">
		<div class="ct-chart position-relative" id="dailyViewsChart"></div>
	</div>
	<div class="card-body">
		<h4 class="card-title">Daily Views</h4>
		<p class="card-category">
			<span class="text-{{ $viewsByDayChange >= 0 ? 'success' : 'danger' }}"><i class="fa fa-long-arrow-{{ $viewsByDayChange >= 0 ? 'up' : 'down' }}"></i> {{ $viewsByDayChange }}% </span> {{ $viewsByDayChange >= 0 ? 'increase' : 'decrease' }} in daily views yesterday.
		</p>
	</div>
	<div class="card-footer">
		<div class="stats">
			<i class="material-icons">access_time</i> updated today
		</div>
	</div>
</div>

<x-dashboard.chartist-hover-plugin/>

@push('js')
<script>
	$(document).ready(function() {
      dataDailyViewsChart = {
      	labels: @json($viewsByDayLabels),
      	series: [
      	@json($viewsByDayValues)
      	]
      };

      optionsDailyViewsChart = {
      	lineSmooth: Chartist.Interpolation.cardinal({
      		tension: 0
      	}),
      	low: 0,
        high: {{ max(array_merge($viewsByDayValues, [0])) + 10 }}, // creative tim: we recommend you to set the high sa the biggest value + something for a better look
        chartPadding: {
        	top: 0,
        	right: 0,
        	bottom: 0,
        	left: 0
        },
        plugins: [
        Chartist.plugins.tooltip({
        	tooltipFnc: function(meta, value) { return meta + value + ' view' + (value == 1 ? '' : 's'); }
        })
        ]
    }

    var dailyViewsChart = new Chartist.Line('#dailyViewsChart', dataDailyViewsChart, optionsDailyViewsChart);
});
</script>
@endpush