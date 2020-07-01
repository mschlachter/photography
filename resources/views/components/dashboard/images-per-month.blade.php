@php
$startDate = today()->startOfMonth()->addMonths(-6);
$imageCounts = \DB::table('images')->select(
  DB::raw('count(id) as `data`'),
  DB::raw('YEAR(created_at) year, MONTHNAME(created_at) month')
)
->groupby('year','month')
->where('created_at', '>=', $startDate)
->get();

$labels = [];
$values = [];
while($startDate <= today()) {
  $labels[] = $startDate->format('M');
  $values[] = ($value = $imageCounts->filter(function($count) use ($startDate) {
    return $count->year == $startDate->year && $count->month == $startDate->format('F');
  })->first()) ? $value->data : 0;
  $startDate = $startDate->addMonths(1);
}
@endphp
<div class="card card-chart">
  <div class="card-header card-header-danger">
    <div class="ct-chart position-relative" id="imagesPerMonthChart"><span class="material-icons" style="height:157.5px;">hourglass_empty</span></div>
  </div>
  <div class="card-body">
    <h4 class="card-title">Images Per Month</h4>
    <p class="card-category">
      Number of images uploaded per month
    </p>
  </div>
  <div class="card-footer">
    <div class="stats">
      <i class="material-icons">access_time</i> updated at {{ now()->toTimeString() }}
    </div>
  </div>
</div>

@push('css')
<style type="text/css">
  #imagesPerMonthChart .ct-label.ct-horizontal.ct-end {
    display: block;
    text-align: center;
  }
</style>
@endpush

<x-dashboard.chartist-hover-plugin/>

@push('js')
  <script>
    window.setTimeout(function() {
      let labels = @json($labels);
      let values = @json($values);

      /* Build chart: */

      dataImagesPerMonth = {
        labels: labels,
        series: [values]
      };

      optionsImagesPerMonth = {
        seriesBarDistance: 10,
        low: 0,
        high: Math.max.apply(null, values) + 10,
        chartPadding: {
          top: 0,
          right: 0,
          bottom: 0,
          left: 0
        },
        plugins: [
        Chartist.plugins.tooltip({
          tooltipFnc: function(meta, value) { return meta + value + ' image' + (value == 1 ? '' : 's'); }
        })
        ]
      }

      document.getElementById('imagesPerMonthChart').innerHTML = '';

      var imagesPerMonthChart = new Chartist.Bar('#imagesPerMonthChart', dataImagesPerMonth, optionsImagesPerMonth
      );
    }, 1);
  </script>
@endpush