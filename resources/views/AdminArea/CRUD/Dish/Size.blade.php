@extends('layouts.Admin')
@section('content')
    <div class="py-5 container">
        <div class="headding">الاحجام الطبق {{ $dish->name }}</div>
        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif
        @if (session()->has('error'))
            <div class="alert alert-danger">
                {{ session()->get('error') }}
            </div>
        @endif
        <form id="sort-form" action="{{ route('admin.dish.size', ['dish_id' => $dish->id]) }}" method="GET" class="d-none">
            <input type="hidden" name="order" id="order">
            @if (request()->has('dish_id'))
                <input type="hidden" name="dish_id" value="{{ request()->string('dish_id') }}">
            @endif
            <input type="hidden" name="dir" id="dir" value="{{ $dir }}">

        </form>
        <form action="{{ route('admin.dish.size', ['dish_id' => $dish->id]) }}" method="GET" class="container row">
            @if (request()->has('dish_id'))
                <input type="hidden" name="dish_id" value="{{ request()->string('dish_id') }}">
            @endif
            <div class="form-group col-6">
                <input type="text" class="form-control" name="keyword">
            </div>
            <button class="btn btn-primary" style="width: fit-content">ابحث</button>
        </form>
        <form id="add-form" class="container " method="POST" action="{{ route('admin.dish.sizeStore') }}">
            @csrf
            <div class="headding">اضف حجم</div>
            <div class="form-group">
                <label for="" class="form-lablel headding">اسم الحجم</label>

                <input type="text" class="form-control mb-3 @error('name') is-invalid @enderror" name="name"
                    value="{{ old('name') }}" required autocomplete="name" autofocus />
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="" class="form-lablel headding">سعر الحجم</label>

                <input type="number" class="form-control mb-3 @error('price') is-invalid @enderror" name="price"
                    value="{{ old('price') }}" required autocomplete="price" autofocus />
                @error('price')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <input type="hidden" name="dish_id" value="{{ $dish->id }}" />
            <button class="btn btn-primary headding" id="add-grade" type="submit">أضف</button>
        </form>
        <form id="edit-form" class="container d-none" method="POST" action="{{ route('admin.dish.sizeupdate') }}">
            @csrf
            <div class="headding">عدل على حجم </div>
            <div class="form-group">
                <label for="" class="form-lablel headding">اسم الحجم</label>

                <input type="text" id="name" class="form-control mb-3 @error('name') is-invalid @enderror"
                    name="name" value="{{ old('name') }}" required autocomplete="name" autofocus />
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="" class="form-lablel headding">سعر الحجم</label>

                <input type="number" id="price" class="form-control mb-3 @error('price') is-invalid @enderror"
                    name="price" value="{{ old('price') }}" required autocomplete="price" autofocus />
                @error('price')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <input type="hidden" name="id" id="id" />
            <button class="btn btn-warning headding" type="submit">عدل</button>
        </form>
        <div class="table-responsive ">
            <table class="table table-width">
                <thead class="headding">
                    <th> <a class="nav-link normal" href="{{ route('admin.dish.size', ['dish_id' => $dish->id]) }}"
                            onclick="event.preventDefault();
                             document.getElementById('order').value = 'id';
                             document.getElementById('sort-form').submit();">#</a>
                    </th>
                    <th><a class="nav-link normal" href="{{ route('admin.dish.size', ['dish_id' => $dish->id]) }}"
                            onclick="event.preventDefault();
                             document.getElementById('order').value = 'name';
                             document.getElementById('sort-form').submit();">اسم
                        </a></th>
                    <th><a class="nav-link normal" href="{{ route('admin.dish.size', ['dish_id' => $dish->id]) }}"
                            onclick="event.preventDefault();
                             document.getElementById('order').value = 'price';
                             document.getElementById('sort-form').submit();">السعر
                        </a></th>
                    <th>حذف</th>
                    <th>تعديل</th>
                </thead>

                <tbody id="table" class="normal">
                    <?php $i = 1; ?>
                    @foreach ($sizes as $size)
                        <tr>
                            <th>{{ $i }}</th>
                            <td>{{ $size->name }}</td>
                            <td>{{ $size->price }}</td>
                            <td><a href="{{ route('admin.dish.size.delete', $size->id) }}"
                                    onclick="return confirm('هل انت متأكد من رغبتك بالحذف؟')"
                                    class="btn btn-danger headding">حذف</a>
                            </td>
                            <td> <button class="btn btn-warning headding edit" data-id="{{ $size->id }}"
                                    data-name="{{ $size->name }}" data-price="{{ $size->price }}">
                                    عدل
                                </button></td>
                        </tr>
                        <?php $i++; ?>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {!! $sizes->onEachSide(5)->links('vendor.pagination.default') !!}
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script>
        $('.edit').on('click', function() {
            let id = $(this).data('id');
            let name = $(this).data('name');
            let price = $(this).data('price');
            $('#id').val(id);
            $('#price').val(price);
            $('#name').val(name);
            $('#edit-form').removeClass('d-none');
            $('#add-form').addClass('d-none');
        });
    </script>
@endsection
