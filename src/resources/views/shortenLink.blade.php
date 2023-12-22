<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>URL Shortener</title>

    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">

    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">

    <!-- Переключение между светлой и темной темой -->
    <link id="theme-style" rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">

    <style>
        /* Стили для темной темы */
        body.dark-mode {
            background-color: #264653;
            color: #ffffff;
        }

        /* Стили для светлой темы (по умолчанию) */
        body.light-mode {
            background-color: #ffffff;
            color: #000000;
        }

        .navbar {
            background-color: #2a9d8f;
        }

        .navbar-brand,
        .navbar-toggler-icon {
            color: #ffffff;
        }

        .navbar-toggler {
            border: none;
        }

        .navbar-toggler:focus {
            outline: none;
        }

        .btn-toggle-theme {
            color: #ffffff;
        }

        .card {
            border-color: #2a9d8f;
        }

        .btn-success {
            background-color: #e9c46a;
            border-color: #e9c46a;
        }

        .btn-success:hover {
            background-color: #f4a261;
            border-color: #f4a261;
        }

        .alert-success {
            background-color: #2a9d8f;
            border-color: #2a9d8f;
            color: #ffffff;
        }

        .table {
            border-color: #2a9d8f;
        }

        .table thead th {
            background-color: #2a9d8f;
            color: #ffffff;
        }

        .footer {
            background-color: #2a9d8f;
            color: #ffffff;
            padding: 20px 0;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body class="light-mode">

<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">
        <a class="navbar-brand" href="#">URL Shortener</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <button class="btn btn-toggle-theme" onclick="toggleTheme()">Переключить тему</button>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h1 class="text-center mb-4">URL Shortener</h1>

    <div class="card">
        <div class="card-header">
            <form id="shortenForm" method="POST" action="{{ route('shortenLink.store') }}">
                @csrf
                <div class="input-group mb-3">
                    <input type="text" name="link" class="form-control" placeholder="Введите URL" aria-label="Recipient's username" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-success" type="submit">Создать короткую ссылку</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="table-responsive" style="margin-bottom: 100px;">
                <table id="shortLinksTable" class="table table-bordered table-sm">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Короткая ссылка</th>
                        <th>Ссылка</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($shortLinks as $row)
                        <tr>
                            <td>{{ $row->id }}</td>
                            <td><a href="{{ route('shortenLink.redirect', $row->code) }}" target="_blank">{{ route('shortenLink.redirect', $row->code) }}</a></td>
                            <td>{{ $row->link }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<footer class="footer">
    <p>&copy; 2023 URL Shortener. Меркадо Оудалова Данило Анатоли.</p>
</footer>

<!-- Bootstrap 5 JS Bundle (необходим для функций Bootstrap) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

<!-- SweetAlert JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    // Переключение между светлой и темной темой
    function toggleTheme() {
        document.body.classList.toggle('dark-mode');
        document.body.classList.toggle('light-mode');
    }

    // Инициализация DataTable
    $(document).ready(function() {
        $('#shortLinksTable').DataTable();
    });

    // Отправка формы с использованием SweetAlert
    $('#shortenForm').submit(function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Вы уверены?',
            text: 'Хотите создать короткую ссылку?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Да, создать!'
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
            }
        });
    });
</script>

</body>
</html>
