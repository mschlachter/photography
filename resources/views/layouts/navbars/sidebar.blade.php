<div class="sidebar" data-color="orange" data-background-color="white" data-image="{{ asset('material') }}/img/sidebar-1.jpg">
  <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

      Tip 2: you can also add an image using data-image tag
  -->
  <div class="logo">
    <a href="{{ route('admin.dashboard') }}" class="simple-text logo-normal">
      {{ __('Dashboard') }}
    </a>
  </div>
  <div class="sidebar-wrapper">
    <ul class="nav">
      <li class="nav-item{{ $activePage == 'dashboard' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
          <i class="material-icons">dashboard</i>
            <p>{{ __('Dashboard') }}</p>
        </a>
      </li>
      <li class="nav-item {{ ($activePage == 'albums' || $activePage == 'tags' || $activePage == 'tag-categories') ? ' active' : '' }}">
        <a class="nav-link" data-toggle="collapse" href="#contentMenu" aria-expanded="true">
          <i class="material-icons">insert_photo</i>
          <p>{{ __('Content') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse show" id="contentMenu">
          <ul class="nav">
            <li class="nav-item{{ $activePage == 'albums' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('admin.albums.index') }}">
                <i class="material-icons">collections</i>
                <span class="sidebar-normal">{{ __('Albums') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'tags' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('admin.tags.index') }}">
                <i class="material-icons">loyalty</i>
                <span class="sidebar-normal"> {{ __('Tags') }} </span>
              </a>
            </li>
            <li class="nav-item d-none{{ $activePage == 'tag-categories' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('admin.tag-categories.index') }}">
                <i class="material-icons">category</i>
                <span class="sidebar-normal"> {{ __('Tag Categories') }} </span>
              </a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item{{ $activePage == 'profile' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('admin.profile.edit') }}">
          <i class="material-icons">account_circle</i>
            <p>{{ __('Profile') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'settings' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('admin.settings.index') }}">
          <i class="material-icons">settings</i>
            <p>{{ __('Settings') }}</p>
        </a>
      </li>
    </ul>
  </div>
</div>