@extends('layout.template')

@section('title', 'Grupos')

@section('content')
<div class="page-content-wrapper py-3">
    <div class="container">
        <!-- Cart Wrapper -->
        <div class="cart-wrapper-area">
            <div class="cart-table card mb-3">
                <div class="table-responsive card-body">
                    <table class="table mb-0 text-center">
                        <thead>
                        <tr>
                            <th scope="col">Image</th>
                            <th scope="col">Description</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Remove</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th scope="row">
                                <img src="img/bg-img/p1.jpg" alt="">
                            </th>
                            <td>
                                <h6 class="mb-1">Wooden Tool</h6>
                                <span>$9.89 × 1</span>
                            </td>
                            <td>
                                <div class="quantity">
                                    <input class="qty-text" type="text" value="1">
                                </div>
                            </td>
                            <td>
                                <a class="remove-product" href="#">
                                    <i class="bi bi-x-lg"></i>
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                                <img src="img/bg-img/p3.jpg" alt="">
                            </th>
                            <td>
                                <h6 class="mb-1">Black T-shirt</h6><span>$10.99 × 2</span>
                            </td>
                            <td>
                                <div class="quantity">
                                    <input class="qty-text" type="text" value="2">
                                </div>
                            </td>
                            <td>
                                <a class="remove-product" href="#">
                                    <i class="bi bi-x-lg"></i>
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                                <img src="img/bg-img/p5.jpg" alt="">
                            </th>
                            <td>
                                <h6 class="mb-1">Crispy Biscuit</h6>
                                <span>$0.78 × 9</span>
                            </td>
                            <td>
                                <div class="quantity">
                                    <input class="qty-text" type="text" value="9">
                                </div>
                            </td>
                            <td>
                                <a class="remove-product" href="#">
                                    <i class="bi bi-x-lg"></i>
                                </a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div class="card-body border-top">
                    <div class="apply-coupon">
                        <h6 class="mb-0">Have a coupon?</h6>
                        <p class="mb-2">Enter your coupon code here &amp; get awesome discounts!</p>
                        <!-- Coupon Form -->
                        <div class="coupon-form">
                            <form action="#">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input class="form-control input-group-text text-start" type="text" placeholder="OFFER30">
                                        <button class="btn btn-primary" type="submit">Apply</button>
                                    </div>
                                </div>
                                <!-- Checkout -->
                                <button class="btn btn-danger w-100 mt-3" href="checkout.html">$38.89 &amp; Pay</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
