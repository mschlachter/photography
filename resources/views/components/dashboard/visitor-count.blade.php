@inject('analytics', App\Libraries\ToolboxGoogleAnalytics)
@php
  // Get our values for the dashboard:
$sessionsForLast7Days = $analytics->getSessionsForLast7Days();
@endphp
<div class="card card-stats">
  <div class="card-header card-header-success card-header-icon">
    <div class="card-icon">
      <i class="material-icons">store</i>
    </div>
    <p class="card-category">Visitors</p>
    <h3 class="card-title">{{ $sessionsForLast7Days }}</h3>
  </div>
  <div class="card-footer">
    <div class="stats">
      <i class="material-icons">date_range</i> Last 7 days
    </div>
  </div>
</div>