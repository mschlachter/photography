
<div class="card card-stats">
  <div class="card-header card-header-danger card-header-icon">
    <div class="card-icon">
      <i class="material-icons">camera_alt</i>
    </div>
    <p class="card-category">Images</p>
    <h3 class="card-title"><a class="card-title" href="{{ route('admin.albums.index') }}">{{ App\Image::count() }}</a></h3>
  </div>
  <div class="card-footer">
    <div class="stats">
      <i class="material-icons">local_offer</i>
      <a href="{{ route('admin.tags.index') }}">{{ App\Tag::count() }} tags
      </a>
    </div>
  </div>
</div>