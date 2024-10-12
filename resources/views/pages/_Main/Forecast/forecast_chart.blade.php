<div class="apex-charts h-auto py-4" id="show_chart"></div>

<script>
  var dataActual = {{ $dataActual }};
  var dataForecast = {{ $dataForecast }};
  var dataMonth = JSON.parse('{!! $dataMonth !!}');
  var options = {
    chart: {
      height: 350,
      type: 'line',
      stacked: false,
      zoom: {
        enabled: false
      },
      stroke: {
        width: [0, 2, 4],
        curve: 'smooth'
      },
      toolbar: {
        show: false
      }
    },
    dataLabels: {
      enabled: false
    },
    stroke: {
      width: [3, 3, 4],
      curve: 'straight',
      dashArray: [0, 8, 5]
    },
    series: [{
        name: "Penjualan Aktual",
        type: "area",
        data: dataActual
      },
      {
        name: "Hasil Peramalan",
        type: "line",
        data: dataForecast
      },
    ],
    fill: {
      type: 'gradient',
      opacity: [0.85, 0.25, 1],
      gradient: {
        inverseColors: false,
        shade: 'light',
        type: "vertical",
        opacityFrom: 0.85,
        opacityTo: 0.55,
        stops: [0, 100, 100, 100]
      }
    },
    title: {
      text: 'Hasil Forecasting {{ $productName }}',
      align: 'center',
      style: {
        fontSize: '16px',
        fontWeight: 'bold',
        fontFamily: undefined,
        color: '#1a1a1a'
      },
    },
    markers: {
      size: 0,
      hover: {
        sizeOffset: 6
      }
    },
    xaxis: {
      categories: dataMonth,
    },
    tooltip: {
      y: [{
        title: {
          formatter: function(val) {
            return val + " (Penjualan Aktual)"
          }
        }
      }, {
        title: {
          formatter: function(val) {
            return val + " (Hasil Peramalan)"
          }
        }
      }]
    },
    grid: {
      borderColor: '#f1f1f1',
    }
  }

  var chart = new ApexCharts(
    document.querySelector("#show_chart"),
    options
  );

  chart.render();
</script>
