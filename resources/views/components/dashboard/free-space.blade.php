@php
$bytes = disk_free_space(".");
$si_prefix = array( 'B', 'KB', 'MB', 'GB', 'TB', 'EB', 'ZB', 'YB' );
$base = 1024;
$class = min((int)log($bytes , $base) , count($si_prefix) - 1);
@endphp

<div class="card card-stats">
  <div class="card-header card-header-warning card-header-icon">
    <div class="card-icon">
      <i class="material-icons">content_copy</i>
    </div>
    <p class="card-category">Free Space</p>
    <h3 class="card-title">{{ sprintf('%1.2f' , $bytes / pow($base,$class)) }}
      <small>{{ $si_prefix[$class] }}</small>
    </h3>
  </div>
  <div class="card-footer">
    <div class="stats">
      <i class="material-icons text-danger">warning</i>
      <a href=" mailto:sales@schlachter.ca?subject=Request%20for%20more%20space%3A%20{{ config('app.url') }}&body=Hello%2C%0D%0A%0D%0AI%20would%20like%20to%20request%20more%20space%20on%20my%20photography%20website%20because%20I%20only%20have%20{{ sprintf('%1.2f' , $bytes / pow($base,$class)) . ' ' . $si_prefix[$class] }}%20left.%0D%0A%0D%0AI%20would%20like%20to%20request%3A%20%5B%5B%20The%20amount%20of%20additional%20space%20you%20would%20like%20to%20request%20%5D%5D%0D%0A%0D%0AThank%20you%2C%0D%0A%5B%5B%20Your%20name%20%5D%5D">Get More Space...</a>
    </div>
  </div>
</div>