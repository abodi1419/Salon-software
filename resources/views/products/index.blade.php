@extends('layouts.app')

@section('content')
    <?php
    $jobTitle = \Illuminate\Support\Facades\Auth::user()->employee->jobTitle;
    $delete=$jobTitle->delete_product;
    $edit=$jobTitle->edit_product;
    $view=$jobTitle->view_product;
    ?>
    <h4>{{__('Products')}}</h4>

    <div class="card p-3">

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="bg-dark text-white">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">{{__('Name')}}</th>
                        <th scope="col">{{__('Quantity')}}</th>
                        <th scope="col">{{__('Price')}}</th>
                        <th scope="col">{{__('Notes')}}</th>
                        @if($delete||$edit)
                        <th scope="col">{{__('Actions')}}</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($products as $num=>$product)
                        <tr>
                            <th scope="row">{{$num+1}}</th>
                            <td>{{$product['name']}}</td>
                            <td>{{$product['quantity']}}</td>
                            <td>{{$product['price']}}</td>
                            <td>{{$product['notes']}}</td>
                            @if($delete||$edit)
                            <td>
                                <div class="row">
                                    @if($edit)
                                    <div class="col-3 m-0 p-1">

                                        <form action="{{route('products.edit',$product)}} " method="get">
                                            @csrf
                                            <button class="btn btn-white btn-circle btn-sm" type="submit">
                                                <i class="fas fa-user-edit"></i>
                                            </button>
                                        </form>
                                    </div>
                                    @endif
                                    @if($delete)
                                    <div class="col-3 m-0 p-1">
                                        <form action="{{route('products.destroy',$product)}} " method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-white btn-circle btn-sm text-danger" type="submit">
                                                <i class="fas fa-user-times"></i>
                                            </button>
                                        </form>
                                    </div>
                                    @endif
                                </div>


                            </td>
                            @endif
                        </tr>
                    @empty

                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
