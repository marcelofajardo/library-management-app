<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">@yield('content_header')</h1>
        </div><!-- /.col -->
         <div class="col-sm-6">
           @if (isset($breadcrumbs) && !empty($breadcrumbs))
            <ol class="breadcrumb float-sm-right">
              @foreach ($breadcrumbs as $key => $breadcrumb)
                <li class="breadcrumb-item {{ $key == (count($breadcrumbs) - 1) ? 'active' : '' }}">
                  @if ($key == (count($breadcrumbs) - 1))
                    {{ $breadcrumb['name'] }}
                  @else 
                    <a href="{{ $breadcrumb['link'] }}">{{ $breadcrumb['name'] }}</a>
                  @endif
                </li>
              @endforeach
            </ol>
           @endif
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>