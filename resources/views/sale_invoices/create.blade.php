@extends('layouts.app')

@section('content')

    <?php $s_to_json=json_encode($services) ?>
    <?php $p_to_json=json_encode($products) ?>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('New sale invoice') }}</div>

                    <div class="card-body">
                        <label for="">{!!__('Invoice number').": <span class='text-success font-weight-bold'>".$invoicesCounter."</span>" !!}</label>
                        <div class="mb-3">
                            <div class="form-group row">
                                <label for="product/service" class="col-md-4 col-form-label text-md-right">{{ __('Service/Product') }}</label>
                                <div class="col-md-6">
                                    <select name="product/service" onchange="selectType(this)" id="product/service" class="form-control">
                                            <option value="0" selected>{{__('Service')}}</option>
                                            <option value="1">{{__('Product')}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row" id="products-div" hidden>
                                <label for="products" class="col-md-4 col-form-label text-md-right">{{ __('Products') }}</label>
                                <div class="col-md-6">
                                    <select name="products" onchange="setProductPrice(this)" id="products" class="form-control">
                                        <option value="0" selected>{{__("Select")}}</option>
                                        @foreach($products as $product)
                                            <option value="{{$product['id']}}">{{$product['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                            <div class="form-group row" id="services_div">
                                <label for="services" class="col-md-4 col-form-label text-md-right">{{ __('Services') }}</label>
                                <div class="col-md-6">
                                    <select name="services" onchange="setServicePrice(this)" id="services" class="form-control">
                                        <option value="0">{{__("Select")}}</option>
                                        @foreach($services as $service)
                                            <option value="{{$service['id']}}">{{$service['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <label for="employees" class="col-md-4 col-form-label text-md-right">{{ __('Specialist') }}</label>
                                <div class="col-md-6">
                                    <select name="employees" onchange="" id="employees" class="form-control">
                                        @foreach($employees as $employee)
                                            @foreach($employee as $emp)
                                                <option value="{{$emp['id']}}">{{$emp['name']}}</option>
                                            @endforeach
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
                        <form method="POST" id="invoice_form" action="{{ route('sale_invoices.store') }}">
                            @csrf



                            <div class="table-responsive">
                                <table class="table table-striped border">
                                    <thead class="bg-dark text-white">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">{{__('Service/Product name')}}</th>
                                            <th scope="col">{{__('Service/Product price')}}</th>
                                            <th scope="col">{{__('Specialist')}}</th>
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
                                            <td></td>
                                        </tr>
                                        <tr id="tr2">
                                            <th></th>
                                            <td></td>
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
                                        <label for="customer" class="col-md-4 col-form-label text-md-right">{{ __('Customer') }}</label>

                                        <div class="col-md-6">
                                            <input id="customer" type="text" class="form-control @error('customer') is-invalid @enderror" name="customer" value="{{ old('customer') }}" autofocus>

                                            @error('customer')
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
            constructor(name,id,quantity,price,specialistName=null,specialistId=null,type) {
                this.name = name;
                this.id = id;
                this.quantity = parseInt(quantity);
                this.price = parseFloat(price);
                this.type = type;
                this.specialistName = specialistName;
                this.specialistId = specialistId;
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
            var products =null
            var product;
            let specialist = "<td></td>";
            let value = document.getElementById('product/service').value;
            if(value==0){
                specialist = document.getElementById("employees")
                let specialistName = specialist.options[specialist.selectedIndex].text;
                let specialistId = specialist.value;
                products = document.getElementById('services');
                let productName = products.options[products.selectedIndex].text;
                let productId = products.value;
                product = new Product(productName,productId,quantity,price,specialistName,specialistId,value);
            }else {
                products = document.getElementById('products');
                let productName = products.options[products.selectedIndex].text;
                let productId = products.value;
                product = new Product(productName,productId,quantity,price,value);
            }
            for( var i = 0; i < array.length; i++){
                if(product.value==0){
                    if(product.name==array[i].name && product.price==array[i].price && product.specialistId==array[i].specialistId){
                        array[i].quantity+=product.quantity;
                        generateCells();
                        return;
                    }

                }else{
                    if(product.name==array[i].name && product.price==array[i].price) {
                        array[i].quantity+=product.quantity;
                        generateCells();
                        return;
                    }
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
                let type="";
                let specialistName="";
                let specialistId=0;
                if(array[i].type == 0){
                    specialistName= array[i].specialistName;
                    specialistId= array[i].specialistId;
                    type = "s_-"+specialistId+"-";
                }else{
                    type='p_-';
                }
                let product = array[i];
                let tr = "<th scope='row'>"+(i+1)+"</th>" +
                    "<td>"+array[i].name+"</td>"+
                    "<td>"+array[i].price+"</td>"+
                    "<td>"+specialistName+"</td>"+
                    "<td>"+array[i].quantity+"</td>"+
                    "<td>"+
                    "<div class='text-center'>" +

                    "<a role='button' id='"+i+"' class='btn btn-white btn-circle btn-sm text-danger' onclick='deleteIndex(this.id)'>" +
                    "<i class='fas fa-trash'></i>" +
                    "</a>" +
                    "</div>" +
                    "<input type='text' id='product"+(++prodCounter)+"' name='product"+prodCounter+"' value='"+type+array[i].id+"-"+array[i].price+"-"+array[i].quantity+"' hidden>"+
                    "</td>";
                total+=(array[i].price)*(array[i].quantity);
                invoice.innerHTML+="<tr>"+tr+"</tr>"
            }
            setTotal();
        }
        function deleteAllProducts() {
            invoice.innerHTML=generateBasicRows();
            total=0;
            counter=1;
            setTotal();
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
            return "<tr id='tr1'> <th></th><td></td><td><td></td></td><td></td><td></td></tr>"+
                "<tr id='tr2'><th></th><td></td><td></td><td></td><td></td><td></td></tr>" +
                "<tr id='tr3'><th></th><td></td><td></td><td></td><td></td><td></td></tr>"
        }
        function setTwoNumberDecimal(event) {
            this.value = parseFloat(this.value).toFixed(2);
        }

        function selectType(event) {
            var product = document.getElementById('products-div');
            var service = document.getElementById('services_div');
            document.getElementById('price').setAttribute('value','');
            document.getElementById('products').value=0;
            document.getElementById('services').value=0;

            if(event.value==0){
                product.hidden=true;
                service.hidden=false;
            }else {
                product.hidden=false;
                service.hidden=true;
            }
        }
        function setServicePrice(event){

            var price = document.getElementById('price');
            var services = <?php echo $s_to_json ?>;


            for (let i=0; i<services.length; i++) {
                if(services[i]['id']==event.value){
                    price.setAttribute('value',services[i]['price']);
                    return;
                }
            }
            price.setAttribute('value','');


        }
        function setProductPrice(event){

            var price = document.getElementById('price');
            var products= <?php echo $s_to_json ?>;

            for (let i=0; i<products.length; i++) {
                console.log(products[i]['id']);
                if(products[i]['id']==event.value){
                    price.setAttribute('value',products[i]['price']);
                    return;
                }
            }
            price.setAttribute('value','');


        }

    </script>
@endsection
