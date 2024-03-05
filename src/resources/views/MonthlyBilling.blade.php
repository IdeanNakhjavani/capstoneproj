<!DOCTYPE html>
<html>

<head>
    <title>Monthly Billing List</title>

    <style type='text/css'>
        @page {
            size: landscape;
        }
    
        @media print {
            body {
                transform: rotate(-90deg);
                transform-origin: left top;
                width: 100vw;
                height: 100vh;
                overflow: auto;
                page-break-after: always;
            }
    
            
        }

        h1 {}

        th,
        td {
            padding-top: 7px;
        }

        table {
            border-collapse: collapse;
        }

        th {
            border-bottom: 2px solid black;
            border-top: 3px solid black;
            padding-right: 10px;
        }

        td {
            text-align: center;
            padding-right: 8px
        }

        footer {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 10px;
        }

        .date {
            text-align: left;
        }

        .page-number {
            text-align: right;
        }

        @media print {
            footer {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                padding: 10px;
                text-align: right;
            }

            table tfoot tr td:last-child {
                padding-bottom: 30px;
            }
        }
    </style>
</head>

<body>
    <img alt="logo" width="250" height="auto" src="../public/images/logo.jpg" class="egg" />
    <br>
    <h3 class="title" style="text-align: center;">Monthly Billing List for <?php echo date('F'); ?></h3>
    <span style="font-size: 11px"><b>&nbsp;&nbsp;&nbsp;&nbsp;
        Div. of: Interior Technical Services Ltd.</b>
    </span>

    <table style="width:100%; font-size: 13px;">
        <thead>
            <tr>
                <th>SMP #</th>
                <th>Customer Name</th>
                <th>Building Reference</th>
                <th>Payment Date</th>
                <th>Installments</th>
                <th>Term</th>
                <th>Yearly Price</th>
                <th>Billing Amount</th>
                <th>Stop Date</th>
                <th>Updates On</th>
            </tr>
        </thead>
        <tbody>
            <?php $total2 = 0; ?>
            @foreach ($payment_dates as $payment)
                <tr>
                    <td>{{ $payment['SMP'] }}</td>
                    <td>{{ $payment['customer'] }}</td>
                    <td>{{ $payment['building'] }}</td>
                    <td>{{ $payment['payment_date'] }}</td>
                    <td>
                        @if ($payment['installments'] == 1)
                          Yearly
                        @elseif ($payment['installments'] == 2)
                          Biannually
                        @elseif ($payment['installments'] == 4)
                          Quarterly
                        @elseif ($payment['installments'] == 12)
                          Monthly
                        @endif
                      </td>
                      
                    <td>{{ $payment['Term'] }}</td>


                    <td>${{ number_format($payment['amount'], 2) }}</td>
                    <td>${{ number_format($payment['billing_amount'], 2) }}</td>

                    <td>{{ date('d-M-Y', strtotime($payment['ContractEndDate'])) }}</td>

                    <td>{{ $payment['UpdateDate'] }}</td>



                </tr>
                <?php $total2 += $payment['billing_amount']; ?>
            @endforeach

        </tbody>
        <tfoot>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td style="color: blue;"><b>Total <?php echo date('F'); ?> Billing Amount:</b></td>
                <td style="border-top: 1.5px solid black; border-bottom: 5px double;">${{ $total2 }}</td>
            </tr>
        </tfoot>
    </table>
    <footer>
        <div class="date">
            <div id="current_date"></div>

            <script>
                var date = new Date();
                var options = { weekday: 'long', month: 'long', day: 'numeric', year: 'numeric' };
                var formattedDate = date.toLocaleDateString('en-US', options);
                document.getElementById("current_date").textContent = formattedDate;
            </script>
        </div>

        <div class="page-number">
            <div id="page_number"></div>

            <script>
                var currentPage = 1;
            
                function updatePageNumber() {
                    var totalPages = document.querySelectorAll('.page').length;
                    document.getElementById("page_number").innerHTML = "Page " + currentPage + " of " + totalPages;
                }
            
                window.onload = function() {
                    updatePageNumber();
                }
            
                document.addEventListener("DOMContentLoaded", function() {
                    document.addEventListener("afterrender", function() {
                        currentPage++;
                        updatePageNumber();
                    });
                });
            </script>
        </div>
    </footer>
</body>

</html>
