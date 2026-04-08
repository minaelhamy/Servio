@extends('admin.layout.pos_header')
@section('content')
    @php
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
    @endphp
    <main id="main-content">
        <nav class="navbar navbar-expand-lg bg-white pos-header underline fixed-top position-sticky">
            <div class="container-fluid gap-2">
                <div class="col-lg-4 col-md-4 d-none d-md-block d-flex flex-column">
                    <p class="fs-4 fw-semibold m-0 text-dark color-changer line-1">WellCome To, POS</p>
                    <p class="fs-7 fw-normal m-0 text-muted line-1">Lorem ipsum dolor, sit amet consectetur
                        adipisicing
                        elit.</p>
                </div>
                <div class="col d-flex justify-content-start justify-content-md-center">
                    <a class="navbar-brand m-0 d-flex justify-content-start justify-content-md-center" href="#">
                        <img src="http://192.168.29.166/dhruvildesai/BookingDo_Go_New/storage/app/public/admin-assets/images/about/logo/logo-65eee6e43ba13.png"
                            class="object logo-size" alt="">
                    </a>
                </div>
                <div class="col-lg-4 col-6 col-sm-8 col-md-4 d-sm-block d-none">
                    <div class="input-group gap-0 rounded">
                        <div class="input-group">
                            <span
                                class="input-group-text bg-white {{ session()->get('direction') == 2 ? 'rounded-start-0 rounded-end' : 'rounded-end-0 rounded-start' }}">
                                <i class="fa-light fa-magnifying-glass fs-7"></i>
                            </span>
                            <input type="hidden" class="form-control fs-10 p-2" value="{{ url('admin/pos') }}"
                                id="search-url">
                            <input type="text" class="form-control fs-10 p-2"
                                placeholder="{{ trans('labels.search_item') }}" value="" id="search-keyword"
                                name="search-keyword">
                            <button
                                class="input-group-text btn fs-7 fw-500 btn-primary {{ session()->get('direction') == 2 ? 'rounded-end-0 rounded-start' : 'rounded-start-0 rounded-end' }}">
                                {{ trans('labels.search') }}
                            </button>
                        </div>
                    </div>
                </div>
                <div class="d-flex">
                    <a href="{{ URL::to('admin/dashboard') }}" class="btn btn-primary"><i class="fa-light fa-house"></i></a>
                </div>
            </div>
        </nav>
        <button type="button" data-bs-toggle="offcanvas" data-bs-target="#openOffCanvas" aria-controls="openOffCanvas"
            class="position-fixed cart-btn border border-1 z-3 text-light rounded-circle {{ session()->get('direction') == 2 ? 'cart-btn-right' : 'cart-btn-left' }}"
            aria-controls="staticBackdrop" type="button">
            <div class="cart-count bg-dark rounded-circle d-flex align-items-center justify-content-center">
                0</div>
            <i class="fa-regular fa-cart-plus fs-4"></i>
        </button>

        <div class="container-fluid">
            <div class="{{ session()->get('direction') == 2 ? 'main-product-right' : 'main-product' }} pt-2">
                <div class="row row-cols-xxl-6 row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-sm-3 row-cols-2 g-3 p-2">
                    <div class="col">
                        <div class="card h-100 w-100 border rounded-4 overflow-hidden" data-bs-toggle="modal"
                            data-bs-target="#product_card">
                            <img src="https://avatars.mds.yandex.net/get-ydo/2784159/2a0000017f1d2cc734d3fec5b0f2d5e4e37f/diploma"
                                alt="product image" class="card-img-top imgs object position-relative">
                            <div class="offer-box position-absolute">
                                <p class="m-0">81.3% OFF</p>
                            </div>
                            </a>
                            <div class="card-body px-2 py-1">
                                <h5 class="product-name mt-2">
                                    <a href="#"
                                        class="card-text fs-7 fw-semibold text-dark color-changer w-100 mb-0 line-2">
                                        Kirby T-Shirt
                                    </a>
                                </h5>
                            </div>
                            <div class="card-footer bg-transparent border-0 px-2 pb-2 pt-0">
                                <div class="d-flex align-items-center my-1 gap-1">
                                    <span class="d-flex justify-content-center font-8px text-danger">
                                        <i class="fa-solid fa-circle"></i>
                                    </span>
                                    <span class="text-danger fs-8">
                                        Out Of Stock
                                    </span>
                                </div>
                                <div class="col-12 my-1">
                                    <small
                                        class="fs-15 fw-600 text-dark color-changer mb-0 mt-1 d-flex flex-wrap lh-1 align-items-center gap-1">
                                        $100.00
                                        <del class="fs-7 text-muted fw-medium">$534.00</del>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
<!-- Modal -->
<div class="modal fade" id="product_card" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <div class="modal-title col-12 fs-5" id="exampleModalLabel">
                    <div class="col-12 d-flex align-items-start gap-2 justify-content-between">
                        <div class="d-flex flex-column gap-1">
                            <div class="d-flex justify-content-center offer-box">
                                <p class="m-0">81.3% OFF</p>
                            </div>
                            <h5 class="product-name line-2 mb-0 d-flex justify-content-between">
                                <a href="#" class="card-text fw-semibold text-dark color-changer mb-0 line-2">
                                    Ayam kentang Ayam kentang Ayam kentang Ayam
                                    kentang
                                    Ayam kentang Ayam kentang Ayam kentang Ayam
                                    kentang
                                    Ayam kentang Ayam kentang Ayam kentang Ayam
                                    kentang
                                </a>
                            </h5>
                            <div class="col-12 d-flex align-items-center mt-1 justify-content-between">
                                <p
                                    class="fs-15 fw-600 text-dark mb-0 d-flex flex-wrap lh-1 align-items-center gap-1">
                                    <span class="color-changer">$100.00</span>
                                    <del class="fs-7 text-muted fw-medium">$534.00</del>
                                </p>
                                <div class="d-flex align-items-center my-1 gap-1">
                                    <span class="d-flex justify-content-center font-8px text-danger">
                                        <i class="fa-solid fa-circle"></i>
                                    </span>
                                    <span class="text-danger fs-8">
                                        Out Of Stock
                                    </span>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="bg-transparent border-0 color-changer" data-bs-dismiss="modal"
                            aria-label="Close">
                            <i class="fa-regular fa-xmark"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="border-bottom border-top py-2">
                    <p class="m-0 mb-1 fs-7 text-dark fw-medium color-changer">Size</p>
                    <div class="col-12">
                        <div class="col-12">
                            <div class="form-check d-flex align-items-center justify-content-between m-0 p-0 gap-2">
                                <input class="form-check-input m-0 p-0" type="radio" name="flexRadioDefault"
                                    id="flexRadioDefault7">
                                <label
                                    class="m-0 p-0 w-100 form-check-label d-flex justify-content-between align-items-center"
                                    for="flexRadioDefault7">
                                    <small class="modal-price color-changer">Single</small>
                                    <small class="modal-price color-changer">50.00$</small>
                                </label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-check d-flex align-items-center justify-content-between m-0 p-0 gap-2">
                                <input class="form-check-input m-0 p-0" type="radio" name="flexRadioDefault"
                                    id="flexRadioDefault8">
                                <label
                                    class="m-0 p-0 w-100 form-check-label d-flex justify-content-between align-items-center"
                                    for="flexRadioDefault8">
                                    <small class="modal-price color-changer"> Combo</small>
                                    <small class="modal-price color-changer">70.00$</small>
                                </label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-check d-flex align-items-center justify-content-between m-0 p-0 gap-2">
                                <input class="form-check-input m-0 p-0" type="radio" name="flexRadioDefault"
                                    id="flexRadioDefault9">
                                <label
                                    class="m-0 p-0 w-100 form-check-label d-flex justify-content-between align-items-center"
                                    for="flexRadioDefault9">
                                    <small class="modal-price color-changer">Trio</small>
                                    <small class="modal-price color-changer">100.00$</small>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="border-bottom py-2">
                    <p class="m-0 mb-1 fs-7 text-dark fw-medium color-changer">Add-ons</p>
                    <div class="col-12">
                        <div class="col-12">
                            <div class="form-check d-flex align-items-center justify-content-between m-0 p-0 gap-2">
                                <input class="form-check-input m-0 p-0" type="checkbox" value=""
                                    id="flexCheckDefault5">
                                <label
                                    class="m-0 p-0 w-100 form-check-label d-flex justify-content-between align-items-center"
                                    for="flexCheckDefault5">
                                    <small class="modal-price color-changer">Red Chutney</small>
                                    <small class="modal-price color-changer">50.00$</small>
                                </label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-check d-flex align-items-center justify-content-between m-0 p-0 gap-2">
                                <input class="form-check-input m-0 p-0" type="checkbox" value=""
                                    id="flexCheckDefault6">
                                <label
                                    class="m-0 p-0 w-100 form-check-label d-flex justify-content-between align-items-center"
                                    for="flexCheckDefault6">
                                    <small class="modal-price color-changer">Bread</small>
                                    <small class="modal-price color-changer">70.00$</small>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <form class="mt-2">
                    <div class="m-0">
                        <label for="message-text" class="col-form-label modal-price color-changer">Spacial
                            Instructions</label>
                        <textarea class="form-control modal-price color-changer" id="message-text" placeholder="Add note(with extra Instructions) "></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0 p-3 pt-0">
                <div class="col-12 m-0">
                    <div class="d-flex gap-3">
                        <div class=" d-flex align-items-center">
                            <p class="m-0 me-2 text-dark color-changer">Quantity:</p>
                            <div class="qty-container d-flex align-items-center">
                                <button
                                    class="qty-btn-minus btn-light d-flex align-items-center justify-content-center"
                                    type="button"><i class="fa fa-minus"></i></button>
                                <input type="text" name="qty" value="0"
                                    class="input-qty product-text-size color-changer">
                                <button class="qty-btn-plus btn-light d-flex align-items-center justify-content-center"
                                    type="button"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>
                        {{-- <div class="col-auto"> --}}
                        <button type="button" class="button-modal fs-7 w-100 fw-500 border-0 text-light"
                            data-bs-dismiss="modal">
                            Add To Cart
                        </button>
                        {{-- </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="offcanvas {{ session()->get('direction') == 2 ? 'offcanvas-start' : 'offcanvas-end' }}" id="openOffCanvas"
    tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <button type="button" class="closing-button-1 closing-button-1-left d-none d-md-block"
        data-bs-dismiss="offcanvas" aria-label="Close">
        <i class="fa-regular fa-xmark fs-4"></i>
    </button>
    <div class="offcanvas-header py-3 gap-3">
        <button type="button" class="closing-button-2 border model-close-icon bg-transparent d-block d-md-none"
            data-bs-dismiss="offcanvas" aria-label="Close">
            <i class="fa-regular fa-xmark color-changer"></i>
        </button>
        <select id="itemSelect" class="form-select fs-8" aria-label="Default select example">
            <option selected>Search Customer</option>
            <option value="1">Walking Customer</option>
            <option value="2">Will Smith</option>
            <option value="3">Guest User</option>
        </select>
    </div>
    <div class="offcanvas-body p-0">
        <table class="table mb-0 table-hover" id="myTable">
            <thead>
                <tr class="table-secondary">
                    <th scope="col"></th>
                    <th scope="col" class="product-text-size fw-normal ps-0">Items</th>
                    <th scope="col" class="product-text-size fw-normal">Qty</th>
                    <th scope="col" class="product-text-size fw-normal">Price</th>
                </tr>
            </thead>
            <tbody>
                <tr class="align-middle">
                    <td class="ps-sm-4 py-3 pe-0">
                        <button class="bg-transparent text-danger p-0 border-0 delete-btn"><i
                                class="fa-solid fa-trash"></i></button>
                    </td>
                    <td class="ps-1 ps-sm-0 py-3">
                        <h6 class="line-1 m-0 product-text-size color-changer">Steak sapi bakar</h6>
                        <p class="m-0 line-1 product-text-size color-changer">custom text</p>
                    </td>
                    <td class="py-3">
                        <div class="qty-container d-flex align-items-center">
                            <button class="qty-btn-minus btn-light d-flex align-items-center justify-content-center"
                                type="button"><i class="fa fa-minus"></i></button>
                            <input type="text" name="qty" value="0"
                                class="input-qty product-text-size color-changer" />
                            <button class="qty-btn-plus btn-light d-flex align-items-center justify-content-center"
                                type="button"><i class="fa fa-plus"></i></button>
                        </div>
                    </td>
                    <td class="py-3">
                        <p class="fw-normal text-dark m-0 line-1 product-text-size color-changer">$25.12</p>
                    </td>
                </tr>
                <tr class="align-middle">
                    <td class="ps-sm-4 py-3 pe-0">
                        <button class="bg-transparent text-danger p-0 border-0 delete-btn"><i
                                class="fa-solid fa-trash"></i></button>
                    </td>
                    <td class="ps-1 ps-sm-0 py-3">
                        <h6 class="line-1 m-0 product-text-size color-changer">Steak sapi bakar</h6>
                        <p class="m-0 line-1 product-text-size color-changer">custom text</p>
                    </td>
                    <td class="py-3">
                        <div class="qty-container d-flex align-items-center">
                            <button class="qty-btn-minus btn-light d-flex align-items-center justify-content-center"
                                type="button"><i class="fa fa-minus"></i></button>
                            <input type="text" name="qty" value="0"
                                class="input-qty product-text-size color-changer" />
                            <button class="qty-btn-plus btn-light d-flex align-items-center justify-content-center"
                                type="button"><i class="fa fa-plus"></i></button>
                        </div>
                    </td>
                    <td class="py-3">
                        <p class="fw-normal text-dark m-0 line-1 product-text-size color-changer">$25.12</p>
                    </td>
                </tr>
                <tr class="align-middle">
                    <td class="ps-sm-4 py-3 pe-0">
                        <button class="bg-transparent text-danger p-0 border-0 delete-btn"><i
                                class="fa-solid fa-trash"></i></button>
                    </td>
                    <td class="ps-1 ps-sm-0 py-3">
                        <h6 class="line-1 m-0 product-text-size color-changer">Steak sapi bakar</h6>
                        <p class="m-0 line-1 product-text-size color-changer">custom text</p>
                    </td>
                    <td class="py-3">
                        <div class="qty-container d-flex align-items-center">
                            <button class="qty-btn-minus btn-light d-flex align-items-center justify-content-center"
                                type="button"><i class="fa fa-minus"></i></button>
                            <input type="text" name="qty" value="0"
                                class="input-qty product-text-size color-changer" />
                            <button class="qty-btn-plus btn-light d-flex align-items-center justify-content-center"
                                type="button"><i class="fa fa-plus"></i></button>
                        </div>
                    </td>
                    <td class="py-3">
                        <p class="fw-normal text-dark m-0 line-1 product-text-size color-changer">$25.12</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="offcanvas-footer p-3">
        <form class="footer-form">
            <div class="col-12 d-flex gap-1 fs-8">
                <div class="input-group gap-0 fs-8">
                    <input type="text"
                        class="form-control fs-7 {{ session()->get('direction') == 2 ? 'rounded-end' : 'rounded-start' }}"
                        placeholder="Add Discount" aria-label="Add Discount" aria-describedby="button-addon2">
                    <button
                        class="btn btn-primary fw-500 border-0 text-light fs-7 {{ session()->get('direction') == 2 ? 'rounded-start' : 'rounded-end' }} "
                        type="button" id="button-addon2">Apply</button>
                </div>
            </div>
        </form>
        <div class="col-12 py-2">
            <div class="d-flex justify-content-between my-1 py-1">
                <span class="fw-600 fs-7 text-dark color-changer">Sub Total</span>
                <span class="fw-600 fs-7 text-dark color-changer">$ 62.13</span>
            </div>
            <div class="text-muted">
                <div class="d-flex justify-content-between my-1">
                    <span class="text-sm color-changer">SGST (10%)</span>
                    <span class="text-sm color-changer">$ 1.87</span>
                </div>
                <div class="d-flex justify-content-between my-1">
                    <span class="text-sm color-changer">CGST (10%)</span>
                    <span class="text-sm color-changer">$ 1.87</span>
                </div>
                <div class="d-flex justify-content-between my-1">
                    <span class="text-sm color-changer">Discount (30%)</span>
                    <span class="text-sm color-changer">$20.90</span>
                </div>
            </div>
            <div class="d-flex justify-content-between fs-7 underline-2 py-1">
                <span class="fw-semibold fs-15 text-dark color-changer">Total</span>
                <span class="fw-semibold fs-15 text-dark color-changer">$ 64.00</span>
            </div>
        </div>
        <div class="col-12">
            <div class="row gx-3 align-items-center justify-content-between mt-1">
                <div class="col-6">
                    <button id="deleteAllBtn"
                        class="total-pay Empty-cart fs-7 rounded fw-500 bg-danger text-light border-0">Empty
                        Cart</button>
                </div>
                <div class="col-6">
                    <button id="order" type="submit"
                        class="orderButton total-pay btn btn-primary fs-7 rounded fw-500 text-light border-0"
                        data-bs-dismiss="offcanvas" aria-label="Close">Order
                        Now</button>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="modal fade" id="orderButton" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header py-2">
                <div class="modal-title d-flex justify-content-between col-12 fs-5" id="exampleModalLabel">
                    <div class="col-lg-11 text-center">
                        <div class="fw-semibold my-3 color-changer">
                            Order Confirmation
                        </div>
                    </div>
                    <div class="col-lg-1 d-flex justify-content-end">
                        <button type="button" class="bg-transparent border-0 color-changer" data-bs-dismiss="modal">
                            <i class="fa-regular fa-xmark fs-4"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="col-12">
                    <div class="col-12 py-2 border-bottom">
                        <p class="m-0 mb-1 text-dark fw-medium color-changer">Order Information</p>
                    </div>
                    <div class="box-product-2">
                        <table class="table mb-0">
                            <thead>
                                <tr class="text-secondary">
                                    <th scope="col" class="fs-9 product-text-size fw-medium text-black-50 color-changer">Items
                                    </th>
                                    <th scope="col"
                                        class="fs-9 product-text-size fw-medium text-end text-black-50 color-changer">
                                        Qty</th>
                                    <th scope="col"
                                        class="fs-9 product-text-size fw-medium text-end text-black-50 color-changer">
                                        Price</th>
                                    <th scope="col"
                                        class="fs-9 product-text-size fw-medium text-end text-black-50 color-changer">
                                        Tax</th>
                                    <th scope="col"
                                        class="fs-9 product-text-size fw-medium text-end text-black-50 color-changer">
                                        Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="align-middle">
                                    <td class="py-3">
                                        <h6 class="line-1 m-0 fs-9 product-text-size">Steak sapi bakar</h6>
                                        <p class="m-0 line-1 product-text-size">custom text</p>
                                    </td>
                                    <td class="py-3 text-end">
                                        <div class="product-text-size d-flex align-items-center justify-content-end">
                                            <p class="m-0 text-dark color-changer">1</p>
                                        </div>
                                    </td>
                                    <td class="py-3 text-end">
                                        <p class="fw-normal text-dark color-changer line-1 m-0 fs-9 product-text-size">$25.12
                                        </p>
                                    </td>
                                    <td class="py-3 text-end">
                                        <p class="fw-normal text-dark color-changer line-1 m-0 fs-9 product-text-size">$0.33
                                        </p>
                                    </td>
                                    <td class="py-3 text-end">
                                        <p class="fw-normal text-dark color-changer line-1 m-0 fs-9 product-text-size">$25.12
                                        </p>
                                    </td>
                                </tr>
                                <tr class="align-middle">
                                    <td class="py-3">
                                        <h6 class="line-1 m-0 fs-9 product-text-size">Steak sapi bakar</h6>
                                        <p class="m-0 line-1 product-text-size">custom text</p>
                                    </td>
                                    <td class="py-3 text-end">
                                        <div class="product-text-size d-flex align-items-center justify-content-end">
                                            <p class="m-0 text-dark color-changer">1</p>
                                        </div>
                                    </td>
                                    <td class="py-3 text-end">
                                        <p class="fw-normal text-dark color-changer line-1 m-0 fs-9 product-text-size">$25.12
                                        </p>
                                    </td>
                                    <td class="py-3 text-end">
                                        <p class="fw-normal text-dark color-changer line-1 m-0 fs-9 product-text-size">$0.33
                                        </p>
                                    </td>
                                    <td class="py-3 text-end">
                                        <p class="fw-normal text-dark color-changer line-1 m-0 fs-9 product-text-size">$25.12
                                        </p>
                                    </td>
                                </tr>
                                <tr class="align-middle">
                                    <td class="py-3">
                                        <h6 class="line-1 m-0 fs-9 product-text-size">Steak sapi bakar</h6>
                                        <p class="m-0 line-1 product-text-size">custom text</p>
                                    </td>
                                    <td class="py-3 text-end">
                                        <div class="product-text-size d-flex align-items-center justify-content-end">
                                            <p class="m-0 text-dark color-changer">1</p>
                                        </div>
                                    </td>
                                    <td class="py-3 text-end">
                                        <p class="fw-normal text-dark color-changer line-1 m-0 fs-9 product-text-size">$25.12
                                        </p>
                                    </td>
                                    <td class="py-3 text-end">
                                        <p class="fw-normal text-dark color-changer line-1 m-0 fs-9 product-text-size">$0.33
                                        </p>
                                    </td>
                                    <td class="py-3 text-end">
                                        <p class="fw-normal text-dark color-changer line-1 m-0 fs-9 product-text-size">$25.12
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-12 my-3 d-flex flex-column flex-md-row justify-content-between">
                    <div class="col-12 col-md-6 py-2 px-2 bg-light-subtle rounded notes-box">
                        <div class="col-12">
                            <form>
                                <label for="message-text" class="col-form-label color-changer fs-7 fw-500">Order
                                    Note</label>
                                <textarea class="form-control modal-price text-area" placeholder="Add note(with extra Instructions) "
                                    id="floatingTextarea2" style="height: 100px"></textarea>
                            </form>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 mt-2 mt-md-0 d-flex flex-column justify-content-between">
                        <div class="col-12 py-2 px-2">
                            <div class="d-flex justify-content-between my-1 py-1">
                                <span class="fw-600 fs-7 text-dark color-changer">Sub Total</span>
                                <span class="fw-600 fs-7 text-dark color-changer">$ 62.13</span>
                            </div>
                            <div class="text-muted">
                                <div class="d-flex justify-content-between my-1">
                                    <span class="text-sm color-changer">SGST (10%)</span>
                                    <span class="text-sm color-changer">$ 1.87</span>
                                </div>
                                <div class="d-flex justify-content-between my-1">
                                    <span class="text-sm color-changer">CGST (10%)</span>
                                    <span class="text-sm color-changer">$ 1.87</span>
                                </div>
                                <div class="d-flex justify-content-between my-1">
                                    <span class="text-sm color-changer">Discount (30%)</span>
                                    <span class="text-sm color-changer">$20.90</span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between border-top py-1">
                                <span class="fw-semibold fs-15 text-dark color-changer">Total</span>
                                <span class="fw-semibold fs-15 text-dark color-changer">$ 64.00</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 border-top py-3 border-bottom">
                    <p class="m-0 pb-4 text-dark fw-medium color-changer">Customer Information</p>
                    <form class="row g-3">
                        <div class="col-md-4 m-0">
                            <label for="validationCustom01" class="form-label fs-10">Full Name</label>
                            <input type="text" class="form-control modal-price fs-7 py-2" id="validationCustom01"
                                placeholder="Full Name" required>

                        </div>
                        <div class="col-md-4 m-0">
                            <label for="validationCustom02" class="form-label fs-10">Email</label>
                            <input type="text" class="form-control modal-price fs-7 py-2" id="validationCustom02"
                                placeholder="Email" required>
                        </div>
                        <div class="col-md-4 m-0">
                            <label for="validationCustomUsername" class="form-label fs-10">Mobile
                                Number</label>
                            <input type="number" class="form-control modal-price fs-7 py-2" id="validationCustomUsername"
                                aria-describedby="inputGroupPrepend" placeholder="Mobile Number" required>
                        </div>
                    </form>
                </div>
                <div class="col-12 pt-3">
                    <p class="m-0 mb-1 text-dark fw-medium color-changer">PayMent Information</p>
                    <div class="col-12 d-flex gap-3">
                        <div class="form-check d-flex align-items-center gap-2 p-0 m-0 form-check-inline">
                            <input class="form-check-input p-0 m-0" type="radio" name="inlineRadioOptions"
                                id="inlineRadio1" value="option1">
                            <label class="form-check-label p-0 m-0 modal-price color-changer" for="inlineRadio1">Cash</label>
                        </div>
                        <div class="form-check d-flex align-items-center gap-2 p-0 m-0 form-check-inline">
                            <input class="form-check-input p-0 m-0" type="radio" name="inlineRadioOptions"
                                id="inlineRadio2" value="option2">
                            <label class="form-check-label p-0 m-0 modal-price color-changer" for="inlineRadio2">Online</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <div class="col-12 m-0">
                    <div class="row gx-3 align-items-center justify-content-between mt-1">
                        <div class="col-6">
                            <button type="button"
                                class="btn btn-danger border-0 fs-7 fw-500 total-pay text-light mt-2 mt-lg-0"
                                data-bs-dismiss="modal">Close</button>
                        </div>
                        <div class=" col-6">
                            <button type="submit" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal"
                                class="btn btn-primary border-0 fs-7 fw-500 total-pay text-light mt-2 mt-lg-0">Confirm</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModalToggle2" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2"
    tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div
                class="modal-body d-flex justify-content-center align-items-center position-relative flex-column line-2">
                <img src="https://i.pinimg.com/736x/1c/04/26/1c042685bf912df0c3f878678a651316.jpg" alt=""
                    class="w-50 object">
                <h5 class="mt-3 m-0 fw-medium line-2 text-center color-changer">Thank you For ordering!</h5>
                <p class="text-center m-0 fs-8 mt-3 line-2 lh-lg color-changer">Lorem ipsum, dolor sit amet consectetur
                    adipisicing
                    elit. Voluptatem facilis obcaecati totam amet consectetur adipisicing elit.</p>
            </div>
            <div class="modal-footer pb-3 border-0 justify-content-center">
                <div class="m-0 col-12">
                    <div class="row g-3 align-items-center justify-content-between">
                        <div class="col-sm-6">
                            <button type="button" id="button1"
                                class="rounded border w-100 p-3 border-dark fs-7 fw-500 text-dark"
                                data-bs-dismiss="modal">
                                <a href="./resept.html">
                                    View Order
                                </a>
                            </button>
                        </div>
                        <div class="col-sm-6">
                            <button type="submit" data-bs-dismiss="modal" id="button2"
                                class="btn-primary btn w-100 p-3 rounded fs-7 fw-500">Continue
                                Shopping</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
