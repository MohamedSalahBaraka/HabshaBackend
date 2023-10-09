@extends('layouts.Admin')
@section('css')
    <style>
        .drag-area {
            border: 2px dashed #555;
            height: 500px;
            width: 700px;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        @media screen and (max-width: 768px) {
            .drag-area {
                height: 300px;
                width: 90%;
            }
        }

        .drag-area.active {
            border: 2px solid #555;
        }

        .drag-area .icon {
            font-size: 100px;
            color: #555;
        }

        .drag-area header {
            font-size: 30px;
            font-weight: 500;
            color: #555;
        }

        .drag-area span {
            font-size: 25px;
            font-weight: 500;
            color: #555;
            margin: 10px 0 15px 0;
        }

        .drag-area button {
            padding: 10px 25px;
            font-size: 25px;
            font-weight: 500;
            border: none;
            outline: none;
            background-color: #555;
            color: #eee;
            border-radius: 5px;
            cursor: pointer;
        }

        .drag-area img {
            height: 100%;
            width: 100%;
            object-fit: cover;
            border-radius: 5px;
        }
    </style>
@endsection
@section('content')
    <div class="d-flex flex-column w-100 align-items-center justify-content-center mt-4">
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
        <form method="POST" action="{{ route('admin.User.store') }}" class="w-75" enctype="multipart/form-data">
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
            <div class="form-floating mb-3">
                <input type="phone" class="form-control @error('phone') is-invalid @enderror" name="phone"
                    value="{{ old('phone') }}" required autofocus>
                <label for="floatingInput">رقم الهاتف</label>
                @error('phone')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password"
                    value="{{ old('password') }}" required autofocus>
                <label for="floatingPassword">كلمة السر</label>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                    name="password_confirmation" value="{{ old('password_confirmation') }}" required autofocus>
                <label for="floatingPassword">أكد كلمة السر</label>
                @error('password_confirmation')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <input type="hidden" name="type" value="{{ $type }}">
            @if ($type == 'restaurant')
                <div class="form-floating mb-3">
                    <div class="drag-area">
                        <div class="icon"><i class="fas fa-cloud-upload-alt"></i></div>
                        <header>drag & drop to upload a photo</header>
                        <span>OR</span>
                        <button>browser a photo</button>
                    </div>
                    <input class="drag-area-input" type="file" name="photo" hidden />
                    @error('photo')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-floating mb-3">

                    <input type="number" max="100" class="form-control @error('opening') is-invalid @enderror"
                        name="opening" required autofocus>
                    <label for="floatingInput">سا عة الفتح</label>
                    @error('opening')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-floating mb-3">

                    <input type="number" max="100" class="form-control @error('clothing') is-invalid @enderror"
                        name="clothing" required autofocus>
                    <label for="floatingInput">سا عة الاغلاق</label>
                    @error('clothing')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-floating mb-3">

                    <input type="number" max="100" class="form-control @error('fee') is-invalid @enderror"
                        name="fee" required autofocus>
                    <label for="floatingInput">نسبة الخصم من 100</label>
                    @error('fee')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <label for="" class="headding mb-2">عنوان الاستلام</label>
                <div class="form-group mb-3">
                    <label for="" class="headding mb-2">اختر المدينة</label>
                    <select id="type" class="form-control headding @error('city') is-invalid @enderror" name="city"
                        value="{{ old('city') }}" required autocomplete="city">
                        <option value="-1" class="headding">اختر المدينة</option>
                        @foreach ($cities as $city)
                            <option value="{{ $city->id }}" class="headding">{{ $city->name }}</option>
                        @endforeach
                    </select>
                    @error('city')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-floating mb-3">

                    <input type="text" class="form-control @error('neighbourhood') is-invalid @enderror"
                        name="neighbourhood" required autofocus>
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
                        name="details" value="{{ old('details') }}" autocomplete="details"></textarea>
                    @error('details')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-floating mb-3">

                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="nameaddress"
                        autofocus>
                    <label for="floatingInput">الاسم</label>
                    @error('nameaddress')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-floating mb-3">

                    <input type="text" class="form-control @error('phoneaddress') is-invalid @enderror"
                        name="phoneaddress" autofocus>
                    <label for="floatingInput">رقم الهاتف</label>
                    @error('phoneaddress')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            @endif

            <div class="mt-4 mb-0">
                <div class="d-grid"><button class="btn btn-primary btn-block headding" type="submit">احفظ</button></div>
            </div>
        </form>
    </div>
@endsection
@section('script')
    <script>
        // selection all requiered elements
        const dropArea = document.querySelector('.drag-area'),
            dragText = dropArea.querySelector("header"),
            dropAreaButton = dropArea.querySelector("button"),
            dropAreaInput = document.querySelector(".drag-area-input");
        let file;
        dropAreaButton.onclick = (e) => {
            e.preventDefault();
            dropAreaInput.click();
        }

        dropAreaInput.addEventListener('change', () => {
            file = dropAreaInput.files[0];
            showfile();
        });
        dropAreaInput.addEventListener('change', () => {
            file = dropAreaInput.files[0];
            showfile();
        });
        // if user drag a file over drag area
        dropArea.addEventListener("dragover", e => {
            e.preventDefault();
            dropArea.classList.add('active');
            dragText.textContent = "relase to upload";
        });
        // if user leave drag area
        dropArea.addEventListener("dragleave", () => {
            dropArea.classList.remove('active');
            dragText.textContent = "drag & drop to upload a file";
        });
        // if user drop a file
        dropArea.addEventListener("drop", e => {
            e.preventDefault();
            dropArea.classList.remove('active');
            // getting user selected files
            file = e.dataTransfer.files[0];

            dropAreaInput.files = e.dataTransfer.files;
            // console.log(dropAreaInput.files)
            showfile();
        });

        const showfile = () => {
            let fileType = file.type;
            let validExetentions = ['image/jpeg', 'image/jpg', 'image/png'];
            if (validExetentions.includes(fileType)) {
                let fileReader = new FileReader();
                fileReader.onload = () => {
                    let fileUrl = fileReader.result;
                    let imgTag = `<img src="${fileUrl}"/>`
                    dropArea.innerHTML = imgTag;
                };
                fileReader.readAsDataURL(file);
            } else {
                alert('this not an image!');
                dropArea.classList.remove('active');
            }
        }
    </script>
@endsection
