@extends('layout.app')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard Overview')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">User Institute List</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="row mb-3">
                            <form method="GET" action="{{ route('userInstituteList') }}">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control"
                                        placeholder="Search by name or institution" value="{{ request('search') }}">
                                    <button class="btn btn-primary" type="submit">Search</button>
                                </div>
                            </form>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-centered border table-nowrap mb-0" style="width: 100%;">
                                <thead class="table-light">
                                    <tr>
                                        <th>User ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Institute</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($userInstitutions as $item)
                                        <tr>
                                            <td>
                                                {{ $item['user']['id'] }}
                                                <p class="text-muted mb-0 font-size-11">
                                                    {{ \Carbon\Carbon::parse($item['created_at'])->format('d-m-Y') }}</p>
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    <div>
                                                        <h5 class="font-size-13 text-truncate mb-1">
                                                            <a href="#" class="text-dark">{{ $item['name'] }}</a>
                                                        </h5>
                                                        <p class="text-muted mb-0 font-size-11 text-uppercase">
                                                            {{ $item['title'] ?? 'N/A' }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    <div>
                                                        <h5 class="font-size-13 text-truncate mb-1">
                                                            <a href="#"
                                                                class="text-dark">{{ $item['user']['email'] }}</a>
                                                        </h5>
                                                        <p
                                                            class="text-uppercase mb-0 font-size-11 {{ $item['user']['is_deleted'] == 0 ? 'text-success' : 'text-danger' }}">
                                                            <i
                                                                class="mdi {{ $item['user']['is_deleted'] == 0 ? 'mdi-check-circle' : 'mdi-close-circle' }}"></i>
                                                            {{ $item['user']['is_deleted'] == 0 ? 'Active' : 'Inactive' }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <h6 class="mb-1 font-size-13">{{ $item['institution']['name'] }}</h6>
                                                <p class="text-uppercase mb-0 font-size-11">
                                                    <i
                                                        class="mdi"></i>{{ $item['institution']['status'] }}
                                                </p>
                                            </td>
                                            <td>
                                                <a href="{{ route('userInstitute', ['id' => $item['id']]) }}"
                                                    class="btn btn-soft-primary btn-sm">
                                                    View more <i class="mdi mdi-arrow-right ms-1"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
