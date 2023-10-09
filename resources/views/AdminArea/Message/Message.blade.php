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
                    <div class="table-responsive bg-white" data-mdb-perfect-scrollbar="true"
                        style="position: relative; height: 100% ">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">email</th>
                                    <th scope="col">phone</th>
                                    <th scope="col">subject</th>
                                    <th scope="col">Message</th>
                                    <th scope="col">Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($Messages as $Message)
                                    <tr>
                                        <th scope="row" style="color: #666666">
                                            {{ $Message->name }}
                                        </th>
                                        <td> {{ $Message->email }}</td>
                                        <td> {{ $Message->phone }}</td>
                                        <td> {{ $Message->subject }}</td>
                                        <td> {{ $Message->message }}</td>
                                        <td><a href="{{ route('message.delete', $Message->id) }}"
                                                onclick="return confirm('هل انت متأكد من رغبتك بالحذف؟')"
                                                class="btn btn-danger">Delete
                                                <svg xmlns="http://www.w3.org/2000/svg" class="bi" width="18"
                                                    height="18" viewBox="0 0 512 512">
                                                    <!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                    <path
                                                        d="M367.2 412.5L99.5 144.8C77.1 176.1 64 214.5 64 256c0 106 86 192 192 192c41.5 0 79.9-13.1 111.2-35.5zm45.3-45.3C434.9 335.9 448 297.5 448 256c0-106-86-192-192-192c-41.5 0-79.9 13.1-111.2 35.5L412.5 367.2zM512 256c0 141.4-114.6 256-256 256S0 397.4 0 256S114.6 0 256 0S512 114.6 512 256z" />
                                                </svg>
                                            </a></td>
                                    </tr>
                                @endforeach
                                {!! $Messages->links() !!}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
