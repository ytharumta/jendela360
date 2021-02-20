@extends('layout.global')

@section('title')
    Dashboard
@endsection

@section('pagetitle')
    Dashboard
@endsection

@section('pagetitledes')
    Hi!,Welcome to Jendela360 Dashboard!
@endsection

@section('content')
<div class="col-md-4">
    <div class="card card-bordered card-full">
        <div class="card-inner">
            <div class="card-title-group align-start mb-0">
                <div class="card-title">
                    <h6 class="subtitle">Total Sales</h6>
                </div>
                <div class="card-tools">
                    <em class="card-hint icon ni ni-help-fill" data-toggle="tooltip" data-placement="left" title="Total Sales"></em>
                </div>
            </div>
            <div class="card-amount">
                <span class="amount"> {{$sales}} <span class="currency currency-usd">IDR / {{$count}} Penjualan</span>
                </span>
                <span class="change up text-danger"><em class="icon ni ni-arrow-long-up"></em>{{$percent}}%</span>
            </div>
            <br>
            <div class="invest-data">
                <div class="invest-data-amount g-2">
                    <div class="invest-data-history">
                        <div class="title">Last Week</div>
                        <div class="amount">{{$saleslastweek}} <span class="currency currency-usd">IDR</span></div>
                    </div>
                    <div class="invest-data-history">
                        <div class="title">This Week</div>
                        <div class="amount">{{$salesweek}} <span class="currency currency-usd">IDR <br> Percentase : {{$percent}}%</span></div>
                    </div>
                </div>
            </div>
            <br>
            <div class="invest-data">
                <div class="invest-data-amount g-2">
                    <div class="invest-data-history">
                        <div class="title">Last Week</div>
                        <div class="amount">{{$countlastweek}} <span class="currency currency-usd">Penjualan</span></div>
                    </div>
                    <div class="invest-data-history">
                        <div class="title">This Week</div>
                        <div class="amount">{{$countweek}} <span class="currency currency-usd">Penjualan<br> Percentase : {{$countpercent}}%</span></div>
                    </div>
                </div>
            </div>
            <br>
            <div class="invest-data">
                <div class="invest-data-amount g-2">
                    <div class="invest-data-history">
                        <div class="title">Yesterday</div>
                        <div class="amount">{{$salesyesterday}} <span class="currency currency-usd">IDR</span></div>
                    </div>
                    <div class="invest-data-history">
                        <div class="title">Today</div>
                        <div class="amount">{{$salestoday}} <span class="currency currency-usd">IDR<br> Percentase :{{$todaypercent}}%</span></div>
                    </div>
                </div>
            </div>
            <br>
            <div class="invest-data">
                <div class="invest-data-amount g-2">
                    <div class="invest-data-history">
                        <div class="title">Yesterday</div>
                        <div class="amount">{{$countyesterday}} <span class="currency currency-usd"> Penjualan</span></div>
                    </div>
                    <div class="invest-data-history">
                        <div class="title">Today</div>
                        <div class="amount">{{$counttoday}} <span class="currency currency-usd">Penjualan <br> Percentase :{{$ctodaypercent}}%</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- .card -->
</div><!-- .col -->
@endsection
