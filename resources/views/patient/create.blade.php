@extends('layouts.default')
@section('content')
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between">
                            <h4 class="mb-0 font-size-18">Thêm bệnh nhân</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Quản lý</a></li>
                                    <li class="breadcrumb-item active">Thêm bệnh nhân</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

                                <h4 class="card-title">Thông tin cơ bản</h4>
                                <p class="card-title-desc">Điền tất cả thông tin bên dưới</p>

                                <form method="POST" action="{{ route('patients.store') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="name">Họ và tên <span class="text-danger">*</span></label>
                                                <input id="name" name="name" type="text" class="form-control" placeholder="Họ và tên">
                                            </div>

                                            <div class="form-group">
                                                <label for="sex">Giới tính <span class="text-danger">*</span></label>
                                                <div class="form-check form-check">
                                                    <input type="radio" class="form-check-input" id="nam" name="sex" value="Nam" checked>
                                                    <label class="form-check-label" for="nam">Nam</label>
                                                </div>
                                                <div class="form-check form-check">
                                                    <input type="radio" class="form-check-input" id="nu" name="sex" value="Nữ">
                                                    <label class="form-check-label" for="nu">Nữ</label>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="birthday">Ngày sinh <span class="text-danger">*</span></label>
                                                <div class="docs-datepicker">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control docs-date" name="birthday" placeholder="Chọn ngày sinh" autocomplete="off">
                                                        <div class="input-group-append">
                                                            <button type="button" class="btn btn-outline-secondary docs-datepicker-trigger" disabled="">
                                                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="docs-datepicker-container"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="price">Ảnh đại diện</label>
                                                <input id="price" name="price" type="file" class="form-control">
                                            </div>

                                            <div class="form-group">
                                                <label for="phone">Số điện thoại <span class="text-danger">*</span></label>
                                                <input id="phone" name="phone" type="number" class="form-control" placeholder="Số điện thoại">
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="address">Địa chỉ <span class="text-danger">*</span></label>
                                                <input id="address" name="address" type="text" class="form-control" placeholder="Địa chỉ">
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary mr-1 waves-effect waves-light">Lưu lại</button>
                                    <a href="{{ route('patients.index') }}" class="btn btn-secondary waves-effect">Quay lại</a>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->

            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->


        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <script>document.write(new Date().getFullYear())</script> © Skote.
                    </div>
                    <div class="col-sm-6">
                        <div class="text-sm-right d-none d-sm-block">
                            Design & Develop by Themesbrand
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
@endsection

@push('js')
    <!-- select 2 plugin -->
    <script src="{{ asset('libs\select2\js\select2.min.js') }}"></script>

    <!-- init js -->
    <script src="{{ asset('js\pages\ecommerce-select2.init.js') }}"></script>

    <!-- datepicker -->
    <script src="{{ asset('libs\bootstrap-datepicker\js\bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('libs\bootstrap-colorpicker\js\bootstrap-colorpicker.min.js') }}"></script>
    <script src="{{ asset('libs\bootstrap-timepicker\js\bootstrap-timepicker.min.js') }}"></script>
    <script src="{{ asset('libs\bootstrap-touchspin\jquery.bootstrap-touchspin.min.js') }}"></script>
    <script src="{{ asset('libs\bootstrap-maxlength\bootstrap-maxlength.min.js') }}"></script>
    <script src="{{ asset('libs\@chenfengyuan\datepicker\datepicker.min.js') }}"></script>
    <!-- form advanced init -->
    <script src="{{ asset('js\pages\form-advanced.init.js') }}"></script>
@endpush

@push('css')
    <!-- datepicker css -->
    <link href="{{ asset('libs\bootstrap-datepicker\css\bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('libs\bootstrap-colorpicker\css\bootstrap-colorpicker.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('libs\bootstrap-timepicker\css\bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('libs\@chenfengyuan\datepicker\datepicker.min.css') }}">
@endpush