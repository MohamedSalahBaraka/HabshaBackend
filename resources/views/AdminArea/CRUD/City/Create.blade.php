@extends('layouts.Admin')
@section('content')
    <div class="d-flex w-100 flex-column align-items-center justify-content-center mt-4">
        <div class="h1">أضف تصنيف</div>
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
        <form method="POST" action="{{ route('admin.City.store') }}" class="w-75" enctype="multipart/form-data">
            @csrf
            <div class="form-floating mb-3">
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                    value="{{ old('name') }}" required autofocus>
                <label for="floatingInput">الاسم</label>
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mt-4 mb-0">
                <div class="d-grid"><button class="btn btn-primary btn-block headding" type="submit">احفظ</button>
                </div>
            </div>
        </form>
    </div>
@endsection
