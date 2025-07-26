<html lang='en-US'>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Highcharts Demo</title>
    
    <style>
      #container {
    height: 420px; 
}

.highcharts-figure, .highcharts-data-table table {
    min-width: 360px; 
    max-width: 820px;
	margin: 1em auto;
	font-size: 0.9em;
    font-family: Verdana, sans-serif;
}

.highcharts-data-table table {
	font-family: Verdana, sans-serif;
	border-collapse: collapse;
	border: 1px solid #EBEBEB;
	margin: 10px auto;
	text-align: center;
	width: 100%;
	max-width: 500px;
}
.highcharts-data-table caption {
    padding: 1em 0;
    font-size: 1.2em;
    color: #555;
}
.highcharts-data-table th {
	font-weight: 600;
    padding: 0.5em;
}
.highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
    padding: 0.5em;
}
.highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
    background: #f8f8f8;
}
.highcharts-data-table tr:hover {
    background: #f1f7ff;
}

    </style>

  </head>
  <body>
<script src="js6/highcharts.js"></script>
<script src="js6/modules/exporting.js"></script>
<script src="js6/modules/accessibility.js"></script>
<script src="js6/themes/sunset.js"></script>

<!--
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script src="https://code.highcharts.com/themes/sunset.js"></script>
-->
<figure class="highcharts-figure">
    <div id="container"></div>


</figure>


    <script>
    function dollarFormat(x) {
    return '$' + Highcharts.numberFormat(x, 0, '.', ',');
}

var colors = Highcharts.getOptions().colors;

Highcharts.chart('container', {
    chart: {
        type: 'column'
    },

    accessibility: {
        series: {
            descriptionFormatter: function (series) {
                return series.type === 'line' ?
                    series.name + ', ' + dollarFormat(series.points[0].y) :
                    series.name + ' grant amounts, bar series with ' +
                    series.points.length + ' bars.';
            }
        },
        point: {
            valuePrefix: '$'
        },
        keyboardNavigation: {
            seriesNavigation: {
                mode: 'serialize'
            }
        }
    },

    title: {
        text: 'SIGAR',
        margin: 35
    },

    subtitle: {
        text: 'Consulta'
    },

    xAxis: {
        visible: false,
        accessibility: {
            description: 'Grant applicants',
            rangeDescription: ''
        }
    },

    yAxis: [{
        min: 0,
        max: 300000,
        labels: {
            format: '${text}'
        },
        title: {
            text: 'Grant amount'
        },
        gridLineWidth: 1
    }, {
        accessibility: {
            description: 'Grant category totals'
        },
        opposite: true,
        min: 0,
        max: 300000,
        gridLineWidth: 0,
        labels: {
            format: '${text}',
            style: {
                color: '#8F6666'
            }
        },
        title: {
            text: 'Category total',
            style: {
                color: '#8F6666'
            }
        }
    }],

    credits: {
        enabled: false
    },

    plotOptions: {
        column: {
            keys: ['name', 'y'],
            grouping: false,
            pointPadding: 0.1,
            groupPadding: 0,
            tooltip: {
                headerFormat: '<span style="font-size: 10px">' +
                    '<span style="color:{point.color}">\u25CF</span> ' +
                    '{series.name}</span><br/>',
                pointFormat: '{point.name}: <b>${point.y:,.0f}</b><br/>'
            }
        },
        line: {
            yAxis: 1,
            lineWidth: 5,
            accessibility: {
                exposeAsGroupOnly: true
            },
            marker: {
                enabled: false
            },
            enableMouseTracking: false,
            linkedTo: ':previous',
            dataLabels: {
                enabled: true,
                verticalAlign: 'bottom',
                style: {
                    color: '#757575',
                    fontWeight: 'normal'
                },
                formatter: function () {
                    if (this.point === this.series.points[Math.floor(
                        this.series.points.length / 2
                    )]) {
                        return 'Totales: $' + Highcharts.numberFormat(this.y, 0);
                    }
                }
            }
        }
    },

    responsive: {
        rules: [{
            condition: {
                maxWidth: 400
            },
            chartOptions: {
                chart: {
                    spacingLeft: 3,
                    spacingRight: 5
                },
                yAxis: [{}, {
                    visible: false
                }]
            }
        }]
    },

    series: [{
        name: 'Creative Space (CRSP)',
        color: colors[0],
        borderColor: '#A59273',
        borderWidth: 1,
        data: [
            ['Pago de Peajes', 50000],
            ['Alimentacion', 50000],
            ['Celular', 50000],
            ['Servicios Publicos', 50000]
        ]
    }, {
        type: 'line',
        name: 'Creative Space (CRSP) grant totals',
        data: [
            200000, 200000, 200000, 200000
        ],
        color: colors[0]
    }, {
        name: 'Cultural Center',
        color: '#EC6E65',
        data: [
            ['Asian Pacific Islander Cultural Center', 50000],
            ['Queer Cultural Center', 40000],
            ['Bayview Opera House Ruth Williams Memorial Theater', 30000],
            ['African American Art and Culture Complex', 20000]
        ],
        pointStart: 10
    }, {
        type: 'line',
        name: 'Cultural Center grant totals',
        data: [
            140000, 140000, 140000, 140000
        ],
        pointStart: 10,
        color: '#EC6E65'
    }]
});

    </script>

  </body>
</html>