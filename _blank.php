<?php
include_once("header.php");
?>
<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-lg">
        <div class="nk-content-body">
            <div class="row">
                <div class="col-12">
                    <div class="card card-border">
                        <div class="card-inner">
                            What is the Charles Name?<br>
                            <?php
                            $query = mysqli_query($conn, "SELECT * FROM members LIMIT 1");
                            $charles_name = mysqli_fetch_assoc($query)['member_name'];
                            echo $charles_name;
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include_once("footer.php");
?>
<script>
    const ctx = document.getElementById('solidLineChart').getContext('2d');
    const myChart = new Chart(ctx, {
        type: 'line',
        data: {
            datasets: [{
                    type: 'line',
                    label: 'USDT TRC-20',
                    data: [100000, 135000, 140000, 120000, 150000, 159999, 200000],
                    //data: plTrc,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)'
                }, {
                    type: 'line',
                    label: 'USDT ERC-20',
                    data: [90000, 95000, 100000, 120000, 130000, 119999, 130000],
                    //data: plErc,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)'
                }
                /*, {
                                type: 'bar',
                                label: 'MYR',
                                data: [200000, 275000, 300000, 360000, 390000, 339999, 390000],
                                //data: plMyr,
                                backgroundColor: '#36A2EB',
                                borderColor: '#36A2EB'
                            }*/
            ],
            labels: [1, 2, 3, 4, 5, 6, 7]
        },
        options: {}
    });

    function test() {
        alert("Eat my shit!");
    }
</script>