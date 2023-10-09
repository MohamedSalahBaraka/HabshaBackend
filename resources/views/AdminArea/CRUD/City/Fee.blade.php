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
                <label for="floatingInput " class="h1">{{ $maincity->name }}</label>

                <div class="col-12">
                    <div class="table-responsive-md bg-white" data-mdb-perfect-scrollbar="true"
                        style="position: relative; height: 100% ">
                        <table class="table">
                            <thead>
                                <th scope="col" width="30px">#</th>
                                <th scope="col" width="30px"></th>
                                <th scope="col" width="30px">اسم المدينة</th>
                                <th scope="col" width="30px">سعر</th>
                                <th scope="col" width="30px">الرسوم</th>
                            </thead>
                            <tbody>
                                <form method="POST" action="{{ route('admin.city.feesStore') }}" class="w-75"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="from" value="{{ $maincity->id }}">
                                    <?php $i = 1; ?>
                                    @foreach ($cities as $city)
                                        <tr>
                                            <th>{{ $i }}</th>
                                            <th>
                                                <div class="dropdown">
                                                    <a id="navbarDropdown" class="dropdown-toggle" href="#"
                                                        role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false" v-pre>
                                                        <i class="fa fa-gear text-black-50"></i>
                                                    </a>

                                                    <div class="dropdown-menu dropdown-menu-start"
                                                        aria-labelledby="navbarDropdown">
                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.City.Model', ['id' => $city->id, 'view' => 'Show']) }}"><i
                                                                class="fa fa-eye text-black-50 mx-2"></i>عرض</a>
                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.City.Model', ['id' => $city->id, 'view' => 'Edit']) }}"><i
                                                                class="fa fa-pen text-black-50 mx-2"></i>تعديل</a>
                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.city.fees', ['id' => $city->id]) }}"><i
                                                                class="fa fa-pen text-black-50 mx-2"></i>التسعيرة</a>
                                                        <a class="dropdown-item"
                                                            onclick="return confirm('هل انت متأكد من رغبتك بالحذف؟')"
                                                            href="{{ route('admin.City.ParmentlyDelete', ['id' => $city->id]) }}"><i
                                                                class="fa fa-pen text-black-50 mx-2"></i>حذف</a>
                                                    </div>
                                                </div>
                                            </th>
                                            <th scope="row" style="color: #666666">
                                                {{ $city->name }}
                                            </th>
                                            <?php
                                            $fee = $maincity
                                                ->fromFees()
                                                ->where('tocity', $city->id)
                                                ->first();
                                            ?>
                                            <th scope="row" style="color: #666666">
                                                <input type="number"
                                                    @if (!is_null($fee)) value="{{ $fee->price }}" @endif
                                                    name='Fees[{{ $city->id }}][price]'>
                                            </th>
                                            <th scope="row" style="color: #666666">
                                                <input type="number"
                                                    @if (!is_null($fee)) value="{{ $fee->fee }}" @endif
                                                    name='Fees[{{ $city->id }}][fee]'>
                                            </th>

                                        </tr>
                                        <?php $i++; ?>
                                    @endforeach
                                    <div class="mt-4 mb-0">
                                        <div class="d-grid"><button class="btn btn-primary btn-block headding"
                                                type="submit">احفظ</button>
                                        </div>
                                    </div>
                                </form>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
