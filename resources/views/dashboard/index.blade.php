@extends('layout.app')
@section('title', __('dashboard'))
@section('content')
    <section class="forms">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-5">
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <div class="report-section-card">
                                <div class="report-section-card-body">
                                    <div class="report-section-card-text">
                                        {{ __('profit') }}
                                    </div>
                                    <div class="report-section-card-image">
                                        <img src="{{ asset('icons/graph.svg') }}" alt="">
                                    </div>
                                </div>
                                <div class="report-section-card-price">{{ numberFormat($monthlyProfit) }}</div>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <div class="report-section-card">
                                <div class="report-section-card-body">
                                    <div class="report-section-card-text">
                                        {{ __('sales') }}
                                    </div>
                                    <div class="report-section-card-image up-arrow-square-color">
                                        <img src="{{ asset('icons/up-arrow-square.svg') }}" alt="">
                                    </div>
                                </div>
                                <div class="report-section-card-price">{{ numberFormat($totalSales) }}</div>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <div class="report-section-card">
                                <div class="report-section-card-body">
                                    <div class="report-section-card-text">
                                        {{ __('purchase') }}
                                    </div>
                                    <div class="report-section-card-image dwon-arrow-square-color">
                                        <img src="{{ asset('icons/dwon-arrow-square.svg') }}" alt="">
                                    </div>
                                </div>
                                <div class="report-section-card-price">{{ numberFormat($totalPurchase) }}</div>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <div class="report-section-card">
                                <div class="report-section-card-body">
                                    <div class="report-section-card-text">
                                        {{ __('purchase_due') }}
                                    </div>
                                    <div class="report-section-card-image cup-arrow-square-color">
                                        <img src="{{ asset('icons/cup.svg') }}" alt="">
                                    </div>
                                </div>
                                <div class="report-section-card-price">{{ numberFormat($totalPurchaseDue) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="report-month-card">
                        <div class="report-month-card-text">{{ date('F') }} {{ date('Y') }}</div>
                        <div class="month-report-card">
                            <div class="monthly-purchase" style="width:25%;"></div>
                            <div class="monthly-revenue" style="width:55%;"></div>
                            <div class="monthly-expense" style="width:30%;"></div>
                        </div>
                        <div class="all-report-amount">
                            <div class="all-report-card">
                                <div class="all-report-card-text purchase-text-color">{{ __('purchase') }}</div>
                                <div class="all-report-card-amount">903</div>
                            </div>
                            <div class="all-report-card">
                                <div class="all-report-card-text revenue-text-color">{{ __('revenue') }}</div>
                                <div class="all-report-card-amount">8,113</div>
                            </div>
                            <div class="all-report-card">
                                <div class="all-report-card-text expense-text-color">{{ __('expense') }}</div>
                                <div class="all-report-card-amount">1,202</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-lg-8">
                    <div class="graph-card">
                        <div class="graph-card-text">{{ __('purchase_and_sale_flow') }}</div>
                        <div id="purchaseSaleChart"></div>
                    </div>
                    <div class="graph-card mt-3">
                        <div class="graph-card-text">{{ __('cash_flow') }}</div>
                        <div id="payment"></div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="best-sale-monthly-card">
                        <div class="best-sale-monthly">
                            <div class="best-sale-monthly-text">{{ __('sales_in') }} {{ date('F') }}</div>
                        </div>
                        <div class="table-responsive w-100">
                            <table class="table table-borderless table-responsive-md best-sell-table">
                                <tr class="best-sale-monthly-table-tr">
                                    <th class="border-r-0">{{ __('product_details') }}</th>
                                    <th class="text-center">{{ __('qty') }}</th>
                                </tr>
                                @foreach ($sales as $key => $sale)
                                    <tr>
                                        <td>
                                            <div class="d-flex">
                                                <div class="best-sale-monthly-image">
                                                    <img src="{{ $sale->thumbnail?->file }}" width="33px" alt="">
                                                </div>
                                                <div class="mt-2">{{ Str::limit($sale->name, 30, '...') }}
                                                    [{{ $sale->code }}]</div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            {{ $sale->qty }}
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>

                    <div class="best-sale-monthly-card mt-3">
                        <div class="best-sale-monthly">
                            <div class="best-sale-monthly-text">{{ __('purchase_in') }} {{ date('F') }}</div>
                        </div>
                        <div class="w-100 table-responsive">
                            <table class="table table-borderless table-responsive-md best-sell-table">
                                <tr class="best-sale-monthly-table-tr">
                                    <th class="border-r-0">{{ __('product_details') }}</th>
                                    <th class="text-center">{{ __('qty') }}</th>
                                </tr>
                                @foreach ($purchases as $key => $purchase)
                                    <tr>
                                        <td>
                                            <div class="d-flex">
                                                <div class="best-sale-monthly-image">
                                                    <img src="{{ $purchase->thumbnail?->file }}" width="33px"
                                                        alt="">
                                                </div>
                                                <div class="mt-2">{{ Str::limit($purchase->name, 30, '...') }}
                                                    [{{ $purchase->code }}]</div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            {{ $purchase->qty }}
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row my-3">
                <div class="col-lg-12">
                    <div class="best-sale-monthly-card">
                        <div class="best-sale-monthly">
                            <div class="best-sale-monthly-text">{{ __('recent_transaction') }}</div>
                        </div>
                        <div class="w-100 table-responsive">
                            <table class="table table-borderless table-responsive-md best-sell-table">
                                <tr class="best-sale-monthly-table-tr">
                                    <th class="border-r-0">{{ __('date') }}</th>
                                    <th>{{ __('payment_method') }}</th>
                                    <th>{{ __('translation_by') }}</th>
                                    <th>{{ __('status') }}</th>
                                    <th>{{ __('amount') }}</th>
                                </tr>
                                @foreach ($transactions as $transaction)
                                    <tr>
                                        <td>{{ dateFormat($transaction->date) }}</td>
                                        <td>{{ $transaction->payment_method }}</td>
                                        <td>{{ $transaction->user->name }}</td>
                                        <td><span
                                                class="transaction-status">{{ $transaction->transection_type->value }}</span>
                                        </td>
                                        <td>{{ numberFormat($transaction->amount) }}</td>
                                    </tr>
                                @endforeach

                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        var options = {
            series: [{
                name: 'Sales',
                data: [44, 55, 57, 56, 61, 58, 63, 60, 66]
            }, {
                name: 'Purchase',
                data: [76, 85, 101, 98, 87, 105, 91, 114, 94]
            }],
            chart: {
                type: 'bar',
                height: 350
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return "$ " + val + " thousands"
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#purchaseSaleChart"), options);
        chart.render();

        var options = {
            series: [{
                name: "Debit",
                data: [10, 41, 35, 51, 49, 62, 69, 91, 148]
            }, {
                name: "Credit",
                data: [76, 85, 101, 98, 87, 105, 91, 114, 94]
            }],

            chart: {
                height: 350,
                type: 'line',
                zoom: {
                    enabled: false
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'straight'
            },
            grid: {
                row: {
                    colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                    opacity: 0.5
                },
            },
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
            }
        };

        var chart = new ApexCharts(document.querySelector("#payment"), options);
        chart.render();
    </script>

    @if (session('token'))
        <script>
            localStorage.setItem("token", "{{ session('token') }}");
            localStorage.setItem("name", "{{ auth()->user()->name }}");
            localStorage.setItem("role", "{{ auth()->user()->roles[0]->name }}");
            localStorage.setItem("image", "{{ auth()->user()->thumbnail->file ?? null }}");
        </script>
    @endif
@endpush
