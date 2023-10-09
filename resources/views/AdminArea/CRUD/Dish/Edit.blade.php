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
        <div class="h1">عدل طبق</div>
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
        <form method="POST" action="{{ route('admin.Dish.Update') }}" class="w-75" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="model_id" value="{{ $dish->id }}">
            <div class="form-floating mb-3">

                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                    value="{{ $dish->name }}" required autofocus>
                <label for="floatingInput">الاسم</label>
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-floating mb-3">
                <img src="{{ asset('images/' . $dish->photo) }}" alt="" class="img-fluid"
                    style="max-height: 400px" />
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
            <div class="form-group mb-3">
                <label for="" class="headding mb-2">اختر التصنيف</label>
                <select id="type" class="form-control headding @error('category_id') is-invalid @enderror"
                    name="category_id" value="{{ old('category_id') }}" required autocomplete="category_id">
                    <option value="-1" class="headding">اختر النوع</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            @if (!is_null($dish->category)) {{ $dish->category->id == $category->id ? 'checked' : '' }} @endif
                            class="headding">{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="" class="headding mb-2">تفاصيل الطبق</label>
                <textarea id="myTextarea" rows="10" class="form-control w-100 tinymce @error('details') is-invalid @enderror"
                    name="details" value="{{ old('details') }}" autocomplete="details">{!! $dish->details !!}</textarea>
                @error('details')
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
