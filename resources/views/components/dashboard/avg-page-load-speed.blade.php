<div class="card card-stats">
  <div class="card-header card-header-info card-header-icon">
    <div class="card-icon">
      <i class="material-icons">speed</i>
    </div>
    <p class="card-category">Avg. Page Load Time</p>
    <h3 class="card-title" id="avgPageLoadSpeed">Loading…</h3>
  </div>
  <div class="card-footer">
    <div class="stats">
      <i class="material-icons">date_range</i> Last 7 days
    </div>
  </div>
</div>

@push('js')
<script>
  $(document).ready(function() {
    /* get our data: */
    $.ajax('{{ route('admin.dashboard.data.avg-page-load-speed') }}', {
      success: function(data) {
        document.getElementById('avgPageLoadSpeed').innerHTML = data;
      }
    });
  });
</script>
@endpush