<canvas id="myChart1"></canvas>
<script type="text/javascript" src="https://www.chartjs.org/samples/latest/utils.js"></script>
<script>

var MONTHS = [];

var labels = [];

for(var i = 1; i<= {{$day}}; i++){
    //MONTHS.push(i)
    labels.push('{{$month}}.'+i)
}

var data = {
    labels: labels,
    datasets: [{
        label: '当月当天',
        backgroundColor: window.chartColors.red,
        borderColor: window.chartColors.red,
        data: [
            randomScalingFactor(),
            randomScalingFactor(),
            randomScalingFactor(),
            randomScalingFactor(),
            randomScalingFactor(),
            randomScalingFactor(),
            randomScalingFactor()
        ],
        fill: false,
    }, {
        label: '上月当天',
        fill: false,
        backgroundColor: window.chartColors.blue,
        borderColor: window.chartColors.blue,
        data: [
            randomScalingFactor(),
            randomScalingFactor(),
            randomScalingFactor(),
            randomScalingFactor(),
            randomScalingFactor(),
            randomScalingFactor(),
            randomScalingFactor()
        ],
    }]
}

var options = {

    responsive: true,

    title: {
        display: true,
        text: '用户本月与上月同比增长量'
    },
    tooltips: {
        mode: 'index',
        intersect: false,
    },
    hover: {
        mode: 'nearest',
        intersect: true
    },
    scales: {
        xAxes: [{
            display: true,
            scaleLabel: {
                display: true,
                labelString: '天数'
            }
        }],
        yAxes: [{
            display: true,
            scaleLabel: {
                display: true,
                labelString: '增长量'
            }
        }]
    }
}

window.onload = function() {
    var ctx = document.getElementById('myChart1').getContext('2d');
    var myLineChart = new Chart(ctx, {type: 'line', data: data, options: options});
    //window.myLine = new Chart(ctx, config);
};

</script>