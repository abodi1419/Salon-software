@extends('layouts.app')

@section('content')
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('New purchase invoice') }}</div>

                    <div class="card-body">
                        <div class="mb-3">
                            <div class="form-group row">
                                <label for="products" class="col-md-4 col-form-label text-md-right">{{ __('Products') }}</label>
                                <div class="col-md-6">
                                    <select name="products" id="products" class="form-control">
                                        @foreach($products as $product)
                                            <option value="{{$product['id']}}">{{$product['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="price" class="col-md-4 col-form-label text-md-right">{{ __('Price') }}</label>
                                <div class="col-md-6">
                                    <input id="price" type="number" class="form-control @error('price') is-invalid @enderror">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="quantity" class="col-md-4 col-form-label text-md-right">{{ __('Quantity') }}</label>

                                <div class="col-md-6">
                                    <input id="quantity" type="number" class="form-control @error('quantity') is-invalid @enderror" min="1" max="50" value="1">
                                </div>
                            </div>
                            <div class="form-group row mb-0 text-center">
                                <div class="col-md-6 offset-md-4">
                                    <button onclick="addItem(this)" class="btn btn-primary">
                                        {{ __('Add') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                        <form method="POST" id="invoice_form" action="{{ route('purchase_invoices.store') }}">
                            @csrf



                            <div class="table-responsive">
                                <table class="table table-striped border">
                                    <thead class="bg-dark text-white">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">{{__('Product name')}}</th>
                                            <th scope="col">{{__('Product price')}}</th>
                                            <th scope="col">{{__('Quantity')}}</th>
                                            <th scope="col">{{__('Actions')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody id="invoice">
                                        <tr id="tr1">
                                            <th></th>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr id="tr2">
                                            <th></th>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr id="tr3">
                                            <th></th>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>


                                    </tbody>
                                </table>
                                <a role='button' class='btn btn-white btn-circle btn-sm text-danger' onclick='deleteAllProducts()'>
                                    {{__("Delete All")}}
                                    <i class='fas fa-trash'></i>
                                </a>
                            </div>



                            <div class="form-group row mb-0 text-center">
                                <div class="col-6">
                                    <div class="form-group row">
                                        <label for="discount" class="col-md-4 col-form-label text-md-right">{{ __('Discount') }}</label>

                                        <div class="col-md-6">
                                            <input id="discount" min="0" max="100" onchange="setDiscount(this)" type="number" class="form-control @error('discount') is-invalid @enderror" name="discount" value="{{0 }}" autofocus>

                                            @error('discount')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="vendor" class="col-md-4 col-form-label text-md-right">{{ __('Vendor') }}</label>

                                        <div class="col-md-6">
                                            <input id="vendor" type="text" class="form-control @error('vendor') is-invalid @enderror" name="vendor" value="{{ old('vendor') }}" autocomplete="vendor" autofocus>

                                            @error('vendor')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="notes" class="col-md-4 col-form-label text-md-right">{{ __('Notes') }}</label>

                                        <div class="col-md-6">
                                            <textarea id="notes" class="form-control @error('notes') is-invalid @enderror"  name="notes" value="{{ old('notes') }}"></textarea>

                                            @error('notes')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div  class="form-group">
                                        <label class="font-weight-bold" for="total">{{ __('Total') }}</label>

                                        <input class="text-center border-0 bg-transparent form-control text-danger font-weight-bold" onchange="setTwoNumberDecimal" type="number" name="total" min="1" step="0.25" value="0.00"  id="total"disabled>
                                    </div>
                                    <div class="align-center">
                                        <button type="submit" class="btn btn-primary mr-2 mt-5" onclick="save()">
                                            {{ __('Save') }}
                                        </button>
                                        <button type="submit" class="btn btn-primary mt-5" onclick="create()">
                                            {{ __('Create') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

    <script>
        var array = [];

        class Product{
            constructor(name,id,quantity,price) {
                this.name = name;
                this.id = id;
                this.quantity = parseInt(quantity);
                this.price = parseFloat(price);
            }
        }


        let total=0;
        let counter=1;
        let prodCounter=0;
        let isProduct=false;
        var totalInput = document.getElementById('total');
        var invoice = document.getElementById('invoice');

        function addItem(b) {
            var quantity = document.getElementById('quantity').value;
            var price = document.getElementById('price').value;
            var products = document.getElementById('products');
            let productName = products.options[products.selectedIndex].text;
            let productId = products.value;
            product = new Product(productName, productId, quantity, price);

            for (var i = 0; i < array.length; i++) {

                if (product.name == array[i].name && product.price == array[i].price) {
                    array[i].quantity += product.quantity;
                    generateCells();
                    return;
                }
            }
            array.push(product);
            generateCells();
        }

        function deleteIndex(event) {
            array.splice(event, 1);
            generateCells();
        }
        function generateCells() {
            invoice.innerHTML="";
            total=0;
            for (let i =0;i<array.length;i++){
                let product = array[i];
                let tr = "<th scope='row'>"+(i+1)+"</th>" +
                    "<td>"+array[i].name+"</td>"+
                    "<td>"+array[i].price+"</td>"+
                    "<td>"+array[i].quantity+"</td>"+
                    "<td>"+
                    "<div class='text-center'>" +

                    "<a role='button' id='"+i+"' class='btn btn-white btn-circle btn-sm text-danger' onclick='deleteIndex(this.id)'>" +
                    "<i class='fas fa-trash'></i>" +
                    "</a>" +
                    "</div>" +
                    "<input type='text' id='product"+(++prodCounter)+"' name='product"+prodCounter+"' value='"+"p_-"+array[i].id+"-"+array[i].price+"-"+array[i].quantity+"' hidden>"+
                    "</td>";

                invoice.innerHTML+="<tr>"+tr+"</tr>"
            }
            calcTotal()
        }

        function deleteAllProducts() {
            invoice.innerHTML=generateBasicRows();
            total=0;
            counter=1;
            setTotal();
        }
        function setDiscount(event) {
            calcTotal()


        }
        function calcTotal() {
            total=0
            for(let i=0;i<array.length;i++){
                total+=(array[i].price)*(array[i].quantity);
            }
            total-=total*(parseFloat(document.getElementById('discount').value)/100)
            setTotal()
        }

        function save() {
            totalInput.disabled=false;
            invoice.innerHTML+="<input type='number' name='state' id='state' value=0 hidden>";
        }
        function create() {
            totalInput.disabled=false;
            invoice.innerHTML+="<input type='number' name='state' id='state' value='1' hidden >";
        }



        function setTotal() {
            totalInput.setAttribute('value',total);
            setTwoNumberDecimal(totalInput)
        }
        function generateBasicRows() {
            return "<tr id='tr1'> <th></th><td></td><td></td><td></td><td></td></tr>"+
                "<tr id='tr2'><th></th><td></td><td></td><td></td><td></td></tr>" +
                "<tr id='tr3'><th></th><td></td><td></td><td></td><td></td></tr>"
        }
        function setTwoNumberDecimal(event) {
            console.log('sldkla;k')
            this.value = parseFloat(this.value).toFixed(2);
        }

    </script>
@endsection
