@extends('layouts.Admin')
@section('content')
    <div class="d-flex flex-column w-100 align-items-center justify-content-center mt-4">
        <div class="h1">اضف طلبية توصيل</div>
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
        <form method="POST" action="{{ route('admin.delivary.store') }}" class="w-75" enctype="multipart/form-data">
            @csrf
            <div class="form-floating mb-3">

                <input type="text" class="form-control @error('package') is-invalid @enderror" name="package" required
                    autofocus>
                <label for="floatingInput">الحمولة</label>
                @error('package')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="" class="headding mb-2">اختر الكابتن</label>
                <select id="captin" class="form-control headding @error('captin_id') is-invalid @enderror"
                    name="captin_id" value="{{ old('captin_id') }}" required autocomplete="captin_id">
                    <option value="-1" class="headding">اختر الكابتن</option>
                    @foreach ($captins as $captin)
                        <option value="{{ $captin->id }}" class="headding">{{ $captin->name }}</option>
                    @endforeach
                </select>
                @error('captin_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="" class="headding mb-2">اختر المستخدم</label>
                <select id="user" class="form-control headding @error('user_id') is-invalid @enderror" name="user_id"
                    value="{{ old('user_id') }}" required autocomplete="user_id">
                    <option value="-1" class="headding">اختر المستخدم</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" class="headding">{{ $user->name }}</option>
                    @endforeach
                </select>
                @error('user_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <label for="" class="headding mb-2">عنوان الاستلام</label>
            <div class="form-group mb-3">
                <label for="" class="headding mb-2">اختر المدينة</label>
                <select id="type" class="form-control headding @error('cityGet') is-invalid @enderror" name="cityGet"
                    value="{{ old('cityGet') }}" required autocomplete="cityGet">
                    <option value="-1" class="headding">اختر المدينة</option>
                    @foreach ($cities as $city)
                        <option value="{{ $city->id }}" class="headding">{{ $city->name }}</option>
                    @endforeach
                </select>
                @error('cityGet')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-floating mb-3">

                <input type="text" class="form-control @error('neighbourhoodGet') is-invalid @enderror"
                    name="neighbourhoodGet" required autofocus>
                <label for="floatingInput">الحي</label>
                @error('neighbourhoodGet')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="" class="headding mb-2">تفاصيل</label>
                <textarea id="myTextarea" rows="10" class="form-control w-100 tinymce @error('detailsGet') is-invalid @enderror"
                    name="detailsGet" value="{{ old('detailsGet') }}" autocomplete="detailsGet"></textarea>
                @error('details')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-floating mb-3">

                <input type="text" class="form-control @error('nameGet') is-invalid @enderror" name="nameGet" autofocus>
                <label for="floatingInput">الاسم</label>
                @error('nameGet')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-floating mb-3">

                <input type="text" class="form-control @error('phoneGet') is-invalid @enderror" name="phoneGet"
                    autofocus>
                <label for="floatingInput">رقم الهاتف</label>
                @error('phoneGet')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <label for="" class="headding mb-2">عنوان التسليم</label>
            <div class="form-group mb-3">
                <label for="" class="headding mb-2">اختر المدينة</label>
                <select id="type" class="form-control headding @error('citySent') is-invalid @enderror" name="citySent"
                    value="{{ old('citySent') }}" required autocomplete="citySent">
                    <option value="-1" class="headding">اختر المدينة</option>
                    @foreach ($cities as $city)
                        <option value="{{ $city->id }}" class="headding">{{ $city->name }}</option>
                    @endforeach
                </select>
                @error('citySent')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-floating mb-3">

                <input type="text" class="form-control @error('neighbourhoodSent') is-invalid @enderror"
                    name="neighbourhoodSent" required autofocus>
                <label for="floatingInput">الحي</label>
                @error('neighbourhoodSent')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="" class="headding mb-2">تفاصيل</label>
                <textarea id="myTextarea" rows="10"
                    class="form-control w-100 tinymce @error('detailsSent') is-invalid @enderror" name="detailsSent"
                    value="{{ old('detailsSent') }}" autocomplete="detailsSent"></textarea>
                @error('details')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-floating mb-3">

                <input type="text" class="form-control @error('nameSent') is-invalid @enderror" name="nameSent"
                    autofocus>
                <label for="floatingInput">الاسم</label>
                @error('nameSent')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-floating mb-3">

                <input type="text" class="form-control @error('phoneSent') is-invalid @enderror" name="phoneSent"
                    autofocus>
                <label for="floatingInput">رقم الهاتف</label>
                @error('phoneSent')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mt-4 mb-0">
                <div class="d-grid"><button class="btn btn-warning btn-block headding" type="submit">عدل</button>
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
