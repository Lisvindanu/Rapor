<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="img/png" href="{{ asset('storage/images/favicon.jpeg') }}" sizes="16x16" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Beranda</title>
    <style>
      .header {
        height: 120px;
        background-image: url('{{ asset('storage/images/bg-pattern.png') }}');
        background-color: rgba(0, 0, 139, 0.7);
      }

      .header-content{
        /* width: 90%;  */
        margin: 0px auto;
      }

      .image-wrapper {
        width: 80px;
        height: 80px;
        background-color: white;
        border-radius: 10px; /* Border radius di kiri */
        display: flex;
        justify-content: center;
        align-items: center;
        /* position: absolute; */
        left: 0;
        margin-top: 20px;
        margin-bottom: 20px;
        /* top: 50%; */
      }

      .image-wrapper img {
        width: 60px; /* Ubah ukuran gambar sesuai kebutuhan */
        height: auto;
      }

      .judul-app {
        justify-content: center;
        align-items: center;
        margin-top: 35px;
        margin-bottom: 35px;
        margin-left: 20px;
        line-height: 0.5;
        color: white;
      }

      
      .button-app {
        margin-top: 35px;
        margin-bottom: 35px;
        display: flex; /* Menggunakan flexbox */
        align-items: center; /* Mengatur seluruh elemen agar berada pada sumbu vertikal yang sama */
      }

      .exit-button {
            background-color: rgba(0, 0, 0, 0.5); /* Warna latar belakang merah dengan opasitas 50% */
            color: #fff; /* Warna teks putih */
            border: none; /* Menghapus border */
            padding: 10px 20px; /* Padding untuk memberikan ruang di dalam tombol */
            border-radius: 5px; /* Border radius untuk sudut melengkung */
            cursor: pointer; /* Mengubah kursor menjadi tangan saat dihover */
            transition: background-color 0.3s ease; /* Efek transisi pada perubahan warna latar belakang */
            margin: 5px;
        }

        .exit-button:hover {
            background-color: rgba(0, 0, 0, 0.8);  /* Warna latar belakang merah yang sedikit lebih gelap saat dihover */
        }

        .menu-navbar {
            background-color: #f8f9fa ;
            border-radius: 5px; /* Menambahkan border radius */
            }

        .navbar-nav .nav-item {
          min-width: 80px; /* Atur lebar minimum */
          text-align: center; /* Teks berada di tengah */
        }

        .navbar-nav .nav-item:hover .nav-link {
          background-color: rgba(0, 0, 139, 0.7);
          color: white; /* Mengubah warna teks menjadi putih */
          border-radius: 5px; /* Menambahkan border radius */ 
        }

        /* Efek hover pada item dropdown */
        .navbar-nav .dropdown-item:hover {
          background-color: rgba(0, 0, 139, 0.7);
          color: white; /* Mengubah warna teks menjadi putih */
          border-radius: 5px; /* Menambahkan border radius */
        }

        @media all and (min-width: 992px) {
          .dropdown-menu li{ position: relative; 	}
          .nav-item .submenu{ 
            display: none;
            position: absolute;
            left:100%; top:-7px;
          }
          .nav-item .submenu-left{ 
            right:100%; left:auto;
          }
          .dropdown-menu > li:hover{ background-color: #f1f1f1 }
          .dropdown-menu > li:hover > .submenu{ display: block; }
        }	
        /* ============ desktop view .end// ============ */

        /* ============ small devices ============ */
        @media (max-width: 991px) {
          .dropdown-menu .dropdown-menu{
              margin-left:0.7rem; margin-right:0.7rem; margin-bottom: .5rem;
          }
        }	

    </style>
  </head>
  <body>
    <div class="header">
      <div class="container">
        <div class="row justify-content-md-center">
          <div class="col-11">
            <div class="header-content">
              <div class="image-wrapper" style="float: left">
                <img src="https://api-frontend.kemdikbud.go.id/v2/detail_pt_logo/MEFBMzk4QTItNkM2OC00RUUwLTg2RkEtM0VBNjVCNTREQzk3">
              </div>
              <div class="judul-app" style="float: left">
                <h5>Sistem Terintegrasi</h5>
                <p><strong>UNIVERSITAS PASUNDAN</strong></p>
              </div>
  
              <div class="button-app" style="float: right">
                <button class="exit-button">Halaman Profil</button>
                <form action="{{ url('/login/exit') }}" method="post">
                    @csrf
                    <button type="submit" class="exit-button">Keluar</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div> 
    </div>
    <div class="menu-navbar">
      <div class="container">
        <div class="row justify-content-md-center">
          <div class="col-11">
            <nav class="navbar navbar-expand-sm navbar-light bg-light">
              <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                  <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                      <a class="nav-link active" aria-current="page" href="#">Beranda</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#">Link</a>
                    </li>
                    <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Dropdown
                      </a>
                      <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        {{-- <li><hr class="dropdown-divider"></li> --}}
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                        <li> <a class="dropdown-item" href="#"> Dropdown item 2 &raquo;</a>
                          <ul class="submenu dropdown-menu">
                            <li><a class="dropdown-item" href="#">Submenu item 1</a></li>
                            <li><a class="dropdown-item" href="#">Submenu item 2</a></li>
                            <li><a class="dropdown-item" href="#">Submenu item 3 &raquo; </a>
                              <ul class="submenu dropdown-menu">
                                <li><a class="dropdown-item" href="#">Multi level 1</a></li>
                                <li><a class="dropdown-item" href="#">Multi level 2</a></li>
                              </ul>
                            </li>
                            <li><a class="dropdown-item" href="#">Submenu item 4</a></li>
                            <li><a class="dropdown-item" href="#">Submenu item 5</a></li>
                          </ul>
                        </li>
                      </ul>
                    </li>
                  </ul>
                  {{-- <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                  </form> --}}
                </div>
              </div>
            </nav>
          </div>
        </div>
      </div>
    </div>
    

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
    <script>
      document.addEventListener("DOMContentLoaded", function(){
      // make it as accordion for smaller screens
      if (window.innerWidth < 992) {

        // close all inner dropdowns when parent is closed
        document.querySelectorAll('.navbar .dropdown').forEach(function(everydropdown){
          everydropdown.addEventListener('hidden.bs.dropdown', function () {
            // after dropdown is hidden, then find all submenus
              this.querySelectorAll('.submenu').forEach(function(everysubmenu){
                // hide every submenu as well
                everysubmenu.style.display = 'none';
              });
          })
        });

        document.querySelectorAll('.dropdown-menu a').forEach(function(element){
          element.addEventListener('click', function (e) {
              let nextEl = this.nextElementSibling;
              if(nextEl && nextEl.classList.contains('submenu')) {	
                // prevent opening link if link needs to open dropdown
                e.preventDefault();
                if(nextEl.style.display == 'block'){
                  nextEl.style.display = 'none';
                } else {
                  nextEl.style.display = 'block';
                }

              }
          });
        })
      }
      // end if innerWidth
      }); 
      // DOMContentLoaded  end
    </script>
  </body>
</html>
