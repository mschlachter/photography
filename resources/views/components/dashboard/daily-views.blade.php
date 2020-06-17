<div class="card card-chart">
	<div class="card-header card-header-warning">
		<div class="ct-chart position-relative" id="dailyViewsChart"><span class="material-icons" style="height:150px;">hourglass_empty</span></div>
	</div>
	<div class="card-body">
		<h4 class="card-title">Daily Views</h4>
		<p class="card-category" id="dailyViewsChange">
			Loading…
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
    // get our data:
    $.ajax('{{ route('admin.dashboard.data.daily-views') }}', {
      success: function(data) {
        let labels = data.labels;
        let values = data.values;
        let change = (+data.change);

        // Build chart:

        dataDailyViewsChart = {
          labels: labels,
          series: [values]
        };

        optionsDailyViewsChart = {
          lineSmooth: Chartist.Interpolation.cardinal({
            tension: 0
          }),
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
            tooltipFnc: function(meta, value) { return meta + value + ' view' + (value == 1 ? '' : 's'); }
          })
          ]
        }

        document.getElementById('dailyViewsChart').innerHTML = '';

        var dailyViewsChart = new Chartist.Line('#dailyViewsChart', dataDailyViewsChart, optionsDailyViewsChart
        );

        // Update '% increase' value
        
        changeHtml = '';

        if(change < 0) {
          changeHtml = '<span class="text-danger"><i class="fa fa-long-arrow-down"></i> ' + change + '% </span> decrease in daily views yesterday.';
        } else {
          changeHtml = '<span class="text-success"><i class="fa fa-long-arrow-up"></i> ' + change + '% </span> increase in daily views yesterday.';
        }

        document.getElementById('dailyViewsChange').innerHTML = changeHtml;
      }
    });
  });
</script>
@endpush