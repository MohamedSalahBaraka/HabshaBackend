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
                <label for="floatingInput" class="h1">{{ $title }}</label>
                <form id="sort-form" action="{{ url()->full() }}" method="GET" class="d-none">
                    @if (request()->has('type'))
                        <input type="hidden" name="type" value="{{ request()->string('type') }}">
                    @endif
                    <input type="hidden" name="order" id="order">
                    <input type="hidden" name="dir" id="dir" value="{{ $dir }}">

                </form>
                <form action="{{ url()->full() }}" method="GET" class="container row">

                    <div class="form-group col-6">
                        <input type="text" class="form-control" name="keyword">
                    </div>
                    <button class="btn btn-primary" style="width: fit-content">ابحث</button>
                </form>
                <div class="col-12">
                    <div class="table-responsive-md bg-white" style="position: relative; height: 100% ">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col" width="30px"><a class="nav-link normal" href="{{ url()->full() }}"
                                            onclick="event.preventDefault();
                             document.getElementById('order').value = 'id';
                             document.getElementById('sort-form').submit();"></a>
                                    </th>
                                    <th scope="col" width="30px"></th>
                                    <th scope="col"><a class="nav-link normal" href="{{ url()->full() }}"
                                            onclick="event.preventDefault();
                             document.getElementById('order').value = 'name';
                             document.getElementById('sort-form').submit();">الاسم</a>
                                    </th>
                                    <th scope="col"><a class="nav-link normal" href="{{ url()->full() }}"
                                            onclick="event.preventDefault();
                             document.getElementById('order').value = 'phone';
                             document.getElementById('sort-form').submit();">رقم
                                            الهاتف</a>
                                    </th>
                                    @if ($type == 'restaurant' || $type == 'captin')
                                        <th>مبالغ مستحقة</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($users as $User)
                                    <tr>
                                        <th>{{ $i }}</th>
                                        <th>
                                            <div class="dropdown">
                                                <a id="navbarDropdown" class="dropdown-toggle" href="#" role="button"
                                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                    v-pre>
                                                    <i class="fa fa-gear text-black-50"></i>
                                                </a>

                                                <div class="dropdown-menu dropdown-menu-start"
                                                    aria-labelledby="navbarDropdown">
                                                    <a class="dropdown-item  text-end"
                                                        href="{{ route('admin.User.Model', ['id' => $User->id, 'view' => 'Show']) }}"><i
                                                            class="fa fa-eye text-black-50 mx-2"></i>عرض</a>

                                                    <a class="dropdown-item  text-end"
                                                        href="{{ route('admin.User.Model', ['id' => $User->id, 'view' => 'Edit']) }}"><i
                                                            class="fa fa-pen text-black-50 mx-2"></i>تعديل</a>
                                                    <a class="dropdown-item  text-end"
                                                        href="{{ route('admin.User.address', ['user_id' => $User->id]) }}"><i
                                                            class="fa fa-pen text-black-50 mx-2"></i>العناوين</a>
                                                    @if ($User->type == 'restaurant')
                                                        <a class="dropdown-item  text-end"
                                                            href="{{ route('admin.Dish.Data', ['user_id' => $User->id]) }}"><i
                                                                class="fa fa-pen text-black-50 mx-2"></i>الاطباق</a>
                                                        <a class="dropdown-item  text-end"
                                                            href="{{ route('admin.order.restaurant', ['restaurant_id' => $User->id]) }}"><i
                                                                class="fa fa-pen text-black-50 mx-2"></i>الطلبات السابقة</a>
                                                        <a class="dropdown-item  text-end"
                                                            href="{{ route('admin.user.markAsPaid', ['id' => $User->id]) }}"><i
                                                                class="fa fa-pen text-black-50 mx-2"></i>تعين مدفوع</a>
                                                    @endif
                                                    @if ($User->type == 'captin')
                                                        <a class="dropdown-item  text-end"
                                                            href="{{ route('admin.user.markAsPaid', ['id' => $User->id]) }}"><i
                                                                class="fa fa-pen text-black-50 mx-2"></i>تعين مدفوع</a>
                                                        <a class="dropdown-item  text-end"
                                                            href="{{ route('admin.delivary.Captin', ['captin_id' => $User->id]) }}"><i
                                                                class="fa fa-pen text-black-50 mx-2"></i>التوصيلات
                                                            السابقة</a>
                                                    @endif
                                                    @if ($User->type == 'user')
                                                        <a class="dropdown-item  text-end"
                                                            href="{{ route('admin.delivary.User', ['user_id' => $User->id]) }}"><i
                                                                class="fa fa-pen text-black-50 mx-2"></i>طلبات التوصيل</a>
                                                        <a class="dropdown-item  text-end"
                                                            href="{{ route('admin.order.User', ['user_id' => $User->id]) }}"><i
                                                                class="fa fa-pen text-black-50 mx-2"></i>طلبات الطعام</a>
                                                    @endif
                                                    <a class="dropdown-item text-end"
                                                        onclick="return confirm('هل انت متأكد من رغبتك بالحذف؟')"
                                                        href="{{ route('admin.User.ParmentlyDelete', ['id' => $User->id]) }}"><i
                                                            class="fa fa-pen text-black-50 mx-2"></i>حذف</a>
                                                </div>
                                            </div>
                                        </th>
                                        <th scope="row" style="color: #666666">
                                            {{ $User->name }}
                                        </th>
                                        <td>{{ $User->phone }}</td>
                                        <td>{{ $User->money() }}</td>
                                    </tr>
                                    <?php $i++; ?>
                                @endforeach
                                {!! $users->links() !!}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
