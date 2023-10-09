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
                    @if (request()->has('captin_id'))
                        <input type="hidden" name="captin_id" value="{{ request()->string('captin_id') }}">
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
                             document.getElementById('order').value = 'package';
                             document.getElementById('sort-form').submit();">الحمولة</a>
                                    </th>
                                    <th scope="col"><a class="nav-link normal" href="{{ url()->current() }}"
                                            onclick="event.preventDefault();
                             document.getElementById('order').value = 'delivary_status';
                             document.getElementById('sort-form').submit();">الحالة</a>
                                    </th>

                                    <th scope="col" width="30px">وقت التسليم</th>
                                    <th scope="col"><a class="nav-link normal" href="{{ url()->current() }}"
                                            onclick="event.preventDefault();
                             document.getElementById('order').value = 'price';
                             document.getElementById('sort-form').submit();">السعر</a>
                                    </th>
                                    <th scope="col"><a class="nav-link normal" href="{{ url()->current() }}"
                                            onclick="event.preventDefault();
                             document.getElementById('order').value = 'fee';
                             document.getElementById('sort-form').submit();">الرسوم</a>
                                    </th>
                                    <th scope="col"><a class="nav-link normal" href="{{ url()->current() }}"
                                            onclick="event.preventDefault();
                             document.getElementById('order').value = 'created_at';
                             document.getElementById('sort-form').submit();">وقت
                                            الطلب</a>
                                    <th scope="col"><a class="nav-link normal" href="{{ url()->current() }}"
                                            onclick="event.preventDefault();
                             document.getElementById('order').value = 'captin_id';
                             document.getElementById('sort-form').submit();">الكابتن</a>
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
                                @foreach ($delivaries as $delivary)
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
                                                        href="{{ route('admin.delivary.show', ['id' => $delivary->id]) }}"><i
                                                            class="fa fa-eye text-black-50 mx-2"></i>عرض</a>
                                                    <a class="dropdown-item text-end"
                                                        href="{{ route('admin.delivary.edit', ['id' => $delivary->id]) }}"><i
                                                            class="fa fa-pen text-black-50 mx-2"></i>تعديل</a>
                                                    @if (!$delivary->paid)
                                                        <a class="dropdown-item text-end"
                                                            onclick="return confirm('هل انت متأكد من رغبتك بالتعيين')"
                                                            href="{{ route('admin.delivary.markAsPaid', ['id' => $delivary->id, 'view' => 'Edit']) }}"><i
                                                                class="fa fa-pen text-black-50 mx-2"></i>تعيين كمدفوع</a>
                                                    @endif
                                                    <a class="dropdown-item text-end"
                                                        onclick="return confirm('هل انت متأكد من رغبتك بالحذف؟')"
                                                        href="{{ route('admin.delivary.Delete', ['id' => $delivary->id, 'view' => 'Edit']) }}"><i
                                                            class="fa fa-trash text-black-50 mx-2"></i>حذف</a>
                                                    <a class="dropdown-item text-end"
                                                        href="{{ route('admin.delivary.cancel', ['id' => $delivary->id]) }}"><i
                                                            class="fa fa-trash text-black-50 mx-2"></i>
                                                        @if ($delivary->cancel)
                                                            الغاء
                                                        @endif
                                                        الغاء
                                                    </a>
                                                    @if (!is_null($delivary->order))
                                                        <a class="dropdown-item text-end"
                                                            href="{{ route('admin.order.show', ['id' => $delivary->order->id, 'view' => 'Show']) }}"><i
                                                                class="fa fa-pen text-black-50 mx-2"></i>عرض طلب المطعم</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </th>
                                        <th scope="row" style="color: #666666">
                                            {{ $delivary->package }}
                                        </th>
                                        <th scope="row" style="color: #666666">
                                            {{ $delivary->delivary_status }}@if (!$delivary->paid)
                                                - غير مدفوع
                                            @endif
                                        </th>
                                        <td> {{ $delivary->timetoFinsh() }}</td>
                                        <td> {{ $delivary->price }}</td>
                                        <td> {{ $delivary->fee }}</td>
                                        <td> {{ $delivary->created_at }}</td>
                                        @if (!is_null($delivary->captin))
                                            <td>{{ $delivary->captin->name }}</td>
                                        @else
                                            <td>

                                                <form method="POST" action="{{ route('admin.delivary.asginCaptin') }}"
                                                    class="w-75" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="delivary" value="{{ $delivary->id }}">
                                                    <select id="type"
                                                        class="form-control headding @error('captin') is-invalid @enderror"
                                                        name="captin">
                                                        <option value="-1" class="headding">اختر الكابتن</option>
                                                        @foreach ($captins as $captin)
                                                            <option value="{{ $captin->id }}"
                                                                @if (!is_null($delivary->captin)) {{ $delivary->captin->id == $captin->id ? 'checked' : '' }} @endif
                                                                class="headding">{{ $captin->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <button class="btn btn-primary"
                                                        style="width: fit-content">اختر</button>
                                                </form>
                                            </td>
                                        @endif
                                        @if (!is_null($delivary->user))
                                            <td>{{ $delivary->user->name }}</td>
                                        @else
                                            <td>المستخدم غير متوفر</td>
                                        @endif
                                    </tr>
                                    <?php $i++; ?>
                                @endforeach
                                {!! $delivaries->links() !!}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('js/select.js') }}"></script>
    <script>
        var captin = document.querySelector('#captin');

        dselect(captin, {
            search: true
        });
    </script>
@endsection
