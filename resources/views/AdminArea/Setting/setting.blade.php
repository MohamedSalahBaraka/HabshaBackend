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
    <div class="d-flex flex-column align-items-center justify-content-center mt-4">
        <div class="h1">Basic Info</div>
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
        <form method="POST" action="{{ route('admin.setting.store') }}" class="w-75" enctype="multipart/form-data">
            @csrf
            <div class="form-floating mb-3">
                <input type="text" class="form-control @error('sitename') is-invalid @enderror" name="sitename"
                    @isset($sitename)
                       value="{{ $sitename }}"
                    @endisset
                    autofocus>
                <label for="floatingInput">اسم الموقع</label>
                @error('sitename')
                    <span class="invalid-feedback" sitename="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-floating mb-3">
                <label for="exampleColorInput" class="form-label">اللون الأساسي</label>
                <input type="color" class="form-control form-control-color" id="exampleColorInput"
                    @isset($primaryColor)
                      value="{{ $primaryColor }}"
                  @endisset
                    title="Choose your color" name="primaryColor">
                @error('primaryColor')
                    <span class="invalid-feedback" primaryColor="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-floating mb-3">
                <label for="exampleColorInput" class="form-label">اللون الثانوي</label>
                <input type="color" class="form-control form-control-color" id="exampleColorInput"
                    @isset($secondaryColor)
                      value="{{ $secondaryColor }}"
                  @endisset
                    title="Choose your color" name="secondaryColor">
                @error('secondaryColor')
                    <span class="invalid-feedback" secondaryColor="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control @error('facebook') is-invalid @enderror" name="facebook"
                    @isset($facebook)
                       value="{{ $facebook }}"
                    @endisset
                    autofocus>
                <label for="floatingInput">facebook</label>
                @error('facebook')
                    <span class="invalid-feedback" facebook="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control @error('whatsapp') is-invalid @enderror" name="whatsapp"
                    @isset($whatsapp)
                       value="{{ $whatsapp }}"
                    @endisset
                    autofocus>
                <label for="floatingInput">whatsapp</label>
                @error('whatsapp')
                    <span class="invalid-feedback" whatsapp="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control @error('telegram') is-invalid @enderror" name="telegram"
                    @isset($telegram)
                       value="{{ $telegram }}"
                    @endisset
                    autofocus>
                <label for="floatingInput">telegram</label>
                @error('telegram')
                    <span class="invalid-feedback" telegram="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control @error('twitter') is-invalid @enderror" name="twitter"
                    @isset($twitter)
                       value="{{ $twitter }}"
                    @endisset
                    autofocus>
                <label for="floatingInput">twitter</label>
                @error('twitter')
                    <span class="invalid-feedback" twitter="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control @error('instagram') is-invalid @enderror" name="instagram"
                    @isset($instagram)
                       value="{{ $instagram }}"
                    @endisset
                    autofocus>
                <label for="floatingInput">instagram</label>
                @error('instagram')
                    <span class="invalid-feedback" instagram="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control @error('youtube') is-invalid @enderror" name="youtube"
                    @isset($youtube)
                       value="{{ $youtube }}"
                    @endisset
                    autofocus>
                <label for="floatingInput">youtube</label>
                @error('youtube')
                    <span class="invalid-feedback" youtube="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone"
                    @isset($phone)
                        value="{{ $phone }}"
                    @endisset
                    autofocus>
                <label for="floatingInput">رقم الهاتف</label>
                @error('phone')
                    <span class="invalid-feedback" phone="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-floating mb-3">
                @isset($logo)
                    <img src="{{ asset('images/' . $logo) }}" alt="" class="img-fluid" style="max-height: 400px" />
                @endisset
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
                <div class="d-grid"><button class="btn btn-primary btn-block headding" type="submit">Save</button>
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
