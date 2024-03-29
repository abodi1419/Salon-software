<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.6">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ __(config('app.name', 'Laravel'))}} | @yield('title') </title>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>


    <!-- Fonts -->


    <!-- Styles -->
    <style type="text/css">

        .align-center{
            display: flex;
            display: -webkit-flex;
            justify-content: center;
            -webkit-justify-content: center;
            align-items: center;
            -webkit-align-items: center;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />

{{--    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">--}}

    <link rel="stylesheet" href="https://cdn.rtlcss.com/bootstrap/v4.5.3/css/bootstrap.min.css" integrity="sha384-JvExCACAZcHNJEc7156QaHXTnQL3hQBixvj5RV5buE7vgnNEzzskDtx9NQ4p6BJe" crossorigin="anonymous" />


</head>
<body class="" dir="rtl" lang="ar">
<div id="app">
    <?php
    if(\Illuminate\Support\Facades\Auth::user())
        $jobTitle = \Illuminate\Support\Facades\Auth::user()->employee->jobTitle;
    ?>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{asset('storage/Narjis.jpeg')}}" class="rounded-circle" style="width: 70px; height: 70px" alt="">
{{--                {{ __(config('app.name', 'Laravel')) }}--}}

            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav text-white mr-auto">
                    @auth
                        @if($jobTitle['view_employee']||$jobTitle['create_employee']||$jobTitle['edit_employee']||$jobTitle['delete_employee'])
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{__('Employees')}}
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                @if($jobTitle['create_employee'])
                                <a class="dropdown-item" href="{{route('employees.create')}}">{{__('New employee')}}</a>
                                @endif
                                @if($jobTitle['view_employee'])
                                <a class="dropdown-item" href="{{route('employees.index')}}">{{__('Show employees')}}</a>
                                @endif
                                @if($jobTitle['create_employee'])
                                <a class="dropdown-item" href="{{asset('job_title/create')}}">{{ __('New job title') }}</a>
                                @endif
                                @if($jobTitle['view_employee'])
                                    <a class="dropdown-item" href="{{route('employees.index')}}">{{__('Calculate commissions')}}</a>
                                @endif
                            </div>
                        </li>
                        @endif
                        @if($jobTitle['create_product']||$jobTitle['view_product']||$jobTitle['edit_product']||$jobTitle['delete_product']||
                                $jobTitle['create_service']||$jobTitle['view_service']||$jobTitle['edit_service']||$jobTitle['delete_service'])
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{__('Sales')}}
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                @if($jobTitle['create_service'])
                                <a class="dropdown-item" href="{{route('services.create')}}">{{__('New service')}}</a>
                                @endif
                                @if($jobTitle['create_product'])
                                <a class="dropdown-item" href="{{route('products.create')}}">{{__('New product')}}</a>
                                @endif
                                @if($jobTitle['view_service'])
                                <a class="dropdown-item" href="{{asset('services')}}">{{__('Show services') }}</a>
                                @endif
                                @if($jobTitle['view_product'])
                                <a class="dropdown-item" href="{{asset('products')}}">{{__('Show products') }}</a>
                                @endif
                            </div>
                        </li>
                            @endif
                        <li class="nav-item">

                        </li>
                        @if($jobTitle['create_sale_invoices']||$jobTitle['view_sale_invoices']||$jobTitle['edit_sale_invoices']||$jobTitle['delete_sale_invoices']||
                            $jobTitle['create_purchase_invoices']||$jobTitle['view_purchase_invoices']||$jobTitle['edit_purchase_invoices']||$jobTitle['delete_purchase_invoices'])

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{__('Invoices')}}
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                @if($jobTitle['create_sale_invoices'])
                                <a class="dropdown-item" href="{{route('sale_invoices.create')}}">{{__('New sale invoice')}}</a>
                                @endif
                                @if($jobTitle['create_purchase_invoices'])
                                <a class="dropdown-item" href="{{route('purchase_invoices.create')}}">{{__('New purchase invoice')}}</a>
                                @endif
                                @if($jobTitle['view_sale_invoices']||$jobTitle['edit_sale_invoices']||$jobTitle['delete_sale_invoices'])
                                <a class="dropdown-item" href="{{asset('sale_invoices')}}">{{ __('Show sale invoices') }}</a>
                                @endif
                                @if($jobTitle['view_purchase_invoices']||$jobTitle['edit_purchase_invoices']||$jobTitle['delete_purchase_invoices'])
                                <a class="dropdown-item" href="{{asset('purchase_invoices')}}">{{ __('Show purchase invoices') }}</a>
                                @endif
                            </div>
                        </li>
                        @endif
                    @endauth
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if(\App\Models\Employee::all()->first()==null)
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('employees.create') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        <div class="container-fluid">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li >{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @elseif(\Illuminate\Support\Facades\Session::has('success'))
                <div class="alert alert-success">
                    <ul>
                        <li>{!! \Session::get('success') !!}</li>
                    </ul>
                </div>
            @endif
            @yield('content')
        </div>
    </main>
</div>
</body>
</html>
