@inject('analytics', App\Libraries\ToolboxGoogleAnalytics)
@php
  // Get our values for the dashboard:

$sessionsByDay = $analytics->getSessionsPerDayForLast7Days();
$sessionsByDayLabels = array_map(function($day) {return substr($day['dayOfWeek'], 0, 1);}, $sessionsByDay);
$sessionsByDayValues = array_map(function($day) {return $day['sessions'];}, $sessionsByDay);
$sessionsByDayChange = count($sessionsByDayValues) > 2 && $sessionsByDayValues[count($sessionsByDayValues) - 3] > 0 ? floor(($sessionsByDayValues[count($sessionsByDayValues) - 2] * 1.0 / $sessionsByDayValues[count($sessionsByDayValues) - 3] - 1) * 100) : (count($sessionsByDayValues) > 0 && $sessionsByDayValues[count($sessionsByDayValues) - 2] > 0 ? INF : 0);
@endphp
<div class="card card-chart">
  <div class="card-header card-header-success">
    <div class="ct-chart position-relative" id="dailyVisitorsChart"></div>
  </div>
  <div class="card-body">
    <h4 class="card-title">Daily Visitors</h4>
    <p class="card-category">
      <span class="text-{{ $sessionsByDayChange >= 0 ? 'success' : 'danger' }}"><i class="fa fa-long-arrow-{{ $sessionsByDayChange >= 0 ? 'up' : 'down' }}"></i> {{ $sessionsByDayChange }}% </span> {{ $sessionsByDayChange >= 0 ? 'increase' : 'decrease' }} in daily visitors yesterday.
    </p>
  </div>
  <div class="card-footer">
    <div class="stats">
      <i class="material-icons">access_time</i> updated today
    </div>
  </div>
</div>

@push('js')
  @if(!config('graph-assets-loaded', false) && !config()->set('graph-assets-loaded', true))
    <script src="https://cdn.jsdelivr.net/npm/chartist-plugin-tooltips@0.0.17/dist/chartist-plugin-tooltip.min.js" integrity="sha256-BdDMib6f/EOwrxY3YE9bfqySmqixP5zvookyxS1khtY=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chartist-plugin-tooltips@0.0.17/dist/chartist-plugin-tooltip.min.css">
  @endif
  <script>
    $(document).ready(function() {
      dataDailyVisitorsChart = {
        labels: @json($sessionsByDayLabels),
        series: [
          @json($sessionsByDayValues)
        ]
      };

      optionsDailyVisitorsChart = {
        lineSmooth: Chartist.Interpolation.cardinal({
          tension: 0
        }),
        low: 0,
        high: {{ max(array_merge($sessionsByDayValues, [0])) + 10 }}, // creative tim: we recommend you to set the high sa the biggest value + something for a better look
        chartPadding: {
          top: 0,
          right: 0,
          bottom: 0,
          left: 0
        },
        plugins: [
          Chartist.plugins.tooltip({
            tooltipFnc: function(meta, value) { return meta + value + ' visitor' + (value == 1 ? '' : 's'); }
          })
        ]
      }

      var dailyVisitorsChart = new Chartist.Line('#dailyVisitorsChart', dataDailyVisitorsChart, optionsDailyVisitorsChart);
    });
  </script>
@endpush