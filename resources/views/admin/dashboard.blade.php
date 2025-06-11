@extends('admin.layouts.app')

@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-9 col-xxl-12">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="row">
                                <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

                                <div class="col-xl-9 col-sm-6">
                                    <div class="card overflow-hidden">
                                        <div class="card-header border-0 pb-0 flex-wrap">
                                            <h4 class="heading mb-0">Tickets Overview</h4>
                                            <ul class="nav nav-pills mix-chart-tab" id="pills-tab" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link active" data-series="week" id="pills-week-tab"
                                                        data-bs-toggle="pill" data-bs-target="#pills-week" type="button"
                                                        role="tab" aria-selected="true">Week</button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link" data-series="month" id="pills-month-tab"
                                                        data-bs-toggle="pill" data-bs-target="#pills-month" type="button"
                                                        role="tab" aria-selected="false">Month</button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link" data-series="year" id="pills-year-tab"
                                                        data-bs-toggle="pill" data-bs-target="#pills-year" type="button"
                                                        role="tab" aria-selected="false">Year</button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link" data-series="all" id="pills-all-tab"
                                                        data-bs-toggle="pill" data-bs-target="#pills-all" type="button"
                                                        role="tab" aria-selected="false">All</button>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="card-body custome-tooltip p-0">
                                            <div id="ticketsChart" style="min-height: 250px;"></div>

                                            <!-- Ticket Summary Data -->
                                            <div class="ttl-project">
                                                <div class="pr-data">
                                                    <h5>{{ $totalTickets ?? 0 }}</h5>
                                                    <span>Total Tickets</span>
                                                </div>
                                                <div class="pr-data">
                                                    <h5 class="text-primary">{{ $openTickets ?? 0 }}</h5>
                                                    <span>Open Tickets</span>
                                                </div>
                                                <div class="pr-data">
                                                    <h5 class="text-success">{{ $closedTickets ?? 0 }}</h5>
                                                    <span>Closed Tickets</span>
                                                </div>
                                                <div class="pr-data">
                                                    <h5 class="text-warning">{{ $pendingTickets ?? 0 }}</h5>
                                                    <span>Pending Tickets</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-3 col-sm-6">
                                    <div class="card bg-success rainbow-box"
                                        style="background-image: url(images/rainbow.gif);background-size: cover;background-blend-mode: luminosity;">
                                        <div class="card-header border-0">

                                        </div>
                                        <div class="card-body pt-0">
                                            <div class="finance">
                                                <h4>Your Support, Organized and Efficient</h4>
                                                <p>
                                                    Our ticketing system ensures every customer issue is tracked, managed,
                                                    and resolved on time.
                                                    Whether it's technical queries or billing concerns, we've got your back
                                                    with secure and streamlined support handling.
                                                </p>
                                            </div>

                                            <div class="d-flex pt-3">
                                                <div class="avatar-list avatar-list-stacked">
                                                    <img src="{{ asset('admin/images/contacts/pic555.jpg') }}"
                                                        class="avatar rounded-circle" alt="">
                                                    <img src="{{ asset('admin/images/contacts/pic666.jpg') }}"
                                                        class="avatar rounded-circle" alt="">
                                                    <img src="{{ asset('admin/images/contacts/pic777.jpg') }}"
                                                        class="avatar rounded-circle" alt="">
                                                </div>
                                                <div class="ratting-data">
                                                    <h4>15k+</h4>
                                                    <span>Happy Clients</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-8">

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Chart data from PHP
            const ticketChartData = @json($chartData);

            // Function to initialize chart
            function initChart(seriesType) {
                const seriesData = ticketChartData[seriesType] || [];
                const categories = ticketChartData[seriesType + '_labels'] || [];

                const options = {
                    series: [{
                        name: 'Tickets',
                        data: seriesData
                    }],
                    chart: {
                        type: 'bar',
                        height: 350,
                        toolbar: {
                            show: false
                        }
                    },
                    plotOptions: {
                        bar: {
                            borderRadius: 4,
                            horizontal: false,
                        }
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
                        categories: categories
                    },
                    yaxis: {
                        title: {
                            text: 'Number of Tickets'
                        }
                    },
                    fill: {
                        opacity: 1
                    },
                    tooltip: {
                        y: {
                            formatter: function(val) {
                                return val + " tickets";
                            }
                        }
                    },
                    colors: ['#3a57e8']
                };

                const chart = new ApexCharts(document.querySelector("#ticketsChart"), options);
                chart.render();

                return chart;
            }

            // Initialize with default tab (week)
            let chart = initChart('week');

            // Tab switching functionality
            document.querySelectorAll('.nav-link[data-series]').forEach(button => {
                button.addEventListener('click', function() {
                    const seriesType = this.getAttribute('data-series');

                    // Update chart with new data
                    chart.updateOptions({
                        series: [{
                            data: ticketChartData[seriesType] || []
                        }],
                        xaxis: {
                            categories: ticketChartData[seriesType + '_labels'] || []
                        }
                    });
                });
            });
        });
    </script>
@endsection
