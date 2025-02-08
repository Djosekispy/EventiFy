<div class="container my-4">
   <div class="row justify-content-center gy-4">
        @foreach ($categories as $index => $item)
        <div class="col-6 col-sm-4 col-md-3 col-lg-2 text-center">
            <a href="/search/category/{{$item->id}}" class="text-decoration-none text-dark">
                <div class="d-flex flex-column align-items-center">
                    <img src="{{ asset($images[$index]) }}" alt="{{ $item->category_title }}" 
                        class="rounded-circle border border-secondary" 
                        style="width: 100px; height: 100px; object-fit: cover;">
                    <p class="mt-2 fw-semibold">{{ $item->category_title }}</p>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>
