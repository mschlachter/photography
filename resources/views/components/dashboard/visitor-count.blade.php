<div class="card card-stats">
  <div class="card-header card-header-success card-header-icon">
    <div class="card-icon">
      <i class="material-icons">store</i>
    </div>
    <p class="card-category">Visitors</p>
    <h3 class="card-title" id="visitorCount">Loading…</h3>
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
    $.ajax('{{ route('admin.dashboard.data.visitor-count') }}', {
      success: function(data) {
        document.getElementById('visitorCount').innerHTML = data;
      }
    });
  });
</script>
@endpush