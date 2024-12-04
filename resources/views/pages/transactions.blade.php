@extends('layout.app')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard Overview')

@section('content')

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Transaction</h4>
                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>VA</th>
                                    <th>Student ID</th>
                                    <th>Institusi</th>
                                    <th>Periode</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>722104850001</td>
                                    <td>291001304101</td>
                                    <td>SMA Negeri 1 Kasihan</td>
                                    <td>2011/04/25</td>
                                    <td>Lunas</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>722104850002</td>
                                    <td>291001304102</td>
                                    <td>SMA Negeri 2 Bantul</td>
                                    <td>2011/05/10</td>
                                    <td>Belum Lunas</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>722104850003</td>
                                    <td>291001304103</td>
                                    <td>SMA Negeri 3 Sleman</td>
                                    <td>2011/06/15</td>
                                    <td>Lunas</td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>722104850004</td>
                                    <td>291001304104</td>
                                    <td>SMA Negeri 4 Yogyakarta</td>
                                    <td>2011/07/20</td>
                                    <td>Belum Lunas</td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>722104850005</td>
                                    <td>291001304105</td>
                                    <td>SMA Negeri 5 Wates</td>
                                    <td>2011/08/01</td>
                                    <td>Lunas</td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>722104850006</td>
                                    <td>291001304106</td>
                                    <td>SMA Negeri 6 Kulon Progo</td>
                                    <td>2011/09/10</td>
                                    <td>Belum Lunas</td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td>722104850007</td>
                                    <td>291001304107</td>
                                    <td>SMA Negeri 7 Gunungkidul</td>
                                    <td>2011/10/15</td>
                                    <td>Lunas</td>
                                </tr>
                                <tr>
                                    <td>8</td>
                                    <td>722104850008</td>
                                    <td>291001304108</td>
                                    <td>SMA Negeri 8 Yogyakarta</td>
                                    <td>2011/11/20</td>
                                    <td>Belum Lunas</td>
                                </tr>
                                <tr>
                                    <td>9</td>
                                    <td>722104850009</td>
                                    <td>291001304109</td>
                                    <td>SMA Negeri 9 Magelang</td>
                                    <td>2011/12/25</td>
                                    <td>Lunas</td>
                                </tr>
                                <tr>
                                    <td>10</td>
                                    <td>722104850010</td>
                                    <td>291001304110</td>
                                    <td>SMA Negeri 10 Surakarta</td>
                                    <td>2012/01/05</td>
                                    <td>Belum Lunas</td>
                                </tr>
                            </tbody>
                            
                        </table>
                    </div>
                </div>
            </div>
        </div>
@endsection