<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', "AdminLTE 3")</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ url('/') }}/favicon.ico" type="image/x-icon">
    <link rel="icon" href="{{ url('/') }}/favicon.ico" type="image/x-icon">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ url('admin/assets') }}/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ url('admin/assets') }}/dist/css/adminlte.min.css">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ url('admin/assets') }}/plugins/summernote/summernote-bs4.min.css">
    <!-- datatables -->
    <link rel="stylesheet" href="{{ url('admin/assets') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ url('admin/assets') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin=""/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.css" integrity="sha512-wJgJNTBBkLit7ymC6vvzM1EcSWeM9mmOu+1USHaRBbHkm6W9EgM0HY27+UtUaprntaYQJF75rc8gjxllKs5OIQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    @stack('css')
</head>

<body class="hold-transition sidebar-mini">
<script src="{{ url('admin/assets') }}/plugins/jquery/jquery.min.js"></script>
    <div class="wrapper">
        @include('admin.layouts.navbar')

        @include('admin.layouts.sidebar')


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            @yield('content')

            @php
                /*
                    <!-- Content Header (Page header) -->
                    <div class="content-header">
                      <div class="container-fluid">
                        <div class="row mb-2">
                          <div class="col-sm-6">
                            <h1 class="m-0">Starter Page</h1>
                          </div><!-- /.col -->
                          <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                              <li class="breadcrumb-item"><a href="#">Home</a></li>
                              <li class="breadcrumb-item active">Starter Page</li>
                            </ol>
                          </div><!-- /.col -->
                        </div><!-- /.row -->
                      </div><!-- /.container-fluid -->
                    </div>
                    <!-- /.content-header -->

                    <!-- Main content -->
                    <div class="content">
                      <div class="container-fluid">
                        <div class="row">
                          <div class="col-lg-6">
                            <div class="card">
                              <div class="card-body">
                                <h5 class="card-title">Card title</h5>

                                <p class="card-text">
                                  Some quick example text to build on the card title and make up the bulk of the card's
                                  content.
                                </p>

                                <a href="#" class="card-link">Card link</a>
                                <a href="#" class="card-link">Another link</a>
                              </div>
                            </div>

                            <div class="card card-primary card-outline">
                              <div class="card-body">
                                <h5 class="card-title">Card title</h5>

                                <p class="card-text">
                                  Some quick example text to build on the card title and make up the bulk of the card's
                                  content.
                                </p>
                                <a href="#" class="card-link">Card link</a>
                                <a href="#" class="card-link">Another link</a>
                              </div>
                            </div><!-- /.card -->
                          </div>
                          <!-- /.col-md-6 -->
                          <div class="col-lg-6">
                            <div class="card">
                              <div class="card-header">
                                <h5 class="m-0">Featured</h5>
                              </div>
                              <div class="card-body">
                                <h6 class="card-title">Special title treatment</h6>

                                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                <a href="#" class="btn btn-primary">Go somewhere</a>
                              </div>
                            </div>

                            <div class="card card-primary card-outline">
                              <div class="card-header">
                                <h5 class="m-0">Featured</h5>
                              </div>
                              <div class="card-body">
                                <h6 class="card-title">Special title treatment</h6>

                                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                <a href="#" class="btn btn-primary">Go somewhere</a>
                              </div>
                            </div>
                          </div>
                          <!-- /.col-md-6 -->
                        </div>
                        <!-- /.row -->
                      </div><!-- /.container-fluid -->
                    </div>
                    <!-- /.content -->
                        */
            @endphp

        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
            <div class="p-3">
                <h5>Title</h5>
                <p>Sidebar content</p>
            </div>
        </aside>
        <!-- /.control-sidebar -->
        @include('admin.layouts.footer')

    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->

    <!-- Bootstrap 4 -->
    <script src="{{ url('admin/assets') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="{{ url('admin/assets') }}/dist/js/adminlte.min.js"></script>
    <!-- datatable -->
    <script src="{{ url('admin/assets') }}/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ url('admin/assets') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ url('admin/assets') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="{{ url('admin/assets') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <!-- summernote -->
    <script src="{{ url('admin/assets') }}/plugins/summernote/summernote-bs4.min.js"></script>
    <!-- leafletjs -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-search/3.0.2/leaflet-search.src.js"></script>

    <!-- auto numeric -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/autonumeric/4.1.0/autoNumeric.min.js" integrity="sha512-U0/lvRgEOjWpS5e0JqXK6psnAToLecl7pR+c7EEnndsVkWq3qGdqIGQGN2qxSjrRnCyBJhoaktKXTVceVG2fTw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js" integrity="sha512-zlWWyZq71UMApAjih4WkaRpikgY9Bz1oXIW5G0fED4vk14JjGlQ1UmkGM392jEULP8jbNMiwLWdM8Z87Hu88Fw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(function () {
          $('.note').summernote({
            height: 240,
          })

          $("#table1").DataTable({
            "responsive": true,
            "autoWidth": false,
          });
          $('#table2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
          });
        });

        function keluarSystem() {
          var pesanKeluar = confirm("Apakah Ingin Keluar Dari Sistem?");
          if (pesanKeluar) {
            window.location= "{{route('admin.logout')}}"
          } else {
            console.log('batal')
          }
        }

    </script>
    @stack('js')
</body>

</html>
