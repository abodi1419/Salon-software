@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('New job title') }}</div>

                    <div class="card-body">
                        <form method="POST" action="store">
                            @csrf
                            <div class="form-group">

                            </div>

                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            <div class="form-group">
                                <div class="text-left">
                                    <input id="use_system" name="use_system" type="checkbox" onchange="useSystem(this)">
                                    <label for="use_system" class="text-danger">{{ __('Employees under this job title will use the system') }}</label>
                                </div>
                            </div>
                            <div id="use_system_div" hidden>
                                <h3>{{__('Sale invoices')}}</h3>
                                <hr>
                                <div class="text-left">
                                    <input id="all_sale" type="checkbox" onchange="selectAllSalesInvoices(this)">
                                    <label for="all_sale" class="text-danger">{{ __('Select all') }}</label>
                                </div>
                                <div class="form-group">

                                    <div class="text-center">
                                        <input id="create_sale_invoices" type="checkbox" class="@error('create_sale_invoices') is-invalid @enderror" name="create_sale_invoices" value="{{ old('create_sale_invoices') }}">
                                        <label for="create_sale_invoices" class="text-danger">{{ __('Create') }}</label>
                                        @error('create_sale_invoices')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="text-center">
                                        <input id="edit_sale_invoices" type="checkbox" class="@error('edit_sale_invoices') is-invalid @enderror" name="edit_sale_invoices" value="{{ old('edit_sale_invoices') }}">
                                        <label for="edit_sale_invoices" class="text-danger">{{ __('Edit') }}</label>
                                        @error('edit_sale_invoices')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="text-center">
                                        <input id="view_sale_invoices" type="checkbox" class="@error('view_sale_invoices') is-invalid @enderror" name="view_sale_invoices" value="{{ old('view_sale_invoices') }}">
                                        <label for="view_sale_invoices" class="text-danger">{{ __('View') }}</label>
                                        @error('view_sale_invoices')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="text-center">
                                        <input id="delete_sale_invoices" type="checkbox" class="@error('delete_sale_invoices') is-invalid @enderror" name="delete_sale_invoices" value="{{ old('delete_sale_invoices') }}">
                                        <label for="delete_sale_invoices" class="text-danger">{{ __('Delete') }}</label>
                                        @error('delete_sale_invoices')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <h3>{{__('Purchase invoices')}}</h3>
                                <hr>
                                <div class="text-left">
                                    <input id="all_purchase" type="checkbox" onchange="selectAllPurchasesInvoices(this)">
                                    <label for="all_purchase" class="text-danger">{{ __('Select all') }}</label>
                                </div>
                                <div class="form-group">

                                    <div class="text-center">
                                        <input id="create_purchase_invoices" type="checkbox" class="@error('create_purchase_invoices') is-invalid @enderror" name="create_purchase_invoices" value="{{ old('create_purchase_invoices') }}">
                                        <label for="create_purchase_invoices" class="text-danger">{{ __('Create') }}</label>
                                        @error('create_purchase_invoices')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="text-center">
                                        <input id="edit_purchase_invoices" type="checkbox" class="@error('edit_purchase_invoices') is-invalid @enderror" name="edit_purchase_invoices" value="{{ old('edit_purchase_invoices') }}">
                                        <label for="edit_purchase_invoices" class="text-danger">{{ __('Edit') }}</label>
                                        @error('edit_purchase_invoices')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="text-center">
                                        <input id="view_purchase_invoices" type="checkbox" class="@error('view_purchase_invoices') is-invalid @enderror" name="view_purchase_invoices" value="{{ old('view_purchase_invoices') }}">
                                        <label for="view_purchase_invoices" class="text-danger">{{ __('View') }}</label>
                                        @error('view_purchase_invoices')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="text-center">
                                        <input id="delete_purchase_invoices" type="checkbox" class="@error('delete_purchase_invoices') is-invalid @enderror" name="delete_purchase_invoices" value="{{ old('delete_purchase_invoices') }}">
                                        <label for="delete_purchase_invoices" class="text-danger">{{ __('Delete') }}</label>
                                        @error('delete_purchase_invoices')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <h3>{{__('Other')}}</h3>
                                <hr>
                                <div class="form-group">
                                    <div class="text-center">
                                        <input id="show_reports" type="checkbox" class="@error('show_reports') is-invalid @enderror" name="show_reports" value="{{ old('show_reports') }}">
                                        <label for="show_reports" class="text-danger">{{ __('Show reports') }}</label>
                                        @error('show_reports')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Add') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function selectAllSalesInvoices(event){
            var create = document.getElementById('create_sale_invoices');
            var edit = document.getElementById('edit_sale_invoices');
            var view = document.getElementById('view_sale_invoices');
            var remove = document.getElementById('delete_sale_invoices');
            if(create.checked&&edit.checked&&view.checked&&remove.checked){
                create.checked =false;
                edit.checked=false
                view.checked=false
                remove.checked=false
                event.checked=false;
            }else{
                create.checked =true;
                edit.checked=true
                view.checked=true
                remove.checked=true
                event.checked = true;
            }

        }

        function selectAllPurchasesInvoices(event){
            var create = document.getElementById('create_purchase_invoices');
            var edit = document.getElementById('edit_purchase_invoices');
            var view = document.getElementById('view_purchase_invoices');
            var remove = document.getElementById('delete_purchase_invoices');
            if(create.checked&&edit.checked&&view.checked&&remove.checked){
                create.checked =false;
                edit.checked=false
                view.checked=false
                remove.checked=false
                event.checked=false;
            }else{
                create.checked =true;
                edit.checked=true
                view.checked=true
                remove.checked=true
                event.checked = true;
            }

        }
        function useSystem(event){
            if(event.checked){
                document.getElementById('use_system_div').hidden = false
            }else{
                document.getElementById('use_system_div').hidden = true
            }
        }
    </script>
@endsection
