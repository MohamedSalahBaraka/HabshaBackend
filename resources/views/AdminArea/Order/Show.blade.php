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
                                                    href="{{ route('admin.order.show', ['id' => $order->id]) }}"><i
                                                        class="fa fa-pen text-black-50 mx-2"></i>تعديل</a>
                                                <a class="dropdown-item text-end"
                                                    onclick="return confirm('هل انت متأكد من رغبتك بالحذف؟')"
                                                    href="{{ route('admin.order.Delete', ['id' => $order->id]) }}"><i
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
                                                            class="fa fa-pen text-black-50 mx-2"></i>عرض طلب المطعم</a>
                                                @endif
                                            </div>
                                        </div>الحالة
                                    </th>
                                    <td> {{ $order->status }}@if (!$order->paid)
                                            - غير مدفوع
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" style="color: #666666">تاريخ التحرير</th>
                                    <td> {{ $order->created_at }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" style="color: #666666">المبلغ</th>
                                    <th scope="row" style="color: #666666">
                                        {{ $order->total }}
                                    </th>
                                </tr>
                                <tr>
                                    <th scope="row" style="color: #666666">المطعم</th>
                                    @if (!is_null($order->restaurant))
                                        <td>{{ $order->restaurant->name }}</td>
                                    @else
                                        <td>المطعم غير متوفر</td>
                                    @endif
                                </tr>
                                <tr>
                                    <th scope="row" style="color: #666666">المستخدم</th>
                                    @if (!is_null($order->user))
                                        <td>{{ $order->user->name }}</td>
                                    @else
                                        <td>المستخدم غير متوفر</td>
                                    @endif
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <label for="floatingInput " class="h1">الاطباق</label>
                <div class="col-12">
                    <div class="table-responsive-md bg-white" data-mdb-perfect-scrollbar="true"
                        style="position: relative; height: 100% ">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col" width="30px">#</th>
                                    <th scope="col" width="30px">اسم الطبق</th>
                                    <th scope="col" width="30px">السعر</th>
                                    <th scope="col" width="30px">الكمية</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($order->dishOrder as $dish)
                                    <tr>
                                        <th>{{ $i }}</th>
                                        <th scope="row" style="color: #666666">
                                            {{ $dish->status }}
                                        </th>
                                        @if (!is_null($dish->dish))
                                            <td>{{ $dish->dish->name }}</td>
                                        @else
                                            <td>الطبق غير متوفر</td>
                                        @endif
                                        <th scope="row" style="color: #666666">
                                            {{ $dish->price }}
                                        </th>
                                        <th scope="row" style="color: #666666">
                                            {{ $dish->count }}
                                        </th>
                                    </tr>
                                    <?php $i++; ?>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
