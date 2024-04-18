<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div class="container">
        <div class="row mt-3 mb-3">
            <form action="{{ route('search') }}" method="GET">
                <div class="container mt-3 col-md-10 d-flex">
                    <div class="col-md-3" style="font-weight:bold">Comany</div>
                    <div class="col-md-3">
                        <Select class="form-select form-select-sm" name="company_id">
                            <option value="">Select Company</option>
                            @foreach ($companies as $company)
                                <option value="{{ $company->id }}" @if (request('company_id') == $company->id) selected @endif>
                                    {{ $company->name }}
                                </option>
                            @endforeach
                        </Select>
                    </div>
                </div>
                <div class="container col-md-10 d-flex mt-2">
                    <div class="form-check me-3">
                        <input class="form-check-input" type="radio" name="option" id="option1" value="1"
                            @if (request('option') == 1) checked @endif>
                        <label class="form-check-label" for="option1">
                            ID
                        </label>
                    </div>
                    <div class="form-check me-3">
                        <input class="form-check-input" type="radio" name="option" id="option2" value="2"
                            @if (request('option') == 2) checked @endif>
                        <label class="form-check-label" for="option2">
                            Name
                        </label>
                    </div>
                    <div class="form-check me-3">
                        <input class="form-check-input" type="radio" name="option" id="option3" value="3"
                            @if (request('option') == 3) checked @endif>
                        <label class="form-check-label" for="option3">
                            Email
                        </label>
                    </div>
                    <div class="form-check me-3">
                        <input class="form-check-input" type="radio" name="option" id="option4" value="4"
                            @if (request('option') == 4) checked @endif>
                        <label class="form-check-label" for="option4">
                            Address
                        </label>
                    </div>
                </div>
                {{-- @if (request()->filled('inputSearch') && !request()->filled('option'))
                    <span class="text-danger">
                        Please select a search option.
                    </span>
                @endif --}}
                <div class="container col-md-10 d-flex mt-2">
                    <div class="col-md-3 me-2">
                        <input type="text" name="inputSearch" id="inputSearch" class="form-control"
                            @if (request('inputSearch')) value="{{ request('inputSearch') }}" @endif>
                        {{-- @if (!request()->filled('option')) disabled @endif> --}}
                        <span class="text-danger">
                            @error('inputSearch')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        {{ __('Search') }}
                    </button>

                </div>
               
            </form>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Address</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($employees as $employee)
                    <tr>
                        <th scope="row">{{ $employee->id }}</th>
                        <td>{{ $employee->name }}</td>
                        <td>{{ $employee->email }}</td>
                        <td>{{ $employee->address }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $employees->links() }}
    </div>
</body>
<script>
    // Lắng nghe sự kiện thay đổi của các tùy chọn tìm kiếm
    document.querySelectorAll('input[name="option"]').forEach(function(option) {
        option.addEventListener('change', function() {
            // Nếu không có tùy chọn nào được chọn, vô hiệu hóa trường tìm kiếm
            document.getElementById('inputSearch').disabled = !document.querySelector(
                'input[name="option"]:checked');
        });
    });
</script>

</html>
