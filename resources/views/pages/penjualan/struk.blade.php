<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="{{ asset('css/struk.css') }}">
</head>

<body id="content" onafterprint="myFunction()">
    <div id="invoice-POS">
        <center id="top">
            <!-- <div class="logo"></div> -->


            <img class="logo" src="http://michaeltruong.ca/images/logo1.png">

            <div class="info">
                <h2>MAPROD</h2>
            </div>
            <!--End Info-->
        </center>
        <!--End InvoiceTop-->
        <div id="mid">
            <div class="info txtc">
                <p>
                    Jl. Raya No.1020 ABC</br>
                    Telp. 08981333393</br></br>
                    {{ \Carbon\Carbon::parse($dataTransaksi->transaction_date)->format('d F Y  h:i') }}
                </p>
            </div>
        </div>
        <!--End Invoice Mid-->
        <div id="bot">
            <div id="table">
                <table>
                    <tr class="tabletitle">
                        <td class="item txtl" width="60%">
                            <h2>Barang</h2>
                        </td>
                        <td class="Hours txtl" width="5%">
                            <h2>Jml</h2>
                        </td>
                        <td class="Rate txtr" width="35">
                            <h2>Harga</h2>
                        </td>
                    </tr>
                    @foreach ($dataListBarang as $data => $value)
                        <tr class="service">
                            <td class="tableitem" width="60%">
                                <p class="itemtext txtl">{{ $value->name }}</p>
                            </td>
                            <td class="tableitem" width="5%">
                                <p class="itemtext txtl">{{ $value->quantity }}</p>
                            </td>
                            <td class="tableitem" width="35%">
                                <p class="itemtext txtr">{{ number_format($value->price_at_buy, 2, ',', '.') }}</p>
                            </td>
                        </tr>
                    @endforeach
                    <tr class="tabletitle">
                        <td></td>
                        <td class="Rate txtl">
                            <h2>Total</h2>
                        </td>
                        <td class="payment txtr">
                            <h2>{{ number_format($dataTransaksi->total_payment, 2, ',', '.') }}</h2>
                        </td>
                    </tr>
                    <tr class="tabletitle">
                        <td></td>
                        <td class="Rate txtl">
                            <h2>Bayar</h2>
                        </td>
                        <td class="payment txtr">
                            <h2>{{ number_format($dataTransaksi->paid, 2, ',', '.') }}</h2>
                        </td>
                    </tr>
                    <tr class="tabletitle">
                        <td></td>
                        <td class="Rate txtl">
                            <h2>Kembali</h2>
                        </td>
                        <td class="payment txtr">
                            <h2>{{ number_format($dataTransaksi->return, 2, ',', '.') }}</h2>
                        </td>
                    </tr>
                </table>
            </div>
            <!--End Table-->
            <div id="legalcopy">
                <p class="legal">Terima kasih atas kunjungannya</p>
                <p class="legal">Selamat belanja kembali</p>
            </div>
        </div>
        <!--End InvoiceBot-->
    </div>
    <!--End Invoice-->
</body>

</html>
<script>
    function myFunction() {
        //  window.close();
    }
    window.print();
</script>
