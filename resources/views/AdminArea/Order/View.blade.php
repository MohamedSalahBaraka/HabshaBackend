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
                <label for="floatingInput " class="h1">{{ $title }}</label>
                <form id="sort-form" action="{{ url()->current() }}" method="GET" class="d-none">
                    @if (request()->has('user_id'))
                        <input type="hidden" name="user_id" value="{{ request()->string('user_id') }}">
                    @endif
                    @if (request()->has('restaurant_id'))
                        <input type="hidden" name="restaurant_id" value="{{ request()->string('restaurant_id') }}">
                    @endif
                    <input type="hidden" name="order" id="order">
                    <input type="hidden" name="dir" id="dir" value="{{ $dir }}">

                </form>
                <form action="{{ url()->current() }}" method="GET" class="container row">

                    <div class="form-group col-6">
                        <input type="text" class="form-control" name="keyword">
                    </div>
                    <button class="btn btn-primary" style="width: fit-content">ابحث</button>
                </form>
                <div class="col-12">
                    <div class="table-responsive-md bg-white" data-mdb-perfect-scrollbar="true"
                        style="position: relative; height: 100% ">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col" width="30px"><a class="nav-link normal"
                                            href="{{ url()->current() }}"
                                            onclick="event.preventDefault();
                             document.getElementById('order').value = 'id';
                             document.getElementById('sort-form').submit();">#</a>
                                    </th>
                                    <th scope="col" width="30px"></th>
                                    <th scope="col"><a class="nav-link normal" href="{{ url()->current() }}"
                                            onclick="event.preventDefault();
                             document.getElementById('order').value = 'status';
                             document.getElementById('sort-form').submit();">الحالة</a>
                                    </th>
                                    <th scope="col"><a class="nav-link normal" href="{{ url()->current() }}"
                                            onclick="event.preventDefault();
                             document.getElementById('order').value = 'total';
                             document.getElementById('sort-form').submit();">المبلغ
                                            الكلي</a>
                                    </th>
                                    <th scope="col"><a class="nav-link normal" href="{{ url()->current() }}"
                                            onclick="event.preventDefault();
                             document.getElementById('order').value = 'created_at';
                             document.getElementById('sort-form').submit();">وقت
                                            الطلب</a>
                                    </th>
                                    <th scope="col"><a class="nav-link normal" href="{{ url()->current() }}"
                                            onclick="event.preventDefault();
                             document.getElementById('order').value = 'restaurant_id';
                             document.getElementById('sort-form').submit();">المطعم</a>
                                    </th>
                                    <th scope="col"><a class="nav-link normal" href="{{ url()->current() }}"
                                            onclick="event.preventDefault();
                             document.getElementById('order').value = 'user_id';
                             document.getElementById('sort-form').submit();">المستخدم</a>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($orders as $order)
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
                                                    <a class="dropdown-item text-end"
                                                        href="{{ route('admin.order.show', ['id' => $order->id, 'view' => 'Show']) }}"><i
                                                            class="fa fa-eye text-black-50 mx-2"></i>عرض الطلب</a>
                                                    <a class="dropdown-item text-end"
                                                        onclick="return confirm('هل انت متأكد من رغبتك بالحذف؟')"
                                                        href="{{ route('admin.order.Delete', ['id' => $order->id, 'view' => 'Edit']) }}"><i
                                                            class="fa fa-trash text-black-50 mx-2"></i>حذف</a>
                                                    <a class="dropdown-item text-end"
                                                        href="{{ route('admin.order.cancel', ['id' => $order->id]) }}"><i
                                                            class="fa fa-trash text-black-50 mx-2"></i>
                                                        @if ($order->cancel)
                                                            الغاء
                                                        @endif
                                                        الغاء
                                                    </a>
                                                    @if (!is_null($order->delivary))
                                                        <a class="dropdown-item text-end"
                                                            href="{{ route('admin.delivary.show', ['id' => $order->delivary->id, 'view' => 'Show']) }}"><i
                                                                class="fa fa-pen text-black-50 mx-2"></i>عرض طلب التوصيل</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </th>
                                        <th scope="row" style="color: #666666">
                                            {{ $order->status }}@if (!$order->paid)
                                                - غير مدفوع
                                            @endif
                                        </th>
                                        <th scope="row" style="color: #666666">
                                            {{ $order->total }}
                                        </th>
                                        <th scope="row" style="color: #666666">
                                            {{ $order->created_at }}
                                        </th>
                                        @if (!is_null($order->restaurant))
                                            <td>{{ $order->restaurant->name }}</td>
                                        @else
                                            <td>المطعم غير متوفر</td>
                                        @endif
                                        @if (!is_null($order->user))
                                            <td>{{ $order->user->name }}</td>
                                        @else
                                            <td>المستخدم غير متوفر</td>
                                        @endif

                                    </tr>
                                    <?php $i++; ?>
                                @endforeach
                                {!! $orders->links() !!}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
