@extends('layouts.Admin')
@section('content')
    <div class="d-flex flex-column w-100 align-items-center justify-content-center mt-4">
        <div class="h1">ارسل شعارات</div>
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
        <form method="POST" action="{{ route('admin.User.sendNotifications') }}" class="w-75" enctype="multipart/form-data">
            @csrf
            <label for="" class="headding mb-2">شعارات</label>
            <input type="hidden" name="type" value="{{ $type }}">
            <div class="form-floating mb-3">

                <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" required
                    autofocus>
                <label for="floatingInput">عنوان</label>
                @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="" class="headding mb-2">تفاصيل</label>
                <textarea id="myTextarea" rows="10" class="form-control w-100 tinymce @error('body') is-invalid @enderror"
                    name="body" value="{{ old('body') }}" autocomplete="body"></textarea>
                @error('body')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mt-4 mb-0">
                <div class="d-grid"><button class="btn btn-warning btn-block headding" type="submit">ارسل</button>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('script')
    <script src="{{ asset('js/select.js') }}"></script>
    <script>
        var captin = document.querySelector('#captin');
        var user = document.querySelector('#user');

        dselect(captin, {
            search: true
        });
        dselect(user, {
            search: true
        });
    </script>
@endsection
