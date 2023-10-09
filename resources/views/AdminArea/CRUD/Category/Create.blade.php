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
    {{-- checkbox style --}}
    <style>
        #checklist {
            --background: #ffffff;
            --text: #414856;
            --check: #4f29f0;
            --disabled: #c3c8de;
            --width: 100px;
            --height: 140px;
            --border-radius: 10px;
            background: var(--background);
            /* width: var(--width); */
            /* height: var(--height); */
            border-radius: var(--border-radius);
            position: relative;
            box-shadow: 0 10px 30px rgba(65, 72, 86, 0.05);
            padding: 30px 45px;
            display: grid;
            grid-template-columns: 30px auto;
            align-items: center;
        }

        #checklist label {
            color: var(--text);
            position: relative;
            cursor: pointer;
            display: grid;
            align-items: center;
            width: -webkit-fit-content;
            width: -moz-fit-content;
            width: fit-content;
            transition: color 0.3s ease;
        }

        #checklist label::before,
        #checklist label::after {
            content: "";
            position: absolute;
        }

        #checklist label::before {
            height: 2px;
            width: 8px;
            left: -27px;
            background: var(--check);
            border-radius: 2px;
            transition: background 0.3s ease;
        }

        #checklist label:after {
            height: 4px;
            width: 4px;
            top: 8px;
            left: -25px;
            border-radius: 50%;
        }

        #checklist input[type=checkbox] {
            -webkit-appearance: none;
            -moz-appearance: none;
            position: relative;
            height: 15px;
            width: 15px;
            outline: none;
            border: 0;
            margin: 0 15px 0 0;
            cursor: pointer;
            background: var(--background);
            display: grid;
            align-items: center;
        }

        #checklist input[type=checkbox]::before,
        #checklist input[type=checkbox]::after {
            content: "";
            position: absolute;
            height: 2px;
            top: auto;
            background: var(--check);
            border-radius: 2px;
        }

        #checklist input[type=checkbox]::before {
            width: 0px;
            right: 60%;
            transform-origin: right bottom;
        }

        #checklist input[type=checkbox]::after {
            width: 0px;
            left: 40%;
            transform-origin: left bottom;
        }

        #checklist input[type=checkbox]:checked::before {
            -webkit-animation: check-01 0.4s ease forwards;
            animation: check-01 0.4s ease forwards;
        }

        #checklist input[type=checkbox]:checked::after {
            -webkit-animation: check-02 0.4s ease forwards;
            animation: check-02 0.4s ease forwards;
        }

        #checklist input[type=checkbox]:checked+label {
            color: var(--disabled);
            -webkit-animation: move 0.3s ease 0.1s forwards;
            animation: move 0.3s ease 0.1s forwards;
        }

        #checklist input[type=checkbox]:checked+label::before {
            background: var(--disabled);
            -webkit-animation: slice 0.4s ease forwards;
            animation: slice 0.4s ease forwards;
        }

        #checklist input[type=checkbox]:checked+label::after {
            -webkit-animation: firework 0.5s ease forwards 0.1s;
            animation: firework 0.5s ease forwards 0.1s;
        }

        @-webkit-keyframes move {
            50% {
                padding-left: 8px;
                padding-right: 0px;
            }

            100% {
                padding-right: 4px;
            }
        }

        @keyframes move {
            50% {
                padding-left: 8px;
                padding-right: 0px;
            }

            100% {
                padding-right: 4px;
            }
        }

        @-webkit-keyframes slice {
            60% {
                width: 100%;
                left: 4px;
            }

            100% {
                width: 100%;
                left: -2px;
                padding-left: 0;
            }
        }

        @keyframes slice {
            60% {
                width: 100%;
                left: 4px;
            }

            100% {
                width: 100%;
                left: -2px;
                padding-left: 0;
            }
        }

        @-webkit-keyframes check-01 {
            0% {
                width: 4px;
                top: auto;
                transform: rotate(0);
            }

            50% {
                width: 0px;
                top: auto;
                transform: rotate(0);
            }

            51% {
                width: 0px;
                top: 8px;
                transform: rotate(45deg);
            }

            100% {
                width: 5px;
                top: 8px;
                transform: rotate(45deg);
            }
        }

        @keyframes check-01 {
            0% {
                width: 4px;
                top: auto;
                transform: rotate(0);
            }

            50% {
                width: 0px;
                top: auto;
                transform: rotate(0);
            }

            51% {
                width: 0px;
                top: 8px;
                transform: rotate(45deg);
            }

            100% {
                width: 5px;
                top: 8px;
                transform: rotate(45deg);
            }
        }

        @-webkit-keyframes check-02 {
            0% {
                width: 4px;
                top: auto;
                transform: rotate(0);
            }

            50% {
                width: 0px;
                top: auto;
                transform: rotate(0);
            }

            51% {
                width: 0px;
                top: 8px;
                transform: rotate(-45deg);
            }

            100% {
                width: 10px;
                top: 8px;
                transform: rotate(-45deg);
            }
        }

        @keyframes check-02 {
            0% {
                width: 4px;
                top: auto;
                transform: rotate(0);
            }

            50% {
                width: 0px;
                top: auto;
                transform: rotate(0);
            }

            51% {
                width: 0px;
                top: 8px;
                transform: rotate(-45deg);
            }

            100% {
                width: 10px;
                top: 8px;
                transform: rotate(-45deg);
            }
        }

        @-webkit-keyframes firework {
            0% {
                opacity: 1;
                box-shadow: 0 0 0 -2px #4f29f0, 0 0 0 -2px #4f29f0, 0 0 0 -2px #4f29f0, 0 0 0 -2px #4f29f0, 0 0 0 -2px #4f29f0, 0 0 0 -2px #4f29f0;
            }

            30% {
                opacity: 1;
            }

            100% {
                opacity: 0;
                box-shadow: 0 -15px 0 0px #4f29f0, 14px -8px 0 0px #4f29f0, 14px 8px 0 0px #4f29f0, 0 15px 0 0px #4f29f0, -14px 8px 0 0px #4f29f0, -14px -8px 0 0px #4f29f0;
            }
        }

        @keyframes firework {
            0% {
                opacity: 1;
                box-shadow: 0 0 0 -2px #4f29f0, 0 0 0 -2px #4f29f0, 0 0 0 -2px #4f29f0, 0 0 0 -2px #4f29f0, 0 0 0 -2px #4f29f0, 0 0 0 -2px #4f29f0;
            }

            30% {
                opacity: 1;
            }

            100% {
                opacity: 0;
                box-shadow: 0 -15px 0 0px #4f29f0, 14px -8px 0 0px #4f29f0, 14px 8px 0 0px #4f29f0, 0 15px 0 0px #4f29f0, -14px 8px 0 0px #4f29f0, -14px -8px 0 0px #4f29f0;
            }
        }
    </style>
@endsection

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
        <form method="POST" action="{{ route('admin.Category.store') }}" class="w-75" enctype="multipart/form-data">
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
            <div class="mt-4 mb-0">
                <div class="d-grid"><button class="btn btn-primary btn-block headding" type="submit">احفظ</button>
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
