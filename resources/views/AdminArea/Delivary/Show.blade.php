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
                    <form method="POST" action="{{ route('admin.delivary.asginCaptin') }}" class="w-75"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="delivary" value="{{ $delivary->id }}">
                        <select id="type" class="form-control headding @error('captin') is-invalid @enderror"
                            name="captin">
                            <option value="-1" class="headding">اختر الكابتن</option>
                            @foreach ($captins as $captin)
                                <option value="{{ $captin->id }}"
                                    @if (!is_null($delivary->captin)) {{ $delivary->captin->id == $captin->id ? 'checked' : '' }} @endif
                                    class="headding">{{ $captin->name }}</option>
                            @endforeach
                        </select>
                        <button class="btn btn-primary" style="width: fit-content">ابحث</button>
                    </form>
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
                                                    href="{{ route('admin.delivary.edit', ['id' => $delivary->id]) }}"><i
                                                        class="fa fa-pen text-black-50 mx-2"></i>تعديل</a>
                                                @if (!$delivary->paid)
                                                    <a class="dropdown-item text-end"
                                                        href="{{ route('admin.delivary.markAsPaid', ['id' => $delivary->id]) }}"><i
                                                            class="fa fa-pen text-black-50 mx-2"></i>تعيين كمدفوع</a>
                                                @endif
                                                <a class="dropdown-item text-end"
                                                    onclick="return confirm('هل انت متأكد من رغبتك بالحذف؟')"
                                                    href="{{ route('admin.delivary.Delete', ['id' => $delivary->id]) }}"><i
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
                                        </div>الحالة
                                    </th>
                                    <td> {{ $delivary->delivary_status }} @if (!$delivary->paid)
                                            - غير مدفوع
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" style="color: #666666">الحمولة</th>
                                    <td> {{ $delivary->package }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" style="color: #666666">تاريخ التحرير</th>
                                    <td> {{ $delivary->created_at }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" style="color: #666666">السعر</th>
                                    <td> {{ $delivary->price }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" style="color: #666666">الرسوم</th>
                                    <td> {{ $delivary->fee }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" style="color: #666666">وقت البدا</th>
                                    <td> {{ $delivary->start_at }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" style="color: #666666">وقت النهاية</th>
                                    <td> {{ $delivary->finsh_at }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" style="color: #666666">وقت التسليم</th>
                                    <td> {{ $delivary->timetoFinsh() }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" style="color: #666666">الكابتن</th>
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
                                                <button class="btn btn-primary" style="width: fit-content">ابحث</button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                                <tr>
                                    <th scope="row" style="color: #666666">المستخدم</th>
                                    @if (!is_null($delivary->user))
                                        <td>{{ $delivary->user->name }}</td>
                                    @else
                                        <td>المستخدم غير متوفر</td>
                                    @endif
                                </tr>
                                @if (!is_null($delivary->addressGet))
                                    <tr>
                                        <th scope="row" style="color: #666666">عنوان الاستلام</th>
                                    </tr>
                                    <tr>
                                        <th scope="row" style="color: #666666">المدينة</th>
                                        @if (!is_null($delivary->addressGet->city))
                                            <td>{{ $delivary->addressGet->city->name }}</td>
                                        @else
                                            <td>المدينة غير متوفر</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <th scope="row" style="color: #666666">الحي</th>
                                        <td> {{ $delivary->addressGet->neighbourhood }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" style="color: #666666">التفاصيل</th>
                                        <td> {{ $delivary->addressGet->details }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" style="color: #666666">الاسم للمسلم</th>
                                        <td> {{ $delivary->addressGet->name }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" style="color: #666666">رقم هاتف المسلم</th>
                                        <td> {{ $delivary->addressGet->phone }}</td>
                                    </tr>
                                @else
                                    <tr>
                                        <th scope="row" style="color: #666666">عنوان الاستلام غير متوفر</th>
                                    </tr>
                                @endif
                                @if (!is_null($delivary->addressSent))
                                    <tr>
                                        <th scope="row" style="color: #666666">عنوان التصليم</th>
                                    </tr>
                                    <tr>
                                        <th scope="row" style="color: #666666">المدينة</th>
                                        @if (!is_null($delivary->addressSent->city))
                                            <td>{{ $delivary->addressSent->city->name }}</td>
                                        @else
                                            <td>المدينة غير متوفر</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <th scope="row" style="color: #666666">الحي</th>
                                        <td> {{ $delivary->addressSent->neighbourhood }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" style="color: #666666">التفاصيل</th>
                                        <td> {{ $delivary->addressSent->details }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" style="color: #666666">الاسم للمسلم</th>
                                        <td> {{ $delivary->addressSent->name }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" style="color: #666666">رقم هاتف المسلم</th>
                                        <td> {{ $delivary->addressSent->phone }}</td>
                                    </tr>
                                @else
                                    <tr>
                                        <th scope="row" style="color: #666666">عنوان التسليم غير متوفر</th>
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
@section('script')
    <script src="{{ asset('js/select.js') }}"></script>
    <script>
        var captin = document.querySelector('#captin');

        dselect(captin, {
            search: true
        });
    </script>
@endsection
