@extends('layouts.app', ['activePage' => 'dashboard', 'titlePage' => __('Search Results for ":query"', compact('query'))])

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title ">Tags</h4>
            <p class="card-category">Tags containing your query "{{ $query }}"</p>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table">
                <thead class=" text-primary">
                  <th>
                    Name
                  </th>
                  <th>
                    Date
                  </th>
                  <th>
                    Images
                  </th>
                </thead>
                <tbody>
                  @foreach($tags as $tag)
                  <tr>
                    <td>
                      <a class="font-weight-bold" href="{{ $tag['url'] }}">
                        {{ $tag['name'] }}
                      </a>
                    </td>
                    <td>
                      {{ $tag['date'] }}
                    </td>
                    <td>
                      {{ $tag['images'] }}
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title ">Albums</h4>
            <p class="card-category">Albums containing your query "{{ $query }}"</p>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table">
                <thead class=" text-primary">
                  <th>
                    Title
                  </th>
                  <th>
                    Date
                  </th>
                  <th>
                    Images
                  </th>
                </thead>
                <tbody>
                  @foreach($albums as $album)
                  <tr>
                    <td>
                      <a class="font-weight-bold" href="{{ $album['url'] }}">
                        {{ $album['title'] }}
                      </a>
                    </td>
                    <td>
                      {{ $album['date'] }}
                    </td>
                    <td>
                      {{ $album['images'] }}
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title ">Images</h4>
            <p class="card-category">Images containing your query "{{ $query }}"</p>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table">
                <thead class=" text-primary">
                  <th>
                    Title
                  </th>
                  <th>
                    Album
                  </th>
                  <th>
                    Date
                  </th>
                </thead>
                <tbody>
                  @foreach($images as $image)
                  <tr>
                    <td>
                      <a class="font-weight-bold" href="{{ $image['url'] }}">
                        <span style="display: inline-block; width: 100px; margin-right: 1rem;">
                          <img src="{{ $image['thumb'] }}" alt="" style="max-width: 100px; max-height: 100px;">
                        </span>
                        {{ $image['title'] }}
                      </a>
                    </td>
                    <td>
                      {{ $image['album']['title'] }}
                    </td>
                    <td>
                      {{ $image['date'] }}
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection