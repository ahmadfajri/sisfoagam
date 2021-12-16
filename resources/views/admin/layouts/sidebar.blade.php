<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('admin.home') }}" class="brand-link">
        <img src="{{ url('/') }}/admin/assets/bg/kab-agam.png" alt="{{ auth()->user()->name ?? '' }}"
            class="brand-image img-circle elevation-3">
        <span class="brand-text font-weight-light">{{ auth()->user()->name ?? '' }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ url('admin/assets') }}/dist/img/avatar2.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"></a>
        </div>
      </div> -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ route('admin.home') }}" class="nav-link active">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Home
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-database"></i>
                        <p>
                            Master Data
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Akomodasi
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.master-data.akomodasi.fasilitas.index') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Fasilitas</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.master-data.akomodasi.kategori.index') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Kategori</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Destinasi
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.master-data.destinasi-wisata.fasilitas.index') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Fasilitas</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.master-data.destinasi-wisata.kategori.index') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Kategori</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Ekonomi Kreatif
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.master-data.ekonomi-kreatif.kategori.index') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Kategori</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.foto-slider.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Foto Slider
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.master-data.video.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Video Home
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Banner
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.master-data.banner.index', 'akomodasi') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Akomodasi</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.master-data.banner.index', 'destinasi_wisata') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Destinasi Wisata</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.master-data.banner.index', 'ekonomi_kreatif') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Ekonomi Kreatif</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.master-data.banner.index', 'event') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Event</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.master-data.banner.index', 'berita') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Berita</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.master-data.banner.index', 'fasilitas_umum') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Fasilitas Umum</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Background Image
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.master-data.banner.index', 'bg-wisata') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Destinasi Wisata</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.master-data.banner.index', 'bg-ekonomi') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Ekonomi Kreatif</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.master-data.banner.index', 'bg-event') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Event</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.master-data.panduan.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Panduan Aplikasi
                                </p>
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.akomodasi.home') }}" class="nav-link">
                        <i class="nav-icon fas fa-hotel"></i>
                        <p>
                            Akomodasi
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.destinasi-wisata.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-umbrella-beach"></i>
                        <p>
                            Destinasi Wisata
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.ekonomi-kreatif.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-store"></i>
                        <p>
                            Ekonomi Kreatif
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.berita-parawisata.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-newspaper"></i>
                        <p>
                            Berita Parawisata
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.fasilitas-umum.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-box-open"></i>
                        <p>
                            Fasilitas Umum
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.event-parawisata.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-calendar-day"></i>
                        <p>
                            Event Parawisata
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.admin.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            User Admin
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.panduan.show') }}" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Panduan Aplikasi
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
