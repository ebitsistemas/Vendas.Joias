@extends('layout.template', ['menu' => 'dashboard', 'submenu' => ''])

@section('title', 'Dashboard')

@section('content')
    <section>
        <div class="accordion coin-chart-accordion" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                        Vendas | AGOSTO
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <div class="transaction-box">
                            <a href="transaction-history.html" class="d-flex gap-3">
                                <div class="transaction-details">
                                    <div class="transaction-name">
                                        <h2 class="fw-bold dark-text">R$ 10.678,65</h2>
                                        <h3 class="success-color">11%</h3>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <h5 class="light-text fw-semibold">Vendas | AGOSTO</h5>
                                        <h5 class="light-text">-12.77 (8%)</h5>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="chart" class="overview-wrapper">
                            <div class="coin-chart-wrapper" id="coin"></div>
                            <div class="back-bar-container">
                                <div id="order-bar"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- total saving section starts -->
    <section>
        <div class="custom-container">
            <div class="statistics-banner">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="total-amount">
                        <h3>Total Mês</h3>
                        <h2>R$ 10.678,65</h2>
                    </div>
                </div>
                <div class="saving-slider">
                    <input id="range-slider__range" type="range" value="40" />

                    <!-- <span id="range-slider__value">40</span> -->
                </div>

                <div class="left-amount">
                    <h5>A receber</h5>
                    <h5 class="text-white fw-semibold">R$4.380,50</h5>
                </div>
            </div>
        </div>
    </section>
    <!-- total saving section end -->

    <!-- saving plans section starts -->
    <section class="section-b-space">
        <div class="custom-container">
            <div class="row gy-3">
                <div class="col-6">
                    <div class="saving-plan-box">
                        <a href="#saving" data-bs-toggle="modal">
                            <div class="saving-plan-icon">
                                <i class="fad fa-users text-theme"></i>
                            </div>
                            <h3>Clientes</h3>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <h5 class="theme-color">258</h5>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-6">
                    <div class="saving-plan-box">
                        <a href="#saving" data-bs-toggle="modal">
                            <div class="saving-plan-icon">
                                <i class="fad fa-box text-theme"></i>
                            </div>
                            <h3>Produtos</h3>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <h5 class="theme-color">1.369</h5>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-6">
                    <div class="saving-plan-box">
                        <a href="#saving" data-bs-toggle="modal">
                            <div class="saving-plan-icon">
                                <i class="fad fa-cart-shopping text-theme"></i>
                            </div>
                            <h3>Vendas</h3>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <h5 class="theme-color">2.561</h5>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- saving plans section end -->

    <!-- add savings modal starts -->
    <div class="modal add-money-modal fade" id="add-goals" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">Add Money</h2>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="inputcategory" class="form-label mb-2">Category</label>
                        <div class="d-flex gap-2">
                            <select id="inputcategory" class="form-select">
                                <option selected>Select category</option>
                                <option>New Bike</option>
                                <option>Traveling</option>
                                <option>Shopping</option>
                                <option>Entertainment</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Title</label>
                        <div class="form-input mb-3">
                            <input type="text" class="form-control" placeholder="Add title" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Saving amount</label>
                        <div class="form-input mb-3">
                            <input type="text" class="form-control" placeholder="Add amount" />
                        </div>
                    </div>
                    <a href="#done-add" data-bs-toggle="modal" class="btn theme-btn successfully w-100">Add saving plan</a>
                </div>
                <button type="button" class="btn close-btn" data-bs-dismiss="modal">
                    <i class="icon" data-feather="x"></i>
                </button>
            </div>
        </div>
    </div>
    <!-- add savings modal end -->

    <!--successful added modal start -->
    <div class="modal error-modal fade" id="done-add" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">Successfully Added</h2>
                </div>
                <div class="modal-body">
                    <div class="saving-img">
                        <img class="img-fluid" src="assets/images/svg/15.svg" alt="p15" />
                    </div>
                    <h3>We've added your additional savings strategy to the list.</h3>
                </div>
                <button type="button" class="btn close-btn" data-bs-dismiss="modal">
                    <i class="icon" data-feather="x"></i>
                </button>
            </div>
        </div>
    </div>
    <!-- successful added modal end -->

    <!-- successful bill modal start -->
    <div class="modal successful-modal fade" id="saving" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">Saving For New Car</h2>
                </div>
                <div class="modal-body">
                    <div class="saving-img">
                        <img class="img-fluid" src="assets/images/svg/10.svg" alt="p10" />
                    </div>

                    <ul class="details-list border-0">
                        <li>
                            <h3 class="fw-normal dark-text">Saving amount</h3>
                            <h3 class="fw-normal theme-color">$2000.00</h3>
                        </li>
                        <li>
                            <h3 class="fw-normal dark-text">Due amount</h3>
                            <h3 class="fw-normal light-text">$3500.00</h3>
                        </li>
                    </ul>
                    <a href="saving-plans.html" class="btn theme-btn successfully w-100">Okay !</a>
                </div>
                <button type="button" class="btn close-btn" data-bs-dismiss="modal">
                    <i class="icon" data-feather="x"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- apexcharts js -->
    <script src="assets/js/apexcharts.js"></script>
    <script src="assets/js/custom-coin-chart.js"></script>
@endsection
