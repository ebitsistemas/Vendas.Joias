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
            <div class="app-title mb-3">
                <h2>Form</h2>
            </div>
            <form class="auth-form pt-0" target="_blank">
                <div class="form-group">
                    <label for="inputname" class="form-label">Full name</label>
                    <div class="form-input">
                        <input type="text" class="form-control" id="inputname" placeholder="Enter your name">
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputusername" class="form-label">Email id</label>
                    <div class="form-input">
                        <input type="email" class="form-control" id="inputusername" placeholder="Enter Your email">
                    </div>
                </div>

                <div class="form-group">
                    <label for="number" class="form-label">Phone Number</label>
                    <div class="form-input">
                        <input type="number" class="form-control" id="number" placeholder="Enter phone number">
                    </div>
                </div>

                <div class="form-group">
                    <label for="confirmpin" class="form-label">Password</label>
                    <div class="form-input">
                        <input type="number" class="form-control" id="confirmpin" placeholder="Enter password">
                    </div>
                </div>

                <div class="app-title mt-4 mb-3">
                    <h2>Chackbox &amp; Redio Button</h2>
                </div>


                <div class="option d-block mt-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheck1" checked="">
                        <label class="form-check-label" for="flexCheck1">Item 1</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheck2">
                        <label class="form-check-label" for="flexCheck2">Item 2</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheck3">
                        <label class="form-check-label" for="flexCheck3">Item 2</label>
                    </div>
                </div>

                <div class="option d-block mt-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexradio1" checked="">
                        <label class="form-check-label" for="flexradio1">Item 1</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexradio2">
                        <label class="form-check-label" for="flexradio2">Item 2</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexradio3">
                        <label class="form-check-label" for="flexradio3">Item 2</label>
                    </div>
                </div>

                <div class="app-title mt-4 mb-3">
                    <h2>Toogle</h2>
                </div>

                <ul class="toogle-switch border-0 pt-0">
                    <li>
                        <h3>Item 1</h3>
                        <div class="switch-btn">
                            <input type="checkbox">
                        </div>
                    </li>
                    <li>
                        <h3>Item 2</h3>
                        <div class="switch-btn">
                            <input type="checkbox">
                        </div>
                    </li>
                </ul>

            </form>
        </div>
    </section>

@endsection
