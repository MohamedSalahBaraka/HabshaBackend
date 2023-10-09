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
                                    <th>
                                        <div class="dropdown">
                                            <a id="navbarDropdown" class="dropdown-toggle" href="#" role="button"
                                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                                <i class="fa fa-gear text-black-50"></i>
                                            </a>

                                            <div class="dropdown-menu dropdown-menu-start" aria-labelledby="navbarDropdown">
                                                <a class="dropdown-item  text-end"
                                                    href="{{ route('admin.User.Model', ['id' => $user->id, 'view' => 'Edit']) }}"><i
                                                        class="fa fa-pen text-black-50 mx-2"></i>تعديل</a>
                                                <a class="dropdown-item  text-end"
                                                    href="{{ route('admin.User.address', ['user_id' => $user->id]) }}"><i
                                                        class="fa fa-pen text-black-50 mx-2"></i>العناوين</a>
                                                @if ($user->type == 'restaurant')
                                                    <a class="dropdown-item  text-end"
                                                        href="{{ route('admin.Dish.Data', ['user_id' => $user->id]) }}"><i
                                                            class="fa fa-pen text-black-50 mx-2"></i>الاطباق</a>
                                                    <a class="dropdown-item  text-end"
                                                        href="{{ route('admin.order.restaurant', ['restaurant_id' => $user->id]) }}"><i
                                                            class="fa fa-pen text-black-50 mx-2"></i>الطلبات السابقة</a>
                                                @endif
                                                @if ($user->type == 'captin')
                                                    <a class="dropdown-item  text-end"
                                                        href="{{ route('admin.delivary.Captin', ['captin_id' => $user->id]) }}"><i
                                                            class="fa fa-pen text-black-50 mx-2"></i>التوصيلات
                                                        السابقة</a>
                                                @endif
                                                @if ($user->type == 'user')
                                                    <a class="dropdown-item  text-end"
                                                        href="{{ route('admin.delivary.User', ['user_id' => $user->id]) }}"><i
                                                            class="fa fa-pen text-black-50 mx-2"></i>طلبات التوصيل</a>
                                                    <a class="dropdown-item  text-end"
                                                        href="{{ route('admin.order.User', ['user_id' => $user->id]) }}"><i
                                                            class="fa fa-pen text-black-50 mx-2"></i>طلبات الطعام</a>
                                                @endif
                                                <a class="dropdown-item text-end"
                                                    onclick="return confirm('هل انت متأكد من رغبتك بالحذف؟')"
                                                    href="{{ route('admin.User.ParmentlyDelete', ['id' => $user->id]) }}"><i
                                                        class="fa fa-pen text-black-50 mx-2"></i>حذف</a>
                                            </div>
                                        </div>الاسم
                                    </th>
                                    <td>{{ $user->name }}</td>
                                </tr>
                                <tr>
                                    <th>رقم الهاتف</th>
                                    <td>{{ $user->phone }}</td>
                                </tr>
                                <tr>
                                    <th>مبالغ مستحقة</th>
                                    <td>{{ $user->money() }}</td>
                                </tr>
                                @if ($user->type == 'restaurant')
                                    <tr>
                                        <th> العمولة</th>
                                        <td>{{ $user->fee }}</td>
                                    </tr>
                                    <tr>
                                        <th> ساعة الفتح</th>
                                        <td>{{ $user->opening }}</td>
                                    </tr>
                                    <tr>
                                        <th> ساعة الاغلاق</th>
                                        <td>{{ $user->clothing }}</td>
                                    </tr>
                                @endif
                                @if (!is_null($user->photo))
                                    <tr>
                                        <th>الصورة</th>
                                        <td><img src="{{ asset('images/' . $user->photo) }}" alt=""
                                                class="img-fluid" style="max-height: 100px" /></td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
