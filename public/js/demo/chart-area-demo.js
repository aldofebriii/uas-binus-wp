// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';
const SELECTED_VALAS = "AMERIKA"

window.addEventListener('DOMContentLoaded', async function(e) {
    const valasRes = await fetch('http://localhost:8000/api/report-valas/' + SELECTED_VALAS, {
        method:'GET',
        headers: {'Content-Type': 'application/json'}
    });

    const transaksiRes = await fetch('http://localhost:8000/api/report-transaksi', {
        method: 'GET',
        headers: {'Content-Type': 'application/json'}
    });

    if(valasRes.status !== 200 || transaksiRes.status !== 200) throw new Error('Something went wrong');

    const data1 = await valasRes.json();
    const data2 = await transaksiRes.json();

    const chartValasLabel = data1.map(d => d.tanggal_rate);
    const chartValasJual = data1.map(d => d.nilai_jual);
    const chartValasBeli = data1.map(d => d.nilai_beli);

    const memberData = data2.member;
    const totalData = data2.total;

    const memberLabel = memberData.map(m =>  m.membership);
    const memberProfit = memberData.map(m => m.profit);

    const totalProfit = totalData.profit;
    this.document.getElementById('total-profit').textContent = totalProfit;
    this.document.querySelectorAll('#loaded-valas option').forEach(o => {
        if(o.value === SELECTED_VALAS) {
            o.selected = true;
        };
    });
    // Area Chart 
    var ctx = document.getElementById("myAreaChart");
    const chart1 = new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartValasLabel,
            datasets: [{
                label: "Nilai Jual",
                lineTension: 0.3,
                backgroundColor: "rgba(78, 115, 223, 0.05)",
                borderColor: "rgba(78, 115, 223, 1)",
                pointRadius: 3,
                pointBackgroundColor: "rgba(78, 115, 223, 1)",
                pointBorderColor: "rgba(78, 115, 223, 1)",
                pointHoverRadius: 3,
                pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                pointHitRadius: 10,
                pointBorderWidth: 2,
                data: chartValasJual,
            }, {
                label: "Nilai Beli",
                lineTension: 0.3,
                backgroundColor: "rgba(78, 115, 223, 0.05)",
                borderColor: "#1cc88a",
                pointRadius: 3,
                pointBackgroundColor: "#1cc88a",
                pointBorderColor: "#1cc88a",
                pointHoverRadius: 3,
                pointHoverBackgroundColor: "#1cc88a",
                pointHoverBorderColor: "#1cc88a",
                pointHitRadius: 10,
                pointBorderWidth: 2,
                data: chartValasBeli,
            }],
        },
        options: {
            maintainAspectRatio: false,
            layout: {
            padding: {
                left: 10,
                right: 25,
                top: 25,
                bottom: 0
            }
            },
            scales: {
            xAxes: [{
                time: {
                unit: 'date'
                },
                gridLines: {
                display: false,
                drawBorder: false
                },
                ticks: {
                maxTicksLimit: 7
                }
            }],
            yAxes: [{
                ticks: {
                maxTicksLimit: 5,
                padding: 10
                },
                gridLines: {
                color: "rgb(234, 236, 244)",
                zeroLineColor: "rgb(234, 236, 244)",
                drawBorder: false,
                borderDash: [2],
                zeroLineBorderDash: [2]
                }
            }],
            },
            legend: {
            display: true
            },
            tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            titleMarginBottom: 10,
            titleFontColor: '#6e707e',
            titleFontSize: 14,
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            intersect: false,
            mode: 'index',
            caretPadding: 10
            }
        }
    });
    //Pie Chart
    var ctx2 = document.getElementById("myPieChart");
    new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: memberLabel,
            datasets: [{
            data: memberProfit,
            backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
            hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
            hoverBorderColor: "rgba(234, 236, 244, 1)",
            }],
        },
        options: {
            maintainAspectRatio: false,
            tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                caretPadding: 10,
            },
            legend: {
                display: true
            },
            cutoutPercentage: 80,
        },
    });

    //Change chart
    this.document.querySelector('#loaded-valas').addEventListener('change', async (e) => {
        const valasRes = await fetch('http://localhost:8000/api/report-valas/' + e.target.value, {
            method:'GET',
            headers: {'Content-Type': 'application/json'}
        });
        const data1 = await valasRes.json();

        const chartValasLabel = data1.map(d => d.tanggal_rate);
        const chartValasJual = data1.map(d => d.nilai_jual);
        const chartValasBeli = data1.map(d => d.nilai_beli);

        chart1.data.labels = chartValasLabel;
        chart1.data.datasets[0].data = chartValasJual;
        chart1.data.datasets[1].data = chartValasBeli;

        chart1.update();
    })
});