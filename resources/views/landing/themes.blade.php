

<div class="row theme_image">
    @foreach ($newpath as $path)
    <div class="col-6 mb-3">
        <div class="theme-selection border cursor-pointer"><img src='{{$path}}' alt="" class="w-100" height="300"></div>
    </div>
    @endforeach
</div>


