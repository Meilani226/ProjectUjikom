@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="row mb-2">
                    <div class="col">
                        
                    </div>
                </div>
                <div class="user-cart">
                    <div class="card">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nama Produk</th>
                                    <th>Jumlah</th>
                                    <th class="text-right">Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <form action="{{ route('admin.transactions.store') }}" method="post">
                    @csrf
                    <div class="row mt-2">
                        <div class="col">Total:</div>
                        <div class="col text-right">
                            <input type="number" value="" name="total" readonly class="form-control total">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col">Dibayar:</div>
                        <div class="col text-right">
                            <input type="number" value="" name="accept" class="form-control received">
                        </div>
                    </div>
                    <div class="row my-2">
                        <div class="col">Kembalian:</div>
                        <div class="col text-right">
                            <input type="number" value="" name="return" readonly class="form-control return">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <button type="button" class="btn btn-danger btn-block">
                                Batal
                            </button>
                        </div>
                        <div class="col">
                            <button type="submit" class="btn btn-primary btn-block">
                                Bayar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-6 col-lg-8">
                <div class="mb-2">
                    <input type="text" class="form-control search" placeholder="Cari Produk..." />
                </div>
                <div class="order-product product-search"
                    style="display: flex;column-gap: 0.5rem;flex-wrap: wrap;row-gap: .5rem;">
                    @foreach ($products as $product)
                        <button type="button" class="item" style="cursor: pointer; border: none;"
                            value="{{ $product->id }}">
                            @if ($product->image)
                                <img src="{{ $product->image->getUrl() }}" width="45px" height="45px" alt="test" />
                            @endif
                            <h6 style="margin: 0;">{{ $product->name }}</h6>
                            <span>(Rp.{{ $product->price }})</span>
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script-alt')
    <script>
        $(document).ready(function() {

            function getCarts() {
                $.ajax({
                    type: 'get',
                    url: "carts",
                    dataType: "json",
                    success: function(response) {
                        let total = 0;
                        $('tbody').html("");
                        $.each(response.carts, function(key, product) {
                            total += product.price * product.quantity
                            $('tbody').append(`
                            <tr>
                                <td>${product.name}</td>
                                <td class="d-flex">
                                    <select class="form-control qty">
                                    ${[...Array(product.stock).keys()].map((x) => (
                                        `<option ${product.quantity == x + 1 ? 'selected' : null} value=${x + 1}>
                                                                ${x + 1}
                                                            </option>`
                                    ))}
                                    </select>
                                    <input
                                        type="hidden"
                                        class="cartId"
                                        value="${product.id}"
                                        />
                                    <button
                                        type="button"
                                        class="btn btn-danger btn-sm delete"
                                        value="${product.id}"

                                    >
                                    <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                                <td class="text-right">
                                Rp.${ product.quantity * product.price}
                                </td>
                            </tr>
                            `)
                        });

                        const test = $('.total').attr('value', `${total}`);
                    }
                })
            }

            getCarts()

            $(document).on('change', '.received', function() {
                const received = $(this).val();
                const total = $('.total').val();
                const subTotal = received - total;
                const change = $('.return').val(subTotal);
            })

            $(document).on('change', '.qty', function() {
                const qty = $(this).val();
                const cartId = $(this).closest('td').find('.cartId').val();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: 'put',
                    url: `carts/${cartId}`,
                    data: {
                        qty
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 400) {
                            alert(response.message);
                        }
                        getCarts()
                    }
                })
            })

            $(document).on('keyup', '.search', function() {
                const search = $(this).val();


                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: 'post',
                    url: `products/search`,
                    data: {
                        search
                    },
                    dataType: 'json',
                    success: function(response) {
                        $('.product-search').html("");
                        $.each(response, function(key, product) {
                            $('.product-search').append(`
                            <button type="button"
                                class="item"
                                style="cursor: pointer; border: none;"
                                value="${product.id}"
                            >
                                <img src="http://127.0.0.1:8000/storage/${product.image.id}/${product.image.file_name}" width="45px" height="45px" alt="test" />

                                <h6 style="margin: 0;">${product.name}</h6>
                                <span >(${product.price})</span>
                            </button>
                            `)
                        });
                    }
                })
            })

            $(document).on('click', '.delete', function() {
                const cartId = $(this).val();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: 'delete',
                    url: `carts/${cartId}`,
                    success: function(response) {
                        if (response.status === 400) {
                            alert(response.message);
                        }
                        getCarts()
                    }
                })
            })

            $('.scan').click(function(e) {
                e.preventDefault();
                const productCode = $(this).closest('form').find('.productCode').val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: 'post',
                    url: `carts`,
                    data: {
                        productCode
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 400 || response.status === 500) {
                            alert(response.message);
                        }
                        getCarts()
                    }
                })
            });

            $(document).on('click', '.item', function() {
                const productId = $(this).val();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: 'post',
                    url: `carts`,
                    data: {
                        productId
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 400) {
                            alert(response.message);
                        }
                        getCarts()
                    }
                })

            })
        })
    </script>
@endpush

{{-- body{background-image:url(/img/BAPENDA.jpg);background-size:cover;background-repeat:no-repeat;background-color:rgba(22,151,85,.7);background-blend-mode:multiply;background-attachment:fixed}nav{width:100%;background:#fff176;height:5.5rem;display:flex;justify-content:center}nav .container{display:flex;align-items:center}nav .logo{height:80%}nav h2{font-size:25px}nav h2,nav p{padding:0;margin:0;font-family:Roboto;font-weight:400}footer{height:35px;background:#fff176}.content{border-radius:20px;min-height:calc(100vh - 138px - 6rem)}.bordered-green{border:2px solid #169755;font-family:Poppins;font-weight:600}.semut{position:fixed;bottom:2rem;right:2rem;height:10rem;width:9rem}@media (max-width:576px){.semut{height:9rem;width:7rem;bottom:1rem;right:1rem}}.semut img{width:100%;height:100%;-o-object-fit:contain;object-fit:contain}.modal-msg{text-align:center}.modal-msg .img{font-size:75pt;color:#41fa9a}

/*# sourceMappingURL=client.css.map*/ --}}
