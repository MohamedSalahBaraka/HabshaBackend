@extends('layouts.Admin')

@section('content')
    <div class="container d-flex flex-column flex-grow-1 flex-wrap justify-content-center align-items-center">
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
        <div class="container pt-3">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="table-responsive-md bg-white" data-mdb-perfect-scrollbar="true"
                        style="position: relative; height: 100% ">
                        <table class="table">
                            <thead>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row" style="color: #666666">
                                        <div class="dropdown">
                                            <a id="navbarDropdown" class="dropdown-toggle" href="#" role="button"
                                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                                <i class="fa fa-gear text-black-50"></i>
                                            </a>

                                            <div class="dropdown-menu dropdown-menu-start" aria-labelledby="navbarDropdown">
                                                <a class="dropdown-item text-end"
                                                    href="{{ route('admin.Category.Model', ['id' => $category->id, 'view' => 'Edit']) }}"><i
                                                        class="fa fa-pen text-black-50 mx-2"></i>تعديل</a>
                                                <a class="dropdown-item text-end"
                                                    onclick="return confirm('هل انت متأكد من رغبتك بالحذف؟')"
                                                    href="{{ route('admin.Category.ParmentlyDelete', ['id' => $category->id]) }}"><i
                                                        class="fa fa-pen text-black-50 mx-2"></i>حذف</a>
                                            </div>
                                        </div>الاسم
                                    </th>
                                    <td> {{ $category->name }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" style="color: #666666">تاريخ التحرير</th>
                                    <td> {{ $category->created_at }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" style="color: #666666">الصورة</th>
                                    <td> <img src="{{ asset('images/' . $category->photo) }}" alt=""
                                            class="img-fluid" style="max-height: 100px" /></td>
                                </tr>
                                <tr>
                                    <th scope="row" style="color: #666666">عدد الاطباق</th>
                                    <td>
                                        {{ $category->dishes()->count() }}
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
