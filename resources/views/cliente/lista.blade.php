@extends('layout.template')

@section('title', 'Clientes')

@section('content')
    <section>
        <div class="custom-container">
            <form class="theme-form search-head" target="_blank">
                <div class="form-group">
                    <div class="form-input">
                        <input type="text" class="form-control search" id="inputusername" placeholder="Pesquisar..." />
                        <i class="search-icon" data-feather="search"></i>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <section class="section-b-space">
        <div class="custom-container">
            <div class="title">
                <h2>Clientes</h2>
            </div>

            <div class="row gy-3">
                <div class="col-12">
                    <div class="transaction-box">
                        <a href="#transaction-detail" data-bs-toggle="modal" class="d-flex gap-3">
                            <div class="transaction-image">
                                <img class="img-fluid transaction-icon" src="assets/images/person/p1.png" alt="p1" />
                            </div>
                            <div class="transaction-details">
                                <div class="transaction-name">
                                    <h5>João dos Santos</h5>
                                    <h3 class="error-color">R$ 199,99</h3>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <h5 class="light-text">(45) 99999-9999</h5>
                                    <h5 class="light-text">10/08/2024</h5>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-12">
                    <div class="transaction-box">
                        <a href="#transaction-detail" data-bs-toggle="modal" class="d-flex gap-3">
                            <div class="transaction-image">
                                <img class="img-fluid transaction-icon" src="assets/images/person/p2.png" alt="p2" />
                            </div>
                            <div class="transaction-details">
                                <div class="transaction-name">
                                    <h5>Maria da Silva</h5>
                                    <h3 class="success-color">R$ 60,30</h3>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <h5 class="light-text">(45) 99999-9999</h5>
                                    <h5 class="light-text">10/09/2024</h5>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-12">
                    <div class="transaction-box">
                        <a href="#transaction-detail" data-bs-toggle="modal" class="d-flex gap-3">
                            <div class="transaction-image">
                                <img class="img-fluid transaction-icon" src="assets/images/person/p4.png" alt="p2" />
                            </div>
                            <div class="transaction-details">
                                <div class="transaction-name">
                                    <h5>José de Souza</h5>
                                    <h3 class="error-color">R$ 55,20</h3>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <h5 class="light-text">(45) 99999-9999</h5>
                                    <h5 class="light-text">10/09/2024</h5>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- period modal start -->
    <div class="modal add-money-modal fade" id="period" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">Select Period</h2>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="inputfromdate" class="form-label">From date</label>
                        <input type="date" class="form-control" id="inputfromdate" />
                    </div>

                    <div class="form-group">
                        <label for="inputtodate" class="form-label">To date</label>
                        <input type="date" class="form-control" id="inputtodate" />
                    </div>

                    <a href="crypto-view-transaction.html" class="btn theme-btn successfully w-100">View transaction</a>
                </div>
                <button type="button" class="btn close-btn" data-bs-dismiss="modal">
                    <i class="icon" data-feather="x"></i>
                </button>
            </div>
        </div>
    </div>
    <!--period modal end -->

    <!-- transaction detail modal start -->
    <div class="modal successful-modal transfer-details fade" id="transaction-detail" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">Transaction Detail</h2>
                </div>
                <div class="modal-body">
                    <ul class="details-list">
                        <li>
                            <h3 class="fw-normal dark-text">Payment status</h3>
                            <h3 class="fw-normal light-text">Success</h3>
                        </li>
                        <li>
                            <h3 class="fw-normal dark-text">Date</h3>
                            <h3 class="fw-normal light-text">18 May, 2023</h3>
                        </li>
                        <li>
                            <h3 class="fw-normal dark-text">From</h3>
                            <h3 class="fw-normal light-text">**** **** **** 2563</h3>
                        </li>
                        <li>
                            <h3 class="fw-normal dark-text">To</h3>
                            <h3 class="fw-normal light-text">Amazon prime</h3>
                        </li>
                        <li>
                            <h3 class="fw-normal dark-text">Transaction category</h3>
                            <h3 class="fw-normal light-text">Bill Pay</h3>
                        </li>
                        <li class="amount">
                            <h3 class="fw-normal dark-text">Amount</h3>
                            <h3 class="fw-semibold error-color">$199.99</h3>
                        </li>
                    </ul>
                </div>
                <button type="button" class="btn close-btn" data-bs-dismiss="modal">
                    <i class="icon" data-feather="x"></i>
                </button>
            </div>
        </div>
    </div>
    <!-- successful transfer modal end -->
@endsection
