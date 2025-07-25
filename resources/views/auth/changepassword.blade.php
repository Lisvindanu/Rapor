<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ganti Password</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('{{ asset('storage/images/bg-pattern.png') }}');
            /* URL gambar latar belakang */
            background-repeat: repeat;
            /* Gambar latar belakang diulang */
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.1);
            /* Ubah opacity sesuai kebutuhan */
            z-index: -1;
            /* Letakkan di bawah konten lain */
        }

        .login-container {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            max-width: 1000px;
            /* Lebar maksimum */
            width: 100%;
            display: flex;
            padding: 0;
            /* Menghilangkan padding */
            height: 550px;
            /* Tinggi */
            position: relative;
            /* Menetapkan posisi relatif untuk kontainer */
        }

        .login-left {
            flex: 1;
            padding-right: 40px;
            margin-right: -40px;
            /* Margin negatif */
            background: url('{{ asset('storage/images/login-side-left.jpg') }}') no-repeat center center;
            background-size: cover;
            border-radius: 10px 0 0 10px;
            position: relative;
            /* Menetapkan posisi relatif untuk kontainer */
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            color: white;
            padding-left: 20px;
        }

        /* Menambahkan teks di atas gambar */
        .login-left h1 {
            font-size: 24px;
            font-weight: bold;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);
            text-decoration: underline;
            /* Garis bawah */
            margin-bottom: 10px;
        }

        /* Menambahkan teks di bawah gambar */
        .login-left p {
            font-size: 18px;
            font-weight: bold;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);
            white-space: pre-line;
            /* Untuk menjaga spasi */
        }

        .login-right {
            flex: 1;
            padding-left: 40px;
            margin: 20px;
            /* Menambahkan margin */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .login-right form {
            max-width: 400px;
            /* Atur lebar maksimum formulir */
            width: 100%;
            /* Pastikan formulir mengisi lebar kontainer */
            margin: 0 auto;
            /* Pusatkan formulir di dalam .login-right */
        }

        .login-right form input[type="text"],
        .login-right form input[type="password"] {
            width: 100%;
            /* Gunakan lebar penuh */
            padding: 12px;
            margin-bottom: 20px;
            border: none;
            border-bottom: 0.1px solid #2f7be6;
            /* Border bagian bawah saja */
            border-radius: 0;
            /* Hapus border-radius */
            box-sizing: border-box;
            /* Perhitungan ukuran padding dan border */
        }

        .login-right form button[type="submit"] {
            width: 100%;
            padding: 12px;
            border-radius: 5px;
            border: none;
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
            /* Efek transisi saat hover */
        }

        .login-right form button[type="submit"]:hover {
            background-color: #0056b3;
            /* Warna latar belakang saat hover */
        }

        .login-right .forgot-password,
        .login-right .create-account {
            margin-top: 10px;
            text-align: center;
        }

        .login-right .forgot-password a,
        .login-right .create-account a {
            color: #007bff;
            text-decoration: none;
        }

        @media (max-width: 768px) {

            /* Atur tata letak untuk layar seluler */
            .login-container {
                flex-direction: column;
                /* Mengubah tata letak menjadi kolom */
                height: auto;
                /* Ubah ketinggian menjadi otomatis */
            }

            .login-left {
                border-radius: 10px 10px 0 0;
                /* Menghapus sudut bulat di kanan */
                margin: 0;
            }

            .login-right {
                border-radius: 0 0 10px 10px;
                /* Menghapus sudut bulat di kiri */
                margin: 0;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-left">
            <h1>Selamat Datang</h1>
            <p>LINK APP<br><strong>UNIVERSITAS PASUNDAN</strong></p>
        </div>
        <div class="login-right">
            <h2>Ganti Password</h2>
            <p style="text-align: center">Lebih aman untuk mengganti password secara berkala dan jangan menggunakan
                password yang mudah ditebak.</p>

            @if (session('message'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">X</button>
                </div>
            @endif

            <form method="POST" action="{{ route('updatePassword') }}">
                @csrf
                <div class="form-group position-relative">
                    <label for="old_password">Password Lama</label>
                    <input type="password"
                        class="form-control @error('old_password') is-invalid
                    @enderror"
                        id="old_password" name="old_password" placeholder="Masukkan password lama" required>
                    @error('old_password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group position-relative">
                    <label for="password">Password Baru</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                        name="password" placeholder="Masukkan password baru" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group position-relative">
                    <label for="password_confirmation">Ulangi Password Baru</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                        placeholder="Ulangi password baru" required>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</body>

</html>
