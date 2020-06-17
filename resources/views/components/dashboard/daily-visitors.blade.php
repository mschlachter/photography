
<div class="card card-chart">
  <div class="card-header card-header-success">
    <div class="ct-chart position-relative" id="dailyVisitorsChart"></div>
  </div>
  <div class="card-body">
    <h4 class="card-title">Daily Visitors</h4>
    <p class="card-category" id="dailyVisitorsChange">
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
    $.ajax('{{ route('admin.dashboard.data.daily-visitors') }}', {
      success: function(data) {
        let labels = data.labels;
        let values = data.values;
        let change = (+data.change);

        // Build chart:

        dataDailyVisitorsChart = {
          labels: labels,
          series: [values]
        };

        optionsDailyVisitorsChart = {
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

        var dailyVisitorsChart = new Chartist.Line('#dailyVisitorsChart', dataDailyVisitorsChart, optionsDailyVisitorsChart
        );

        // Update '% increase' value
        
        changeHtml = '';

        if(change < 0) {
          changeHtml = '<span class="text-danger"><i class="fa fa-long-arrow-down"></i> ' + change + '% </span> decrease in daily visitors yesterday.';
        } else {
          changeHtml = '<span class="text-success"><i class="fa fa-long-arrow-up"></i> ' + change + '% </span> increase in daily visitors yesterday.';
        }

        document.getElementById('dailyVisitorsChange').innerHTML = changeHtml;
      }
    });
    });
  </script>
@endpush