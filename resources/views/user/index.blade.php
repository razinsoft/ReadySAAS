@extends('layout.app')
@section('title', __('users'))
@section('content')
    <section>
        <div class="container-fluid">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <span class="list-title">{{ __('users') }}</span>
                    @can('user.create')
                        <a href="{{ route('user.create') }}" class="btn common-btn"><i class="fa fa-plus"></i>
                            {{ __('add_user') }}</a>
                    @endcan
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dataTable" class="table dataTable table-hover">
                            <thead class="table-bg-color">
                                <tr>
                                    <th class="not-exported">{{ __('sl') }}</th>
                                    <th>{{ __('name') }}</th>
                                    <th>{{ __('email') }}</th>
                                    <th>{{ __('company_name') }}</th>
                                    <th>{{ __('phone_number') }}</th>
                                    <th>{{ __('role') }}</th>
                                    <th class="not-exported">{{ __('action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($staffs as $staff)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $staff->user->name }}</td>
                                        <td>{{ $staff->user->email }}</td>
                                        <td>{{ $staff->user->company_name ?? 'N/A' }}</td>
                                        <td>{{ $staff->user->phone ?? 'N/A' }}</td>
                                        <td>{{ ucfirst($staff->user->roles[0]->name ?? 'N/A') }}</td>
                                        <td class="">
                                            <a href="{{ route('user.edit', $staff->user->id) }}" class="btn btn-sm btn-info"><i
                                                    class="fa fa-edit"></i></a>

                                            <a id="delete" href="{{ route('user.delete', $staff->user->id) }}"
                                                class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
