<div class="row g-3 theme_image">

    @foreach ($newpath as $path)

        <div class="col-6">
            <div class="rounded-2 themeinfo-selection border cursor-pointer overflow-hidden h-100 them-card-box">
                <img src='{{ $path }}' alt="" class="card-img-top them-name-images shadow rounded-2">
            </div>
        </div>

    @endforeach

</div>

