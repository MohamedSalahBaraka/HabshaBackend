@extends('layouts.Admin')
@section('content')
    <div class="d-flex flex-column w-100 align-items-center justify-content-center mt-4">
        <div class="h1">العناوين</div>
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
        <form method="POST" action="{{ route('admin.User.addressStore') }}" class="w-75" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{ $user->id }}">
            <label for="" class="headding mb-2">عنوان الاستلام</label>
            <div class="form-group mb-3">
                <label for="" class="headding mb-2">اختر المدينة</label>
                <select id="type" class="form-control headding @error('city') is-invalid @enderror" name="city"
                    value="{{ old('city') }}" required autocomplete="city">
                    <option value="-1" class="headding">اختر المدينة</option>
                    @foreach ($cities as $city)
                        <option value="{{ $city->id }}"
                            @if (!is_null($user->address) && !is_null($user->address->city)) {{ $user->address->city->id == $city->id ? 'checked' : '' }} @endif
                            class="headding">{{ $city->name }}</option>
                    @endforeach
                </select>
                @error('city')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-floating mb-3">

                <input type="text" class="form-control @error('neighbourhood') is-invalid @enderror" name="neighbourhood"
                    value="@if (!is_null($user->address)) {{ $user->address->neighbourhood }} @endif" required
                    autofocus>
                <label for="floatingInput">الحي</label>
                @error('neighbourhood')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="" class="headding mb-2">تفاصيل</label>
                <textarea id="myTextarea" rows="10" class="form-control w-100 tinymce @error('details') is-invalid @enderror"
                    name="details" value="{{ old('details') }}" autocomplete="details">
@if (!is_null($user->address))
{{ $user->address->details }}
@endif
</textarea>
                @error('details')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-floating mb-3">

                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                    value="@if (!is_null($user->address)) {{ $user->address->name }} @endif" autofocus>
                <label for="floatingInput">الاسم</label>
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-floating mb-3">

                <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone"
                    value="@if (!is_null($user->address)) {{ $user->address->phone }} @endif" autofocus>
                <label for="floatingInput">رقم الهاتف</label>
                @error('phone')
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
                        <option value="{{ $city->id }}"
                            @if (!is_null($user->addressSent) && !is_null($user->addressSent->city)) {{ $user->addressSent->city->id == $city->id ? 'checked' : '' }} @endif
                            class="headding">{{ $city->name }}</option>
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
                    name="neighbourhoodSent"
                    value="@if (!is_null($user->addressSent)) {{ $user->addressSent->neighbourhood }} @endif" required
                    autofocus>
                <label for="floatingInput">الحي</label>
                @error('neighbourhoodSent')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="" class="headding mb-2">تفاصيل</label>
                <textarea id="myTextarea" rows="10" class="form-control w-100 tinymce @error('detailsSent') is-invalid @enderror"
                    name="detailsSent" value="{{ old('detailsSent') }}" autocomplete="detailsSent">
@if (!is_null($user->addressSent))
{{ $user->addressSent->details }}
@endif
</textarea>
                @error('details')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-floating mb-3">

                <input type="text" class="form-control @error('nameSent') is-invalid @enderror" name="nameSent"
                    value="@if (!is_null($user->addressSent)) {{ $user->addressSent->name }} @endif" autofocus>
                <label for="floatingInput">الاسم</label>
                @error('nameSent')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-floating mb-3">

                <input type="text" class="form-control @error('phoneSent') is-invalid @enderror" name="phoneSent"
                    value="@if (!is_null($user->addressSent)) {{ $user->addressSent->phone }} @endif" autofocus>
                <label for="floatingInput">رقم الهاتف</label>
                @error('phoneSent')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <label for="" class="headding mb-2">عنوان توصيل الطعام</label>
            <div class="form-group mb-3">
                <label for="" class="headding mb-2">اختر المدينة</label>
                <select id="type" class="form-control headding @error('cityFood') is-invalid @enderror"
                    name="cityFood" value="{{ old('cityFood') }}" required autocomplete="cityFood">
                    <option value="-1" class="headding">اختر المدينة</option>
                    @foreach ($cities as $city)
                        <option value="{{ $city->id }}"
                            @if (!is_null($user->addressFood) && !is_null($user->addressFood->city)) {{ $user->addressFood->city->id == $city->id ? 'checked' : '' }} @endif
                            class="headding">{{ $city->name }}</option>
                    @endforeach
                </select>
                @error('cityFood')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-floating mb-3">

                <input type="text" class="form-control @error('neighbourhoodFood') is-invalid @enderror"
                    name="neighbourhoodFood"
                    value="@if (!is_null($user->addressFood)) {{ $user->addressFood->neighbourhood }} @endif" required
                    autofocus>
                <label for="floatingInput">الحي</label>
                @error('neighbourhoodFood')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="" class="headding mb-2">تفاصيل</label>
                <textarea id="myTextarea" rows="10"
                    class="form-control w-100 tinymce @error('detailsFood') is-invalid @enderror" name="detailsFood"
                    value="{{ old('detailsFood') }}" autocomplete="detailsFood">
@if (!is_null($user->addressFood))
{{ $user->addressFood->details }}
@endif
</textarea>
                @error('details')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-floating mb-3">

                <input type="text" class="form-control @error('nameFood') is-invalid @enderror" name="nameFood"
                    value="@if (!is_null($user->addressFood)) {{ $user->addressFood->name }} @endif" autofocus>
                <label for="floatingInput">الاسم</label>
                @error('nameFood')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-floating mb-3">

                <input type="text" class="form-control @error('phoneFood') is-invalid @enderror" name="phoneFood"
                    value="@if (!is_null($user->addressFood)) {{ $user->addressFood->phone }} @endif" autofocus>
                <label for="floatingInput">رقم الهاتف</label>
                @error('phoneFood')
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
